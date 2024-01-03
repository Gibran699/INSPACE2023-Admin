<?php

namespace App\Http\Controllers;

use App\Exports\ActivityLogExport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (auth()->guard('comittee')->user()->isWebDev()) {
            return view('activitylog.index', ['title' => 'Activity Log', 'activity_logs' => ActivityLog::latest()->get()]);
        }
    }

    public function export()
    {
        if (auth()->guard('comittee')->user()->isWebDev()) {
            return Excel::download(new ActivityLogExport, 'activity.xlsx');
        }
    }

    public function deleteAll()
    {
        if (auth()->guard('comittee')->user()->isWebDev()) {
            ActivityLog::truncate();
            return back()->with('success', 'Delete All Logs Record Successfully');
        }
    }
}
