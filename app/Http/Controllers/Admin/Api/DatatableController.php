<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Models\Project;

class DatatableController extends Controller
{
    public function messages(Request $request)
    {
        $messages = Message::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $messages = $messages->orderBy('id', 'desc');
        }
        return $this->toDatatable($messages, true);
    }

    public function subscriptions(Request $request)
    {
        $subscriptions = Subscriber::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $subscriptions = $subscriptions->orderBy('id', 'desc');
        }
        return $this->toDatatable($subscriptions, true);
    }

    public function visitors(Request $request)
    {
        $visitors = Visitor::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $visitors = $visitors->orderBy('id', 'desc');
        }
        return $this->toDatatable($visitors, true);
    }

    public function testimonials(Request $request)
    {
        $testimonials = Testimonial::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $testimonials = $testimonials
                ->orderBy('hidden', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($testimonials, false);
    }

    public function projects(Request $request)
    {
        $projects = Project::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $projects = $projects
                ->orderBy('hidden', 'asc')
                ->orderBy('featured', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($projects, false);
    }

    private function toDatatable($data, $withTrashed = true)
    {
        if ($withTrashed) {
            $data = $data->withTrashed();
        }
        return DataTables::eloquent($data)->make(true);
    }
}
