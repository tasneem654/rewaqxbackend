<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalReactions = Reaction::count();
        $totalComments = Comment::count();

        // Active vs Inactive users based on 'isAuthenticated'
        $activeUsers = User::where('isAuthenticated', true)->count();
        $inactiveUsers = $totalUsers - $activeUsers;
        $activePercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

        // Fetching all users along with their profile and points
        $users = User::with(['profile', 'points'])->get();

        // Return the view with all the required data
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPosts',
            'totalReactions',
            'totalComments',
            'activePercentage',
            'users'
        ));
    }
}
