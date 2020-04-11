<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ActivityDetailResource;
use App\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(ActivityLog $data, Request $request)
    {
        $query = $data;

        $per_page = 10;
        $sort_by = "created_at";
        $direction = "desc";

        if($request->has('limit')){
            $per_page = $request('limit');
        }

        if($request->has('sort')){
            $sort_by = $request->sort;
        }

        if($request->has('direction')){
            $direction = $request->direction;
        }

        if($request->has('user')) {
            $query = $data->where('causer_id', $request->user);
        }

        $query =  $query->whereNotNull('causer_id')->orderBy($sort_by, $direction)->paginate($per_page);

        return ActivityResource::collection($query);
    }

    public function show($id)
    {
        try {
            $data = ActivityLog::find($id);
            $status = true;
            $message = "found_row";
            $row = $data;
        } catch (Exeception $th) {
            $status = false;
            $message = "not_found";
            $row = null;
        }
        
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => empty($row) ? null : new ActivityDetailResource($row)
        ]);
    }
}
