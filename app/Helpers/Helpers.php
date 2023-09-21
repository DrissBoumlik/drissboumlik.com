<?php

if (!function_exists('redirect_to_404_page')) {
    function redirect_to_404_page()
    {
        $data = new \stdClass;
        $data->title = 'Page Not Found | Driss Boumlik';
        return view('errors.404', ['data' => $data]);
    }
}

if (!function_exists('getLinks')) {
    function getLinks(){
        $links = [
            // Social links
            'facebook' => 'https://facebook.com/drissboumlik/',
            'instagram' => 'https://instagram.com/drissboumlik/',
            'twitter' => 'https://twitter.com/drissboumlik/',
            'linkedin' => 'https://linkedin.com/in/drissboumlik/',
            'github' => 'https://github.com/drissboumlik/',
            'youtube' => 'https://youtube.com/channel/UCss61diIS1kW_TRsHMMwtwQ',
            'community' => 'https://teacode.drissboumlik.com',
            'cv' => '/storage/cv/DrissBoumlik-en.pdf',

            // Contact
            'meet' => 'https://calendly.com/drissboumlik/30min/',
            'email' => 'mailto:hi@drissboumlik.com?subject=Resume : ',

            // Brand
            'site' => 'https://teacode.drissboumlik.com/'
        ];
        return $links;
    }
}

if (!function_exists('getSocialLinks')) {
    function getSocialLinks()
    {
        return json_decode(\File::get(base_path() . '/database/data/layout/social-links.json'));
    }
}

if (!function_exists('getHeaderMenu')) {
    function getHeaderMenu($withHidden = false)
    {
        $headerMenu = json_decode(\File::get(base_path() . '/database/data/layout/header-menu.json'));
        if (!$withHidden) {
            $headerMenu = array_filter($headerMenu, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $headerMenu;

    }
}

if (!function_exists('getFooterMenu')) {
    function getFooterMenu($withHidden = false)
    {
        $footerMenu = json_decode(\File::get(base_path() . '/database/data/layout/footer-menu.json'));
        if (!$withHidden) {
            $footerMenu = array_filter($footerMenu, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $footerMenu;
    }
}


if (!function_exists('calculateDate')) {
    function calculateDate($start, $end = null)
    {
        $date1 = strtotime($start);
        $date2 = $end != null ? strtotime($end) : time();
        $diff = abs($date2 - $date1) + 1;
        $years = floor($diff / (365*60*60*24));
        $m_diff = floor(($diff - ($years * 365*60*60*24))/(30*60*60*24));
        $years = $m_diff < 12 ? $years : $years + 1;
        $months = $m_diff < 12 ? $m_diff + 1 : 1;
        if ($months >= 12) {
            $years++;
            $months = 0;
        }
        return '<span>' .
                    ($years > 0 ? $years . ' ' . 'years' : '') .
                    ($years && $months ? ', ' : '') .
                    ($months > 0 ? $months . ' ' . 'months' : '') . '</span>';
    }
}
