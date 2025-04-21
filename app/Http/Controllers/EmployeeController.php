<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // عرض جميع الموظفين
    public function index()
    {
        // استرجاع جميع الموظفين (يمكنك إضافة التصفية مثل is_admin)
        $employees = User::all(); 
        return view('admin.empManagement', compact('employees')); // عرض البيانات في الـ Blade
    }

    // عرض صفحة إنشاء موظف جديد
    public function create()
    {
        return view('admin.createEmployee'); // صفحة لكتابة بيانات الموظف الجديد
    }

    // تخزين موظف جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // إنشاء الموظف في قاعدة البيانات
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => false, // عدم إعطائه صلاحية "مدير"
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
    }

    // عرض صفحة تعديل بيانات موظف
    public function edit($id)
    {
        $employee = User::findOrFail($id); // جلب بيانات الموظف حسب الـ ID
        return view('admin.editEmployee', compact('employee')); // عرض البيانات في صفحة التعديل
    }

    // تحديث بيانات الموظف
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id, // التحقق من عدم تكرار الإيميل
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    // حذف موظف من قاعدة البيانات
    public function destroy($id)
    {
        $employee = User::findOrFail($id); // جلب الموظف
        $employee->delete(); // حذف الموظف

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
