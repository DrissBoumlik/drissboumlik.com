<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{

    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function storeService(Request $request)
    {
        try {

            $request->validate([
                "slug"          => "required|unique:services,slug",
                "title"         => "required|string",
                "link"          => "required|string",
                "icon"          => "required|string",
                "order"         => "required|integer|min:1|unique:services,order",
                "description"   => "required|string",
            ]);

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

            $request->validate([
                "slug"          => ["nullable", "string", Rule::unique('services')->ignore($id)],
                "title"         => "nullable|string",
                "link"          => "nullable|string",
                "icon"          => "nullable|string",
                "order"         => "required|integer|min:1",
                "description"   => "nullable|string",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Service::withTrashed()->where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $service->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order']);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('service-image');
            if ($image_file) {
                $slug = $request->get('slug') ?? $service->slug;
                $data['image'] = $this->mediaService->processAsset("portfolio/services/$slug", $slug, $image_file);
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

            $request->validate([
                "author"    => ["nullable", "string", Rule::unique('testimonials')->ignore($id)],
                "content"   => "nullable|string",
                "position"  => "nullable|string",
                "order"     => "required|integer|min:1",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Testimonial::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $testimonial->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(["content", "author", "position", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('testimonial-image');
            if ($image_file) {
                $slug = Str::slug($request->get('author') ?? $testimonial->author);
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
            $request->validate([
                "author"    => "required|string|unique:testimonials,author",
                "content"   => "required|string",
                "position"  => "required|string",
                "order"     => "required|integer|min:1|unique:testimonials,order",
            ]);

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

            $request->validate([
                "title"         => "required|string|unique:projects,title",
                "role"          => "required|string",
                "description"   => "required|string",
                "links"         => "required|array",
                "order"         => "required|integer|min:1|unique:testimonials,order",
            ]);

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';

            $image_file = $request->file('project-image');
            if ($image_file) {
                $slug = Str::slug($request->get('title'));
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

            $request->validate([
                "title"         => ["nullable", "string", Rule::unique('projects')->ignore($id)],
                "role"          => "nullable|string",
                "description"   => "nullable|string",
                "links"         => "nullable|array",
                "order"         => "required|integer|min:1",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Project::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $project->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';

            $image_file = $request->file('project-image');
            if ($image_file) {
                $slug = Str::slug($request->get('title') ?? $project->title);
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
