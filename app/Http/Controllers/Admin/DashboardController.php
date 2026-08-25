<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();
        $activityLogsCount = Activity::count();
        $unreadNotificationsCount = auth()->user()->unreadNotifications->count();
        $settingsCount = Setting::count();

        // Get recent activities
        $recentActivities = Activity::with('causer')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'rolesCount',
            'permissionsCount',
            'activityLogsCount',
            'unreadNotificationsCount',
            'settingsCount',
            'recentActivities'
        ));
    }
}
