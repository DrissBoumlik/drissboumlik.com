<?php

if (!function_exists('generateRandomColor')) {
    function generateRandomColor()
    {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        return $color;
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
            'discord' => 'https://discordapp.com/users/156878784019038208',
            'youtube' => 'https://youtube.com/channel/UCss61diIS1kW_TRsHMMwtwQ',
            // Community
            'community' => 'https://community.drissboumlik.com',
            // Resume
            'cv' => 'https://docs.google.com/document/d/1idAAzjxMJXOTOY5QkOnQTq4clsICGlv8wCmDyyEw6Xs/edit#heading=h.x8fm1uorkbaw',
            'cv-pdf' => '/storage/cv/DrissBoumlik-en.pdf',
            // Contact
            'meet' => 'https://calendly.com/drissboumlik/30min/',
            'email' => 'mailto:hi@drissboumlik.com?subject=Resume : ',
        ];
        return $links;
    }
}

if (!function_exists('getLinkByKey')) {
    function getLinkByKey($key)
    {
        try {
            $links = getLinks();
            return $links[$key];
        } catch (\Throwable $e) {
            return null;
        }
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

if (!function_exists('filterHiddenItems')) {
    function filterHiddenItems($items)
    {
        return array_filter($items, static fn($item) => !isset($item->hidden) || !$item->hidden);
    }
}

if (!function_exists('activeItemsOnly')) {
    function activeItemsOnly($query) {
        return $query->where('active', true);
    }
}

if (!function_exists('shortenTextIfLongByLength')) {
    function shortenTextIfLongByLength($text, $length)
    {
        return strlen($text) < $length ? $text : \Str::limit($text, $length);
    }
}

if (!function_exists('isGuest')) {
    function isGuest ($guestView = true) {
        return !\Auth::check() || $guestView;
    }
}
