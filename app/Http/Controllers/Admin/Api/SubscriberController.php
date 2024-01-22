<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscriber::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $subscriptions = $subscriptions->orderBy('id', 'desc');
        }
        return DataTables::eloquent($subscriptions)->make(true);
    }
}
