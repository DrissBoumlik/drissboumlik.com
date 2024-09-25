<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
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

    private function destroy($project, $request)
    {
        try {
            if ($project === null) {
                return response()->json(['msg' => 'Project not found'], 404);
            }
            if ($request->has('delete')) {
                $project->update(['active' => false]);
                $project->delete();
                return response()->json(['msg' => 'Project deleted successfully'], 200);
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
            return ['msg' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['msg' => $e->getMessage()], 404);
        }
    }
}
