<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuType;
use App\Models\ShortenedUrl;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CRUDController extends Controller
{
    public function updateVisitor(Request $request, Visitor $visitor)
    {
        try {
            $visitor->update($request->only(["countryName", "countryCode", "regionName", "cityName"]));
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateMenuType(Request $request, MenuType $menuType)
    {
        try {
            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $menuType->update($request->only(['name', 'slug', 'description', 'active']));
            return ['message' => "Updated Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function storeShortenedUrl(Request $request)
    {
        try {
            $request->validate([
                "slug" => "required|unique:shortened_urls,slug",
                "title"         => "required|string",
                'shortened'     => "required|string",
                'redirects_to'  => ["required", function ($attribute, $value, $fail) {
                                        if (!filter_var($value, FILTER_VALIDATE_URL) && !preg_match('/^mailto:.+@.+\..+$/', $value)) {
                                            $fail('The redirects_to must be a valid URL or a mailto email address.');
                                        }
                                    },
                                ],
                'note'          => "nullable|string",
            ]);

            $data = $request->only([ 'slug', 'title', 'shortened', 'redirects_to', 'note' ]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            ShortenedUrl::create($data);
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateShortenedUrl(Request $request, $id)
    {
        try {
            $shortenedUrl = ShortenedUrl::withTrashed()->find($id);

            if (! $shortenedUrl) {
                return response()->json(['message' => 'Shortened url not found'], Response::HTTP_NOT_FOUND);
            }

            if ($request->has('delete') || $request->has('destroy')) {
                return $this->destroy($shortenedUrl, $request);
            }
            if ($request->has('restore')) {
                $shortenedUrl->restore();
                return response()->json(['message' => 'Item restored successfully'], Response::HTTP_OK);
            }

            $request->validate([
                "slug" => ["required", "string", Rule::unique('shortened_urls')->ignore($id)],
                "title"         => "required|string",
                'shortened'     => "required|string",
                'redirects_to'  => ["required", function ($attribute, $value, $fail) {
                                        if (!filter_var($value, FILTER_VALIDATE_URL) && !preg_match('/^mailto:.+@.+\..+$/', $value)) {
                                            $fail('The redirects_to must be a valid URL or a mailto email address.');
                                        }
                                    },
                                ],
                'note'          => "nullable|string",
            ]);

            $data = $request->only([ 'slug', 'title', 'shortened', 'redirects_to', 'note' ]);
            $data['active'] = $request->has("active") && $request->get("active") === 'on';

            $shortenedUrl->update($data);
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
