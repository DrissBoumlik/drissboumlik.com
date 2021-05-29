<?php


if (!function_exists('getSocialLinks')) {
    function getSocialLinks()
    {
        return json_decode(\File::get(base_path() . '/database/data/layout/social-links.json'));
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
        $lang = (isset($_GET['lang']) && $_GET['lang'] == 'en') ? 'en' : 'fr';
        $yearText = $lang == 'fr' ? 'ans' : 'years';
        $monthText = $lang == 'fr' ? 'mois' :'months';
        $date1 = strtotime($start);
        $date2 = $end != null ? strtotime($end) : time();
        $diff = abs($date2 - $date1) + 1;
        $years = floor($diff / (365*60*60*24));
        $m_diff = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));
        $months = $m_diff < 12 ? $m_diff + 1 : 1;
        $years = $m_diff < 12 ? $years : $years + 1;
        return '<span>(<span>' . ($years > 0 ? $years . ' ' . $yearText . ', ' : '') . '</span>' .
            '<span>' . ($months > 0 ? $months . ' ' . $monthText : '') . '</span>)</span>';
    }
}
