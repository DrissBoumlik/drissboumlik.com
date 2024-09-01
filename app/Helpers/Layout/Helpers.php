<?php

if (!function_exists('getSocialLinks')) {
    function getSocialLinks($menus, $activeOnly = true)
    {
        return getMenuByType($menus, 'social', $activeOnly);
    }
}

if (!function_exists('getSocialLinksCommunity')) {
    function getSocialLinksCommunity($menus, $activeOnly = true)
    {
        return getMenuByType($menus, 'social-community', $activeOnly);
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
    function getMenus ($filters) {
        $menus = \DB::table('menus')->whereIn('type', $filters)->get();
        return $menus;
    }
}

if (!function_exists('getMenuByType')) {
    function getMenuByType ($menus, $type, $activeOnly) {
        return $menus->filter(function($menuItem) use ($type, $activeOnly) {
            return ($menuItem->type === $type) && (!$activeOnly || $menuItem->active);
        });
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
    function pageSetup($title, $headline, $headerMenu = false, $footerMenu = false, $socialLinks = false, $socialLinksCommunity = false)
    {
        $data = new \stdClass();
        $data->page_title = $title;
        $data->headline = $headline;
        $menus = getMenus(['header', 'footer', 'social', 'social-community']);
        $data->headerMenu = $headerMenu ? getHeaderMenu($menus) : null;
        $data->footerMenu = $footerMenu ? getFooterMenu($menus) : null;
        $data->socialLinks = $socialLinks ? getSocialLinks($menus) : null;
        $data->socialLinksCommunity = $socialLinksCommunity ? getSocialLinksCommunity($menus) : null;
        return $data;
    }
}
