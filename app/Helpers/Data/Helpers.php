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

if (!function_exists('handleGuestView')) {
    function handleGuestView($request)
    {
        $guestView = $request->get('guest-view');
        if ($guestView) {
            $guestView = $guestView === '1';

            $existingValue = session()->get('guest-view');
            if ($existingValue !== $guestView) {
                session()->put('guest-view', $guestView);
                $request->merge(['forget' => null]);
            }
        }
        return session()->get('guest-view');
    }
}
