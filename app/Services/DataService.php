<?php

namespace App\Services;

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

    public static function getExperiences($activeOnly = true)
    {
        $experiences = config('data.resume.experiences');
        if ($activeOnly) {
            $experiences->data = filterHiddenItems($experiences->data);
        }
        return $experiences;
    }

    public static function getSkills($activeOnly = true)
    {
        $competences = (array) config('data.resume.skills');
        if ($activeOnly) {
            $competences = array_map(function ($competenceGroup) {
                $competenceGroup->items = filterHiddenItems($competenceGroup->items);
                return $competenceGroup;
            }, $competences);
        }
        return (object) $competences;
    }

    public static function getEducation($activeOnly = true)
    {
        $education = config('data.resume.education');
        if ($activeOnly) {
            $education->data = filterHiddenItems($education->data);
        }
        return $education;
    }
    public static function getPassion($activeOnly = true)
    {
        $passion = config('data.resume.passion');
        if ($activeOnly) {
            $passion->data = filterHiddenItems($passion->data);
        }
        return $passion;
    }

    public static function getNonITExperiences($activeOnly = true)
    {
        $non_it_experiences = config('data.resume.non-it-experiences');
        if ($activeOnly) {
            $non_it_experiences->data = filterHiddenItems($non_it_experiences->data);
        }
        return $non_it_experiences;
    }

    public static function getCertificates($activeOnly = true)
    {
        $certificates = config('data.resume.certificates');
        if ($activeOnly) {
            $certificates->data = filterHiddenItems($certificates->data);
        }
        return $certificates;
    }

    public static function getTechs($activeOnly = true)
    {
        $techs = config('data.components.techs');
        if ($activeOnly) {
            $techs->data = array_filter($techs->data, static fn ($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $techs;
    }
}
