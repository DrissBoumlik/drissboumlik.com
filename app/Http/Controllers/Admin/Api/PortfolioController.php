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
use Symfony\Component\HttpFoundation\Response;

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

            $data = $request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order', 'note']);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('service-image');
            if ($image_file) {
                $data['image'] = $this->mediaService->processAsset("portfolio/services/$request->slug", $request->slug, $image_file);
            }

            Service::create($data);
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            $service = Service::withTrashed()->find($id);

            if (! $service) {
                return response()->json(['message' => 'Service not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->has('delete') || $request->has('destroy')) {
                return $this->destroy($service, $request);
            }
            if ($request->has('restore')) {
                $service->restore();
                return response()->json(['message' => 'Item restored successfully'], Response::HTTP_OK);
            }

            $request->validate([
                "slug"          => ["required", "string", Rule::unique('services')->ignore($id)],
                "title"         => "required|string",
                "link"          => "required|string",
                "icon"          => "required|string",
                "order"         => "required|integer|min:1",
                "description"   => "required|string",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Service::withTrashed()->where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $service->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(['slug', 'title', 'icon', 'link', 'description', 'active', 'order', 'note']);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('service-image');
            if ($image_file) {
                $slug = $request->get('slug') ?? $service->slug;
                $data['image'] = $this->mediaService->processAsset("portfolio/services/$slug", $slug, $image_file);
            }

            $service->update($data);
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateTestimonial(Request $request, $id)
    {
        try {
            $testimonial = Testimonial::withTrashed()->find($id);

            if (! $testimonial) {
                return response()->json(['message' => 'Testimonial not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->has('delete') || $request->has('destroy')) {
                return $this->destroy($testimonial, $request);
            }
            if ($request->has('restore')) {
                $testimonial->restore();
                return response()->json(['message' => 'Item restored successfully'], Response::HTTP_OK);
            }

            $request->validate([
                "author"    => ["required", "string", Rule::unique('testimonials')->ignore($id)],
                "content"   => "required|string",
                "position"  => "required|string",
                "order"     => "required|integer|min:1",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Testimonial::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $testimonial->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(["content", "author", "position", "active", "order", "note"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('testimonial-image');
            if ($image_file) {
                $slug = Str::slug($request->get('author') ?? $testimonial->author);
                $data['image'] = $this->mediaService->processAsset("portfolio/testimonials/$slug", $slug, $image_file);
            }

            $testimonial->update($data);
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
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

            $data = $request->only(["content", "author", "position", "active", "order", "note"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $image_file = $request->file('testimonial-image');
            if ($image_file) {
                $slug = Str::slug($request->get('author'));
                $data['image'] = $this->mediaService->processAsset("portfolio/testimonials/$slug", $slug, $image_file);
            }

            Testimonial::create($data);
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), "line" => $e->getLine()], Response::HTTP_NOT_FOUND);
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

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order", "note"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';
            if (null === $data['links']['repository'] && null === $data['links']['website']) {
                $data['links'] = null;
            }

            $image_file = $request->file('project-image');
            if ($image_file) {
                $slug = Str::slug($request->get('title'));
                $data['image'] = $this->mediaService->processAsset("portfolio/projects/$slug", $slug, $image_file);
            }

            Project::create($data);
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            $project = Project::withTrashed()->find($id);

            if (! $project) {
                return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->has('delete') || $request->has('destroy')) {
                return $this->destroy($project, $request);
            }
            if ($request->has('restore')) {
                $project->restore();
                return response()->json(['message' => 'Item restored successfully'], Response::HTTP_OK);
            }

            $request->validate([
                "title"         => ["required", "string", Rule::unique('projects')->ignore($id)],
                "role"          => "required|string",
                "description"   => "required|string",
                "links"         => "nullable|array|min:1",
                "links.*"       => "nullable|string|url",
                "order"         => "required|integer|min:1",
            ]);

            $order = $request->get('order');
            $itemToChangeOrderWith = Project::where('order', $order)->first();
            if ($itemToChangeOrderWith) {
                $itemToChangeOrderWith->order = $project->order;
                $itemToChangeOrderWith->update();
            }

            $data = $request->only(["role", "title", "description", "featured", "links", "active", "order", "note"]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';
            $data['featured'] = $request->has("featured") && $request->get("featured") === 'on';
            if (null === $data['links']['repository'] && null === $data['links']['website']) {
                $data['links'] = null;
            }

            $image_file = $request->file('project-image');
            if ($image_file) {
                $slug = Str::slug($request->get('title') ?? $project->title);
                $data['image'] = $this->mediaService->processAsset("portfolio/projects/$slug", $slug, $image_file);
            }

            $project->update($data);
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    private function destroy($item, $request)
    {
        if ($request->has('delete')) {
            $item->update(['active' => false]);
            $item->delete();
            return response()->json(['message' => 'Item deleted successfully'], Response::HTTP_OK);
        }
        $item->forceDelete();
        return response()->json(['message' => 'Item deleted for good successfully'], Response::HTTP_OK);
    }

}
