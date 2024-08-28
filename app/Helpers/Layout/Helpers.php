<?php

if (!function_exists('getSocialLinks')) {
    function getSocialLinks($menus, $withHidden = false)
    {
        return getMenuByType($menus, 'social', $withHidden);
    }
}

if (!function_exists('getSocialLinksCommunity')) {
    function getSocialLinksCommunity($menus, $withHidden = false)
    {
        return getMenuByType($menus, 'social-community', $withHidden);
    }
}

if (!function_exists('getHeaderMenu')) {
    function getHeaderMenu($menus, $withHidden = false)
    {
        return getMenuByType($menus,'header', $withHidden);
    }
}

if (!function_exists('getFooterMenu')) {
    function getFooterMenu($menus, $withHidden = false)
    {
        return getMenuByType($menus,'footer', $withHidden);
    }
}

if (!function_exists('getMenus')) {
    function getMenus ($filters) {
        $menus = \DB::table('menus')->whereIn('type', $filters)->get();
        return $menus;
    }
}

if (!function_exists('getMenuByType')) {
    function getMenuByType ($menus, $type, $withHidden) {
        return $menus->filter(function($menuItem) use ($type, $withHidden) {
            return ($menuItem->type === $type) && ($withHidden || !$menuItem->hidden);
        });
    }
}

if (!function_exists('pageSetup')) {
    function pageSetup($title, $headline, $headerMenu = false, $footerMenu = false, $socialLinks = false, $socialLinksCommunity = false)
    {
        $data = new \stdClass();
        $data->title = $title;
        $data->headline = $headline;
        $menus = getMenus(['header', 'footer', 'social', 'social-community']);
        $data->headerMenu = $headerMenu ? getHeaderMenu($menus) : null;
        $data->footerMenu = $footerMenu ? getFooterMenu($menus) : null;
        $data->socialLinks = $socialLinks ? getSocialLinks($menus) : null;
        $data->socialLinksCommunity = $socialLinksCommunity ? getSocialLinksCommunity($menus) : null;
        return $data;
    }
}
