<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{

    // todo: implement image,uploading/compressing
    // todo: check portfolio admin pages, page title
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function storeService(Request $request)
    {
        try {
            $slug = $request->get('slug');
            $existingService = Service::where('slug', $slug)->first();
            if ($existingService) {
                throw new \Exception("A service with same slug already exists!");
            }

            $order = $request->get('order');
            $existingService = Service::where('order', $order)->first();
            if ($existingService) {
                throw new \Exception("A service with same order already exists!");
            }

            $data = $request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order']);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('service-image');
            if ($image_file) {
                $data['image'] = $this->mediaService->processAsset("portfolio/services/$request->slug", $request->slug, $image_file);
            }

            Service::create($data);
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

            $slug = $request->get('slug');
            $existingService = Service::where('slug', $slug)->first();
            if ($existingService) {
                throw new \Exception("A service with same slug already exists!");
            }

            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Service::withTrashed()->where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $service->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $data = $request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order']);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('service-image');
            if ($image_file) {
                $data['image'] = $this->mediaService->processAsset("portfolio/services/$request->slug", $request->slug, $image_file);
            }

            $service->update($data);
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

            $author = $request->get('author');
            if (Testimonial::where('author', $author)->where('id', '!=', $id)->exists()) {
                throw new \Exception("A testimonial for same author already exists!");
            }

            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Testimonial::where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $testimonial->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $data = $request->only(["content", "author", "position", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('testimonial-image');
            if ($image_file) {
                $slug = Str::slug($request->get('author'));
                $data['image'] = $this->mediaService->processAsset("portfolio/testimonials/$slug", $slug, $image_file);
            }

            $testimonial->update($data);
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function storeTestimonial(Request $request)
    {
        try {
            $author = $request->get('author');
            if (Testimonial::where('author', $author)->exists()) {
                throw new \Exception("A testimonial for same author already exists!");
            }

            $order = $request->get('order');
            if (Testimonial::where('order', $order)->exists()) {
                throw new \Exception("A testimonial with same order already exists!");
            }

            $data = $request->only(["content", "author", "position", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('testimonial-image');
            if ($image_file) {
                $slug = Str::slug($request->get('author'));
                $data['image'] = $this->mediaService->processAsset("portfolio/testimonials/$slug", $slug, $image_file);
            }

            Testimonial::create($data);
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), "line" => $e->getLine()], 404);
        }
    }

    public function storeProject(Request $request)
    {
        try {
            $title = $request->get('title');
            if (Project::where('title', $title)->exists()) {
                throw new \Exception("A project with same title already exists!");
            }

            $order = $request->get('order');
            $itemToChangeOrderWith = Project::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                throw new \Exception("A project with same order already exists!");
            }

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';

            $slug = Str::slug($request->get('title'));
            $image_file = $request->file('project-image');
            if ($image_file) {
                $data['image'] = $this->mediaService->processAsset("portfolio/projects/$slug", $slug, $image_file);
            }

            Project::create($data);
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

            $title = $request->get('title');
            if (Testimonial::where('title', $title)->where('id', '!=', $id)->exists()) {
                throw new \Exception("A project with same title already exists!");
            }

            $order = $request->get('order');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Project::where('order', $order)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $project->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';

            $image_file = $request->file('project-image');
            if ($image_file) {
                $slug = Str::slug($request->get('title'));
                $data['image'] = $this->mediaService->processAsset("portfolio/projects/$slug", $slug, $image_file);
            }

            $project->update($data);
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
