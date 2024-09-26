<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{

    public function storeService(Request $request)
    {
        try {
            $order = $request->get('order');
            $itemToChangeOrderWith = Service::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                throw new \Exception("Item with same order already exists!");
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            Service::create($request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order']));
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            $service = Service::withTrashed()->find($id);
            if ($request->has('delete')) {
                return $this->destroy($service, $request);
            } elseif ($request->has('restore')) {
                $service->restore();
            }

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
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

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
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
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
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
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
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
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
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    private function destroy($item, $request)
    {
        try {
            if ($item === null) {
                return response()->json(['message' => 'Item not found'], 404);
            }
            if ($request->has('delete')) {
                $item->update(['active' => false]);
                $item->delete();
                return response()->json(['message' => 'Item deleted successfully'], 200);
            }
//            $item->forceDelete();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

}
