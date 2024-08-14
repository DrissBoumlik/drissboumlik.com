<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SharedController extends Controller
{
    public function messages(Request $request)
    {
        $messages = Message::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $messages = $messages->orderBy('id', 'desc');
        }
        return DataTables::eloquent($messages)->make(true);
    }

    public function subscriptions(Request $request)
    {
        $subscriptions = Subscriber::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $subscriptions = $subscriptions->orderBy('id', 'desc');
        }
        return DataTables::eloquent($subscriptions)->make(true);
    }
}
