<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::with('profile', 'points')->get();
        
        $formattedUsers = $users->map(function($user) {
            $imageUrl = $user->profile->image 
                ? url('/images/' . $user->profile->image)
                : null;
                
            return [
                'id' => $user->id,
                'name' => $user->profile->name ?? 'User',
                'points' => $user->points->totalPoints ?? 0,
                'role' => $user->profile->role ?? 'employee',
                'department' => $user->profile->department ?? 'company',
                'image' => $imageUrl,
            ];
        });
        
        return response()->json($formattedUsers);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::with('profile', 'points')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $imageUrl = $user->profile->image
            ? url('/images/' . $user->profile->image)
            : null;
            
        return response()->json([
            'name' => $user->profile->name ?? 'User',
            'points' => $user->points->totalPoints ?? 0,
            'role' => $user->profile->role ?? 'employee',
            'department' => $user->profile->department ?? 'company',
            'image' => $imageUrl,
        ]);
    }
}