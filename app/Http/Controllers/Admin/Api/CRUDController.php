<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
            $active = $request->get("active");
            $request->merge(["hidden" => !$active]);
            $testimonial->update($request->only(["content", "author", "position", "hidden"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }

    public function updateProject(Request $request, Project $project)
    {
        try {
            $active = $request->get("active");
            $featured = $request->has("featured") && ($request->get("featured") === 'on');
            $request->merge(["hidden" => !$active, "featured" => $featured]);
            $project->update($request->only(["role", "title", "description", "featured", "links", "hidden"]));
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
