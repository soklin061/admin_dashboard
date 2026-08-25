<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view-logs|show-logs', ['only' => ['index']]);
    }

    public function index()
    {
        $activities = Activity::with('causer')
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs.index', compact('activities'));
    }
}
