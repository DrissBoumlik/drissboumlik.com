<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
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

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        try {
            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Testimonial::where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $testimonial->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $testimonial->update($request->only(["content", "author", "position", "active", "order"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateProject(Request $request, Project $project)
    {
        try {
            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Project::where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $project->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $featured = $request->has("featured") && $request->get("featured") === 'on';
            $request->merge(["active" => $active, 'featured' => $featured]);
            $project->update($request->only(["role", "title", "description", "featured", "links", "active", "order"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateService(Request $request, Service $service)
    {
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

    public function updateMenu(Request $request, Menu $menu)
    {
        try {
            $order = $request->get('order');
            $menu_type_id = $request->get('menu_type');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Menu::withTrashed()->where('order', $order)
                                                ->where('menu_type_id', $menu_type_id)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $menu->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $request->merge(["menu_type_id" => $request->get('menu-type')]);
            $menu->update($request->only(['text', 'title', 'slug', 'target', 'link', 'icon', 'menu_type_id', 'active', 'order']));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
