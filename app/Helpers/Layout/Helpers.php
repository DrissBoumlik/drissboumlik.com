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
    function pageSetup($title, $headline, $menu_type_filters = [])
    {
        $data = new \stdClass();
        $data->page_title = $title;
        $data->headline = $headline;
        $menus = \App\Services\DataService::getMenus($menu_type_filters);
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
