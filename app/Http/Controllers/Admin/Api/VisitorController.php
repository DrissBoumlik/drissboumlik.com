<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $visitors = Visitor::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $visitors = $visitors->orderBy('id', 'desc');
        }
        return DataTables::eloquent($visitors)->make(true);
    }

    public function update(Request $request, Visitor $visitor)
    {
        try {
            $visitor->update($request->only(["countryName", "countryCode", "regionName", "cityName"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
