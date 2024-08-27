<?php

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

if (!function_exists('getProjects')) {
    function getProjects($withHidden = false, $onlyFeatured = false)
    {
        $work = (object) [
            "header" => "projects",
            "data" => \App\Models\Project::query(),
        ]; // config('data.resume.work');
        if (!$withHidden) {
            $work->data = filterHiddenRecordsOut($work->data);
        }
        if ($onlyFeatured) {
            $work->data = $work->data->where('featured', true);
                // array_filter($work->data, static fn($item) => isset($item->featured) && $item->featured);
        }
        $work->data = $work->data->get();
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
        $testimonials = (object) [
            "header" => "testimonials",
            "data" => \DB::table('testimonials'),
        ]; // config('data.resume.testimonials');
        if (!$withHidden) {
            $testimonials->data = filterHiddenRecordsOut($testimonials->data);
        }
        $testimonials->data = $testimonials->data->get()->toArray();
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
        $services = (object) [
            "header" => "services",
            "data" => \DB::table('services'),
        ]; // config('data.components.services');
        if (!$withHidden) {
            $services->data = filterHiddenRecordsOut($services->data);
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
