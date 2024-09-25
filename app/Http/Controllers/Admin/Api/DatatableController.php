<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Message;
use App\Models\Service;
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
        return $this->toDatatable($messages);
    }

    public function subscriptions(Request $request)
    {
        $subscriptions = Subscriber::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $subscriptions = $subscriptions->orderBy('id', 'desc');
        }
        return $this->toDatatable($subscriptions);
    }

    public function visitors(Request $request)
    {
        $visitors = Visitor::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $visitors = $visitors->orderBy('id', 'desc');
        }
        return $this->toDatatable($visitors);
    }

    public function testimonials(Request $request)
    {
        $testimonials = Testimonial::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $testimonials = $testimonials
                ->orderBy('active', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($testimonials);
    }

    public function projects(Request $request)
    {
        $projects = Project::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $projects = $projects
                ->orderBy('active', 'asc')
                ->orderBy('featured', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($projects);
    }

    public function services(Request $request)
    {
        $services = Service::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $services = $services
                ->orderBy('active', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($services);
    }

    public function menus(Request $request)
    {
        $menus = Menu::join('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')
                    ->select('menus.*', 'menu_types.name as type_name');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $menus = $menus
                ->orderBy('active', 'asc')
                ->orderBy('id', 'desc');
        }
        return $this->toDatatable($menus);
    }

    public function menuTypes(Request $request)
    {
        $menuTypes = MenuType::withCount('menus');
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $menuTypes = $menuTypes
                ->orderBy('active', 'asc')
                ->orderBy('id', 'desc');
        }
        if ($request->has('api')) {
            return ["data" => $menuTypes->get()];
        }
        return $this->toDatatable($menuTypes);
    }

    private function toDatatable($data, $withTrashed = true)
    {
        if ($withTrashed) {
            $data = $data->withTrashed();
        }
        return datatables($data)->make(true);
    }
}
