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
            $footerMenu = array_filter($footerMenu, static fn($item) => !isset($item->hidden) || !$item->hidden);
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


if (!function_exists('getExperiences')) {
    function getExperiences($withHidden = false)
    {
        $experiences = config('data.resume.experiences');
        if (!$withHidden) {
            $experiences->data = filterHiddenItems($experiences->data);
        }
        return $experiences;
    }
}

if (!function_exists('getWork')) {
    function getWork($withHidden = false, $onlyFeatured = false)
    {
        $work = config('data.resume.work');
        if (!$withHidden) {
            $work->data = filterHiddenItems($work->data);
        }
        if ($onlyFeatured) {
            $work->data = array_filter($work->data, static fn($item) => isset($item->featured) && $item->featured);
        }
        return $work;
    }
}

if (!function_exists('getCertificates')) {
    function getCertificates($withHidden = false)
    {
        $certificates = config('data.resume.certificates');
        if (!$withHidden) {
            $certificates->data = filterHiddenItems($certificates->data);
        }
        return $certificates;
    }
}

if (!function_exists('getSkills')) {
    function getSkills($withHidden = false)
    {
        $competences = (array) config('data.resume.skills');
        if (!$withHidden) {
            $competences = array_map(function ($competenceGroup) {
                $competenceGroup->items = filterHiddenItems($competenceGroup->items);
                return $competenceGroup;
            }, $competences);
        }
        return (object) $competences;
    }
}

if (!function_exists('getEducation')) {
    function getEducation($withHidden = false)
    {
        $education = config('data.resume.education');
        if (!$withHidden) {
            $education->data = filterHiddenItems($education->data);
        }
        return $education;
    }
}

if (!function_exists('getPassion')) {
    function getPassion($withHidden = false)
    {
        $passion = config('data.resume.passion');
        if (!$withHidden) {
            $passion->data = filterHiddenItems($passion->data);
        }
        return $passion;
    }
}

if (!function_exists('getNonITExperiences')) {
    function getNonITExperiences($withHidden = false)
    {
        $non_it_experiences = config('data.resume.non-it-experiences');
        if (!$withHidden) {
            $non_it_experiences->data = filterHiddenItems($non_it_experiences->data);
        }
        return $non_it_experiences;
    }
}

if (!function_exists('getTestimonials')) {
    function getTestimonials($withHidden = false)
    {
        $testimonials = config('data.resume.testimonials');
        if (!$withHidden) {
            $testimonials->data = filterHiddenItems($testimonials->data);
        }
        return $testimonials;
    }
}

if (!function_exists('getTechs')) {
    function getTechs($withHidden = false)
    {
        $techs = config('data.components.techs');
        if (!$withHidden) {
            $techs->data = array_filter($techs->data, static fn ($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $techs;
    }
}

if (!function_exists('getServices')) {
    function getServices($withHidden = false)
    {
        $services = config('data.components.services');
        if (!$withHidden) {
            $services->data = array_filter($services->data, static fn($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $services;
    }
}

if (!function_exists('getServicesById')) {
    function getServicesById($item_id)
    {
        $services = config('data.components.services');
        $service = array_values(array_filter($services->data, static fn($item) => $item->id === $item_id));
        return count($service) ? $service[0] : null;
    }
}

if (!function_exists('filterHiddenItems')) {
    function filterHiddenItems($items)
    {
        return array_filter($items, static fn($item) => !isset($item->hidden) || !$item->hidden);
    }
}

if (!function_exists('shortenTextIfLongByLength')) {
    function shortenTextIfLongByLength($text, $length)
    {
        return strlen($text) < $length ? $text : \Str::limit($text, $length);
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
