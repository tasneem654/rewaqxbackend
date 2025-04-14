<?php

namespace App\Http\Controllers;
use App\Models\User;  
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function show($id)
  {
      $user = User::with('profile', 'points')->find($id);
      
      if (!$user) {
          return response()->json(['message' => 'User not found'], 404);
      }
  
      return response()->json([
          'name' => $user->profile->name ?? 'User',
          'points' => $user->points->totalPoints ?? 0,
          'role' => $user->profile->role ?? 'employee',
          'department' => $user->profile->department ?? 'company',
      ]);
  }
}
