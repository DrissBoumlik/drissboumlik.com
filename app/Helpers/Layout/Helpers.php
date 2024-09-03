<?php

if (!function_exists('getSocialLinks')) {
    function getSocialLinks($menus, $activeOnly = true)
    {
        return getMenuByType($menus, 'social', $activeOnly);
    }
}

if (!function_exists('getCommunityLinks')) {
    function getCommunityLinks($menus, $activeOnly = true)
    {
        return getMenuByType($menus, 'community', $activeOnly);
    }
}

if (!function_exists('getHeaderMenu')) {
    function getHeaderMenu($menus, $activeOnly = true)
    {
        return getMenuByType($menus,'header', $activeOnly);
    }
}

if (!function_exists('getFooterMenu')) {
    function getFooterMenu($menus, $activeOnly = true)
    {
        return getMenuByType($menus,'footer', $activeOnly);
    }
}

if (!function_exists('getMenus')) {
    function getMenus ($filters, $activeOnly = true) {
        $filters = implode('|', $filters);

        $menus = \DB::table('menus')
            ->join('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')
            ->whereRaw("menu_types.slug REGEXP '$filters'");

        if ($activeOnly) {
            $menus = $menus->where('menus.active', true);
        }

        $menus = $menus->orderBy('order', 'asc')
            ->select(['text', 'title', 'menus.slug', 'target', 'link',
                'icon', 'menus.active', 'menu_types.name as menu_type_name', 'menu_types.slug as menu_type_slug'])
            ->get();
        return $menus;
    }
}

if (!function_exists('getMenuByType')) {
    function getMenuByType ($menus, $type, $activeOnly) {
        return $menus->filter(function($menuItem) use ($type, $activeOnly) {
            return (str_contains($menuItem->menu_type_slug, $type)) && (!$activeOnly || $menuItem->active);
        })->toArray();
    }
}

if (!function_exists('adminPageSetup')) {
    function adminPageSetup ($title) {
        $data = new \stdClass();
        $data->page_title = $title;
        return $data;
    }
}

if (!function_exists('pageSetup')) {
    function pageSetup($title, $headline, $menu_filters = [])
    {
        $data = new \stdClass();
        $data->page_title = $title;
        $data->headline = $headline;
        $menus = getMenus($menu_filters);
        $headerMenu = getHeaderMenu($menus);
        $data->headerMenu = count($headerMenu) ? $headerMenu : null;
        $footerMenu = getFooterMenu($menus);
        $data->footerMenu = count($footerMenu) ? $footerMenu : null;
        $socialLinks = getSocialLinks($menus);
        $data->socialLinks = count($socialLinks) ? $socialLinks : null;
        $communityLinks = getCommunityLinks($menus);
        $data->communityLinks = count($communityLinks) ? $communityLinks : null;
        return $data;
    }
}
