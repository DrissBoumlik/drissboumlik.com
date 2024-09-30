<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function storeMenu(Request $request)
    {
        try {

            $request->validate([
                "menu_type_id"  => "required|integer|exists:menu_types,id",
                "slug"          => "required|unique:services,slug",
                "title"         => "required|string",
                "text"          => "required|string",
                "target"        => "required|string|in:_self,_blank",
                "link"          => "required|string",
                "icon"          => "required|string",
                "order"         => ["required", "integer", "min:1",
                    function ($attribute, $value, $fail) use ($request) {
                        if (Menu::where($attribute, $value)
                            ->where('menu_type_id', $request->get('menu_type_id'))
                            ->exists()) {
                            $fail('The order must be unique for the specified menu type.');
                        }
                    },
                ],
            ]);

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            Menu::create($request->only(['text', 'title', 'slug', 'target', 'link', 'icon', 'menu_type_id', 'active', 'order']));
            return ['message' => "Stored Successfully !"];
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function updateMenu(Request $request, $id)
    {
        try {
            $menu = Menu::withTrashed()->find($id);

            if ($request->has('delete') || $request->has('destroy')) {
                return $this->destroy($menu, $request);
            }
            if ($request->has('restore')) {
                $menu->restore();
            }

            $request->validate([
                "menu_type_id"  => "required|integer|exists:menu_types,id",
                "slug"          => "required|unique:services,slug",
                "title"         => "required|string",
                "text"          => "required|string",
                "target"        => "required|string|in:_self,_blank",
                "link"          => "required|string",
                "icon"          => "required|string",
                "order"         => "required|integer|min:1",
            ]);

            $order = $request->get('order');
            if ($order) {
                $menu_type_id = $request->get('menu_type_id') ?? $menu->menu_type_id;
                $itemToChangeOrderWith = Menu::withTrashed()->where('order', $order)
                                                        ->where('menu_type_id', $menu_type_id)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $menu->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $menu->update($request->only(['text', 'title', 'slug', 'target', 'link', 'icon', 'menu_type_id', 'active', 'order']));
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
            $item->forceDelete();
            return response()->json(['message' => 'Item deleted for good successfully'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
