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
            $order = $request->get('order');
            $menu_type_id = $request->get('menu_type_id');
            $itemToChangeOrderWith = Menu::where('order', $order)
                                            ->where('menu_type_id', $menu_type_id)
                                            ->exists();
            if ($itemToChangeOrderWith) {
                throw new \Exception("Item with same order already exists!");
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $request->merge(["menu_type_id" => $request->get('menu-type')]);
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

            if ($request->has('delete')) {
                return $this->destroy($menu, $request);
            } elseif ($request->has('restore')) {
                $menu->restore();
            }

            $order = $request->get('order');
            $menu_type_id = $request->get('menu_type');
            if (is_numeric($order)) {
                $itemToChangeOrderWith = Menu::withTrashed()->where('order', $order)
                    ->where('menu_type_id', $menu_type_id)->first();
                if ($itemToChangeOrderWith) {
                    $itemToChangeOrderWith->order = $menu->order;
                    $itemToChangeOrderWith->update();
                }
            }

            $active = $request->has("active") && $request->get("active") === 'on';
            $request->merge(["active" => $active]);
            $request->merge(["menu_type_id" => $request->get('menu-type')]);
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
//            $item->forceDelete();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
