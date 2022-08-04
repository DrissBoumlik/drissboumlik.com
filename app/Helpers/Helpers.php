<?php

if (!function_exists('getGeneralText')) {
    function getGeneralText($lang = 'fr'){
        $lang = $lang ?? 'fr';
        $text = [
            'en' => [
                'welcome' => 'welcome',
                'intro' => 'this is my resume ... ish',
                'whois' => 'who is'
            ],
            'fr' => [
                'welcome' => 'Bienvenue',
                'intro' => 'ceci est mon curriculum vitae',
                'whois' => 'qui est'
            ]
        ];
        return $text[$lang];
    }
}

if (!function_exists('getLinks')) {
    function getLinks(){
        $links = [
            // Social links
            'facebook' => 'https://facebook.com/drissboumlik/',
            'instagram' => 'https://instagram.com/drissboumlik/',
            'twitter' => 'https://twitter.com/drissboumlik/',
            'linkedin' => 'https://www.linkedin.com/in/drissboumlik/',
            'github' => 'https://www.github.com/drissboumlik/',
            'youtube' => 'https://youtube.com/channel/UCss61diIS1kW_TRsHMMwtwQ',
            'community' => 'https://teacode.ma',
            'cv' => '/storage/cv/DrissBoumlik-' . \App::getLocale() . '.pdf',

            // Contact
            'meet' => 'https://calendly.com/drissboumlik/30min/',
            'email' => 'mailto:contact@drissboumlik.com?subject=Resume : ',

            // Brand
            'site' => 'https://teacode.ma/'
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
    function getHeaderMenu()
    {
        return json_decode(\File::get(base_path() . '/database/data/layout/header-menu.json'));
    }
}

if (!function_exists('getFooterMenu')) {
    function getFooterMenu()
    {
        return json_decode(\File::get(base_path() . '/database/data/layout/footer-menu.json'));
    }
}

if (!function_exists('getLanguages')) {
    function getLanguages()
    {
        return ['fr', 'en'];
    }
}

if (!function_exists('inLanguages')) {
    function inLanguages($lang = null)
    {
        if ($lang) {
            return in_array($lang, getLanguages());
        }
        return false;
    }
}

if (!function_exists('calculateDate')) {
    function calculateDate($start, $end = null)
    {
        $lang = \App::getLocale();
        $yearText = $lang == 'fr' ? 'ans' : 'years';
        $monthText = $lang == 'fr' ? 'mois' :'months';
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
                    ($years > 0 ? $years . ' ' . $yearText : '') .
                    ($years && $months ? ', ' : '') .
                    ($months > 0 ? $months . ' ' . $monthText . '</span>' : '') . '</span>';
    }
}
