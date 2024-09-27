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
    //region User Interaction
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
    //endregion

    //region Portfolio
    public function testimonials(Request $request)
    {
        $testimonials = Testimonial::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $testimonials = $this->defaultOrderBy($testimonials);
        }
        return $this->toDatatable($testimonials);
    }

    public function projects(Request $request)
    {
        $projects = Project::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $projects = $this->defaultOrderBy($projects)
                            ->orderBy('featured', 'asc');
        }
        return $this->toDatatable($projects);
    }

    public function services(Request $request)
    {
        $services = Service::query();
        $is_first_time = $request->has('first_time');
        if ($is_first_time) {
            $services = $this->defaultOrderBy($services);
        }
        return $this->toDatatable($services);
    }
    //endregion

    //region Menus
    public function menus(Request $request)
    {
        $menus = Menu::join('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')
                    ->select('menus.*', 'menu_types.name as type_name');

        $menu_type = $request->get('menu_type');
        if ($menu_type) {
            $menus = $menus->where('menu_type_id', $menu_type);
        }

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
    //endregion

    private function defaultOrderBy($data)
    {
        return $data->orderBy('active', 'asc')
                    ->orderBy('id', 'desc');
    }

    private function toDatatable($data, $withTrashed = true)
    {
        try {
            if ($withTrashed) {
                $data = $data->withTrashed();
            }
        } catch (\Throwable $e) {
        }
        return datatables($data)->make(true);
    }
}
