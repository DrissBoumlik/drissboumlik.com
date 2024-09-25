<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{


    public function updateTestimonial(Request $request, $id)
    {
        try {
            $testimonial = Testimonial::withTrashed()->find($id);
            if ($request->has('delete')) {
                return $this->destroy($testimonial, $request);
            } elseif ($request->has('restore')) {
                $testimonial->restore();
            }

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

    public function storeTestimonial(Request $request)
    {
        try {
            $order = $request->get('order');
            $itemToChangeOrderWith = Testimonial::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                throw new \Exception("Item with same order already exists!");
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            Testimonial::create($request->only(["content", "author", "position", "active", "order"]));
            return ['msg' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }



    public function updateProject(Request $request, $id)
    {
        try {
            $project = Project::withTrashed()->find($id);
            if ($request->has('delete')) {
                return $this->destroy($project, $request);
            } elseif ($request->has('restore')) {
                $project->restore();
            }

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

    private function destroy($item, $request)
    {
        try {
            if ($item === null) {
                return response()->json(['msg' => 'Item not found'], 404);
            }
            if ($request->has('delete')) {
                $item->update(['active' => false]);
                $item->delete();
                return response()->json(['msg' => 'Item deleted successfully'], 200);
            }
//            $project->forceDelete();
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 422);
        }
    }

    public function storeProject(Request $request)
    {
        try {
            $order = $request->get('order');
            $itemToChangeOrderWith = Project::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                throw new \Exception("Item with same order already exists!");
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $featured = $request->has("featured") && $request->get("featured") === 'on';
            $request->merge(["active" => $active, 'featured' => $featured]);
            Project::create($request->only(["role", "title", "description", "featured", "links", "active", "order"]));
            return ['msg' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
