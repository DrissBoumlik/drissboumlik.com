<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
class DataService
{

    public static function fetchFromDbTable($header, $model,
                                     $selectedColumns = '*', $activeOnly = true,
                                     $orderField = 'order', $orderDirection = 'asc', $callback = null)
    {
        $model = "App\\Models\\$model";
        $data_obj = (object) [
            "header" => $header,
            "data" => $model::query(),
        ];
        if ($activeOnly) {
            $data_obj->data =  self::activeItemsOnly($data_obj->data);
        }
        if ($callback) {
            $data_obj->data = $callback($data_obj->data);
        }
        $data_obj->data = $data_obj->data->orderBy($orderField, $orderDirection)
                        ->select($selectedColumns)->get();
        return $data_obj;
    }

    public static function getMenus ($menu_type_filters, $activeOnly = true)
    {
        $menu_type_filters = implode('|', $menu_type_filters);

        $menus = \DB::table('menus')
            ->join('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')
            ->whereRaw("menu_types.slug REGEXP '$menu_type_filters'");

        if ($activeOnly) {
            $menus = $menus->where('menus.active', true);
        }

        $menus = $menus->orderBy('order', 'asc')
            ->select(['text', 'title', 'menus.slug', 'target', 'link',
                'icon', 'menus.active', 'menu_types.name as menu_type_name', 'menu_types.slug as menu_type_slug'])
            ->get();
        return $menus;
    }

    private static function activeItemsOnly($query)
    {
        return $query->where('active', true);
    }

}
