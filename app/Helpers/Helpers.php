<?php

if (!function_exists('generateRandomColor')) {
    function generateRandomColor()
    {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        return $color;
    }
}

if (!function_exists('redirect_to_404_page')) {
    function redirect_to_404_page()
    {
        $data = new \stdClass;
        $data->title = 'Page Not Found | Driss Boumlik';
        $data->headline = 'Tags';
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
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
            'discord' => 'https://discordapp.com/users/156878784019038208',
            'youtube' => 'https://youtube.com/channel/UCss61diIS1kW_TRsHMMwtwQ',
            'community' => 'https://community.drissboumlik.com',
            'cv' => '/storage/cv/DrissBoumlik-en.pdf',

            // Contact
            'meet' => 'https://calendly.com/drissboumlik/30min/',
            'email' => 'mailto:hi@drissboumlik.com?subject=Resume : ',

            // Brand
            'site' => 'https://community.drissboumlik.com/'
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
        $socialLinks = json_decode(\File::get(base_path() . '/database/data/layout/social-links.json'));
        if (!$withHidden) {
            $socialLinks = array_filter($socialLinks, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $socialLinks;
    }
}

if (!function_exists('getSocialLinksCommunity')) {
    function getSocialLinksCommunity($withHidden = false)
    {
        $socialLinksCommunity = json_decode(\File::get(base_path() . '/database/data/layout/social-links-community.json'));
        if (!$withHidden) {
            $socialLinksCommunity = array_filter($socialLinksCommunity, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $socialLinksCommunity;
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


if (!function_exists('getExperiences')) {
    function getExperiences($withHidden = false)
    {
        $experiences = json_decode(\File::get(base_path() . "/database/data/resume/experiences.json"));
        if (!$withHidden) {
            $experiences->items = filterHiddenItems($experiences->items);
        }
        return $experiences;
    }
}

if (!function_exists('getWork')) {
    function getWork($withHidden = false, $onlyFeatured = false)
    {
        $work = json_decode(\File::get(base_path() . "/database/data/resume/work.json"));
        if (!$withHidden) {
            $work->items = filterHiddenItems($work->items);
        }
        if ($onlyFeatured) {
            $work->items = array_filter($work->items, function ($item) {
                return isset($item->featured) && $item->featured;
            });
        }
        return $work;
    }
}

if (!function_exists('getCertificates')) {
    function getCertificates($withHidden = false)
    {
        $certificates = json_decode(\File::get(base_path() . "/database/data/resume/certificates.json"));
        if (!$withHidden) {
            $certificates->items = filterHiddenItems($certificates->items);
        }
        return $certificates;
    }
}

if (!function_exists('getCompetences')) {
    function getCompetences($withHidden = false)
    {
        $competences = (array) json_decode(\File::get(base_path() . "/database/data/resume/competences.json"));
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
        $education = json_decode(\File::get(base_path() . "/database/data/resume/education.json"));
        if (!$withHidden) {
            $education->items = filterHiddenItems($education->items);
        }
        return $education;
    }
}

if (!function_exists('getPassion')) {
    function getPassion($withHidden = false)
    {
        $passion = json_decode(\File::get(base_path() . "/database/data/resume/passion.json"));
        if (!$withHidden) {
            $passion->items = filterHiddenItems($passion->items);
        }
        return $passion;
    }
}

if (!function_exists('getOtherExperiences')) {
    function getOtherExperiences($withHidden = false)
    {
        $other_exp = json_decode(\File::get(base_path() . "/database/data/resume/other_exp.json"));
        if (!$withHidden) {
            $other_exp->items = filterHiddenItems($other_exp->items);
        }
        return $other_exp;
    }
}

if (!function_exists('getTestimonials')) {
    function getTestimonials($withHidden = false)
    {
        $testimonials = json_decode(\File::get(base_path() . "/database/data/resume/testimonials.json"));
        if (!$withHidden) {
            $testimonials->items = filterHiddenItems($testimonials->items);
        }
        return $testimonials;
    }
}

if (!function_exists('getTechs')) {
    function getTechs($withHidden = false)
    {
        $techs = json_decode(\File::get(base_path() . "/database/data/Components/techs.json"));
        if (!$withHidden) {
            $techs->items = array_filter($techs->items, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $techs;
    }
}

if (!function_exists('getServices')) {
    function getServices($withHidden = false)
    {
        $services = json_decode(\File::get(base_path() . "/database/data/Components/services.json"));
        if (!$withHidden) {
            $services->items = array_filter($services->items, function ($item) {
                return (!isset($item->hidden) || !$item->hidden);
            });
        }
        return $services;
    }
}

if (!function_exists('getServicesById')) {
    function getServicesById($item_id)
    {
        $services = json_decode(\File::get(base_path() . "/database/data/Components/services.json"));
        $service = array_values(array_filter($services->items, fn($item) => $item->id === $item_id));
        return count($service) ? $service[0] : null;
    }
}

if (!function_exists('filterHiddenItems')) {
    function filterHiddenItems($items)
    {
        return array_filter($items, function ($item) {
            return (!isset($item->hidden) || !$item->hidden);
        });
    }
}

if (!function_exists('shortenTextIfLongByLength')) {
    function shortenTextIfLongByLength($text, $length)
    {
        return strlen($text) < $length ? $text : \Str::limit($text, $length);
    }
}
