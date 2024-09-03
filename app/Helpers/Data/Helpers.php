<?php

if (!function_exists('getExperiences')) {
    function getExperiences($activeOnly = true)
    {
        $experiences = config('data.resume.experiences');
        if ($activeOnly) {
            $experiences->data = filterHiddenItems($experiences->data);
        }
        return $experiences;
    }
}

if (!function_exists('getProjects')) {
    function getProjects($activeOnly = true, $onlyFeatured = false)
    {
        $projects = (object) [
            "header" => "projects",
            "data" => \App\Models\Project::query(),
        ]; // config('data.resume.work');
        if ($activeOnly) {
            $projects->data = activeItemsOnly($projects->data);
        }
        if ($onlyFeatured) {
            $projects->data = $projects->data->where('featured', true);
                // array_filter($work->data, static fn($item) => isset($item->featured) && $item->featured);
        }
        $projects->data = $projects->data->get();
        return $projects;
    }
}

if (!function_exists('getCertificates')) {
    function getCertificates($activeOnly = true)
    {
        $certificates = config('data.resume.certificates');
        if ($activeOnly) {
            $certificates->data = filterHiddenItems($certificates->data);
        }
        return $certificates;
    }
}

if (!function_exists('getSkills')) {
    function getSkills($activeOnly = true)
    {
        $competences = (array) config('data.resume.skills');
        if ($activeOnly) {
            $competences = array_map(function ($competenceGroup) {
                $competenceGroup->items = filterHiddenItems($competenceGroup->items);
                return $competenceGroup;
            }, $competences);
        }
        return (object) $competences;
    }
}

if (!function_exists('getEducation')) {
    function getEducation($activeOnly = true)
    {
        $education = config('data.resume.education');
        if ($activeOnly) {
            $education->data = filterHiddenItems($education->data);
        }
        return $education;
    }
}

if (!function_exists('getPassion')) {
    function getPassion($activeOnly = true)
    {
        $passion = config('data.resume.passion');
        if ($activeOnly) {
            $passion->data = filterHiddenItems($passion->data);
        }
        return $passion;
    }
}

if (!function_exists('getNonITExperiences')) {
    function getNonITExperiences($activeOnly = true)
    {
        $non_it_experiences = config('data.resume.non-it-experiences');
        if ($activeOnly) {
            $non_it_experiences->data = filterHiddenItems($non_it_experiences->data);
        }
        return $non_it_experiences;
    }
}

if (!function_exists('getTestimonials')) {
    function getTestimonials($activeOnly = true)
    {
        $testimonials = (object) [
            "header" => "testimonials",
            "data" => \DB::table('testimonials'),
        ]; // config('data.resume.testimonials');
        if ($activeOnly) {
            $testimonials->data = activeItemsOnly($testimonials->data);
        }
        $testimonials->data = $testimonials->data->get()->toArray();
        return $testimonials;
    }
}

if (!function_exists('getTechs')) {
    function getTechs($activeOnly = true)
    {
        $techs = config('data.components.techs');
        if ($activeOnly) {
            $techs->data = array_filter($techs->data, static fn ($item) => !isset($item->hidden) || !$item->hidden);
        }
        return $techs;
    }
}

if (!function_exists('getServices')) {
    function getServices($activeOnly = true)
    {
        $services = (object) [
            "header" => "services",
            "data" => \DB::table('services'),
        ]; // config('data.components.services');
        if ($activeOnly) {
            $services->data = activeItemsOnly($services->data);
                // array_filter($services->data, static fn($item) => !isset($item->hidden) || !$item->hidden);
        }
        $services->data = $services->data->get()->toArray();
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
