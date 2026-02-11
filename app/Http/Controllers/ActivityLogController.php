<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()
            ->when(request('search'), function ($q) {
                $q->where('aksi', 'like', '%' . request('search') . '%')
                    ->orWhere('user_name', 'like', '%' . request('search') . '%');
            })
            ->when(request('role'), function ($q) {
                $q->where('role', request('role'));
            })
            ->paginate(15);

        return view('activity.index', compact('logs'));
    }
}
