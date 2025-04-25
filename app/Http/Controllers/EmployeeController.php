<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Points;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
{
    $query = User::with(['profile', 'points'])->orderBy('id');

    if ($request->has('search')) {
      $search = $request->input('search');

      $query->where(function ($q) use ($search) {
          $q->where('email', 'like', "%{$search}%")
            ->orWhereHas('profile', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhere('role', 'like', "%{$search}%");
            });
      });
  }
  

    $employees = $query->get();

    return view('admin.empManagement', compact('employees'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
            'points' => 'nullable|integer|min:0', // Add points validation
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'isManager' => false
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_images', 'public');
            }

            Profile::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'department' => $request->department,
                'role' => $request->role,
                'dateOfBirth' => $request->dateOfBirth,
                'image' => $imagePath,
            ]);

                // Create points record
            Points::create([
              'user_id' => $user->id,
              'totalPoints' => $request->points ?? 0
          ]);
        });

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit($id)
    {
        $employee = User::with('profile')->findOrFail($id);
        
        if(request()->wantsJson()) {
            return response()->json([
                'id' => $employee->id,
                'name' => optional($employee->profile)->name,
                'email' => $employee->email,
                'department' => optional($employee->profile)->department,
                'role' => optional($employee->profile)->role,
                'dateOfBirth' => optional($employee->profile)->dateOfBirth,
                'isManager' => $employee->isManager,
                'image' => optional($employee->profile)->image ? asset('storage/' . $employee->profile->image) : null
            ]);
        }
        
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::transaction(function () use ($request, $id) {
            $user = User::findOrFail($id);
            $user->update(['email' => $request->email]);

            $profileData = [
                'name' => $request->name,
                'department' => $request->department,
                'role' => $request->role,
                'dateOfBirth' => $request->dateOfBirth
            ];

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->profile && $user->profile->image) {
                    Storage::disk('public')->delete($user->profile->image);
                }
                $profileData['image'] = $request->file('image')->store('profile_images', 'public');
            }

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
        });

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::with('profile')->findOrFail($id);

        // Delete old image if exists
        if ($user->profile && $user->profile->image) {
            Storage::disk('public')->delete($user->profile->image);
        }

        $imagePath = $request->file('image')->store('profile_images', 'public');
        
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['image' => $imagePath]
        );

        return response()->json([
            'success' => true,
            'image_url' => asset('storage/' . $imagePath)
        ]);
    }

    public function toggleManager(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->isManager = $request->input('isManager') ? 1 : 0;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
{
    DB::transaction(function () use ($id) {
        $user = User::findOrFail($id);
        if ($user->profile && $user->profile->image) {
            Storage::disk('public')->delete($user->profile->image);
        }
        $user->profile()->delete();
        $user->delete();
        $user->points()->delete(); // Add this line

    });

    if (request()->wantsJson()) {
        return response()->json(['success' => true]);
    }

    return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
}

}