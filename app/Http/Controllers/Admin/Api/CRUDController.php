<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Visitor;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    public function updateVisitor(Request $request, Visitor $visitor)
    {
        try {
            $visitor->update($request->only(["countryName", "countryCode", "regionName", "cityName"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateService(Request $request, Service $service)
    {
        try {
            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Service::withTrashed()->where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $service->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $service->update($request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order']));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateMenuType(Request $request, MenuType $menuType)
    {
        try {
            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $menuType->update($request->only(['name', 'slug', 'description', 'active']));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

}
