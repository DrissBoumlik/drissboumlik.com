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
            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $testimonial->update($request->only(["content", "author", "position", "active"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateProject(Request $request, Project $project)
    {
        try {
            $active = $request->has("active") && $request->get("active") === 'on';
            $featured = $request->has("featured") && $request->get("featured") === 'on';
            $request->merge(["active" => $active, 'featured' => $featured]);
            $project->update($request->only(["role", "title", "description", "featured", "links", "active"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateService(Request $request, Service $service)
    {
        try {
            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $service->update($request->only(['slug', 'title', 'icon', 'link', 'description', 'active']));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateMenu(Request $request, Menu $menu)
    {
        try {
            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $menu->update($request->only(['text', 'title', 'slug', 'target', 'link', 'icon', 'type', 'active']));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
