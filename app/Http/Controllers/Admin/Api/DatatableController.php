<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Message;
use App\Models\Service;
use App\Models\ShortenedUrl;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\Visitor;
use App\Services\DataService;
use Illuminate\Http\Request;
use App\Models\Project;

class DatatableController extends Controller
{

    function __construct(private DataService $dataService)
    {

    }

    //region User Interaction
    public function messages(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $messages = Message::query();
        $messages = $this->dataService->userOrderBy($messages, $userSorting);
        return $this->toDatatable($messages);
    }

    public function subscriptions(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $subscriptions = Subscriber::query();
        $subscriptions = $this->dataService->userOrderBy($subscriptions, $userSorting);
        return $this->toDatatable($subscriptions);
    }

    public function visitors(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $visitors = Visitor::query();
        $visitors = $this->dataService->userOrderBy($visitors, $userSorting);
        return $this->toDatatable($visitors);
    }
    //endregion

    //region Portfolio
    public function testimonials(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $testimonials = Testimonial::query();
        $testimonials = $this->dataService->userOrderBy($testimonials, $userSorting, ['active' => 'asc']);
        return $this->toDatatable($testimonials);
    }

    public function projects(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $projects = Project::query();
        $projects = $this->dataService->userOrderBy($projects, $userSorting, ['active' => 'asc', 'featured' => 'asc']);
        return $this->toDatatable($projects);
    }

    public function services(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $services = Service::query();
        $services = $this->dataService->userOrderBy($services, $userSorting, ['active' => 'asc']);
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

        $userSorting = $request->get('user-sorting');
        $menus = $this->dataService->userOrderBy($menus, $userSorting, ['active' => 'asc']);
        return $this->toDatatable($menus);
    }

    public function menuTypes(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $menuTypes = MenuType::withCount('menus');
        $menuTypes = $this->dataService->userOrderBy($menuTypes, $userSorting, ['active' => 'asc']);
        if ($request->has('api')) {
            return ["data" => $menuTypes->get()];
        }
        return $this->toDatatable($menuTypes);
    }
    //endregion

    public function shortenedUrls(Request $request)
    {
        $userSorting = $request->get('user-sorting');
        $shortened_urls = ShortenedUrl::query();
        $shortened_urls = $this->dataService->userOrderBy($shortened_urls, $userSorting, ['active' => 'asc']);
        return $this->toDatatable($shortened_urls);
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
