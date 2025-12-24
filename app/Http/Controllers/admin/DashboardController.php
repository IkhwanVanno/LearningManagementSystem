<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\ClassMember;
use App\Models\Exercise;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalUsers = User::count();
        $totalStudents = User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        })->count();
        $totalMentors = User::whereHas('role', function ($q) {
            $q->where('name', 'mentor');
        })->count();
        $totalClasses = ClassRoom::count();
        $activeClasses = ClassRoom::whereHas('status', function ($q) {
            $q->where('name', 'active');
        })->count();
        $totalExercises = Exercise::count();

        // Recent Users (last 5)
        $recentUsers = User::with('role')
            ->latest()
            ->take(5)
            ->get();

        // Class Statistics
        $classStats = ClassRoom::with('status')
            ->select('status_id', DB::raw('count(*) as total'))
            ->groupBy('status_id')
            ->get();

        // Monthly User Registration (last 6 months)
        $monthlyUsers = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Class Member Distribution
        $memberDistribution = ClassMember::with('classRoom')
            ->select('class_id', DB::raw('count(*) as total'))
            ->groupBy('class_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalMentors',
            'totalClasses',
            'activeClasses',
            'totalExercises',
            'recentUsers',
            'classStats',
            'monthlyUsers',
            'memberDistribution'
        ));
    }
}