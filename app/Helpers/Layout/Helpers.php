<?php

if (!function_exists('getSocialLinks')) {
    function getSocialLinks($withHidden = false)
    {
        $socialLinks = config('data.layout.social-links');
        if (!$withHidden) {
            $socialLinks = array_filter($socialLinks, static fn($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $socialLinks;
    }
}

if (!function_exists('getSocialLinksCommunity')) {
    function getSocialLinksCommunity($withHidden = false)
    {
        $socialLinksCommunity =config('data.layout.social-links-community');
        if (!$withHidden) {
            $socialLinksCommunity = array_filter($socialLinksCommunity, static fn ($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $socialLinksCommunity;
    }
}

if (!function_exists('getHeaderMenu')) {
    function getHeaderMenu($withHidden = false)
    {
        $headerMenu = config('data.layout.header-menu');
        if (!$withHidden) {
            $headerMenu = array_filter($headerMenu, static fn($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $headerMenu;

    }
}

if (!function_exists('getFooterMenu')) {
    function getFooterMenu($withHidden = false)
    {
        $footerMenu = config('data.layout.footer-menu');
        if (!$withHidden) {
            $footerMenu = array_filter($footerMenu, function($item) {
                $item->slugified_title = \Str::slug($item->title);
                return !isset($item->hidden) || !$item->hidden;
            });
        } else {
            $footerMenu = array_map(function($item) {
                $item->slugified_title = \Str::slug($item->title);
                return $item;
            }, $footerMenu);
        }
        return $footerMenu;
    }
}

if (!function_exists('pageSetup')) {
    function pageSetup($title, $headline, $headerMenu = false, $footerMenu = false, $socialLinks = false)
    {
        $data = new \stdClass();
        $data->title = $title;
        $data->headline = $headline;
        $data->headerMenu = $headerMenu ? getHeaderMenu() : null;
        $data->footerMenu = $footerMenu ? getFooterMenu() : null;
        $data->socialLinks = $socialLinks ? getSocialLinks() : null;
        return $data;
    }
}
