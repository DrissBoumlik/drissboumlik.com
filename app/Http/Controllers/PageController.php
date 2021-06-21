<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function resume(Request $request, $lang = null)
    {
        $lang = $lang ?? 'fr';
        if (!inLanguages($lang)) {
            return redirect('/resume');
        }
        \App::setLocale($lang);
        $data = new \stdClass();

        $data->general = getGeneralText($lang);

        $data->sections = [];
        // $data->summary = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/summary.json"));
        $data->sections['competences'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/competences.json"));
        $data->sections['experiences'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/experiences.json"));
        $data->sections['education'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/education.json"));
        // $data->sections['portfolio'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/portfolio.json"));
        // $data->sections['certificates'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/certificates.json"));
        $data->sections['passion'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/passion.json"));
        $data->sections['other_exp'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/other_exp.json"));
        $data->sections['recommandations'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/recommandations.json"));

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        $data->title = 'Driss Boumlik | Resume';

        return view('pages.resume', ['data' => $data]);
    }

    // public function getCV(Request $request, $lang = null)
    // {
    //     // $lang = app()->getLocale();
    //     $lang = $lang ?? 'fr';
    //     if (!inLanguages($lang)) {
    //         return redirect('/resume/cv');
    //     }
    //     \App::setLocale($lang);
    //     $filePath = base_path('public') . '/storage/cv/DrissBoumlik-' . $lang . '.pdf';
    //     $filename = 'DrissBoumlik-' . $lang . '.pdf';
    //     return \Response::make(file_get_contents($filePath), 200, [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'inline; filename="'.$filename.'"',
    //         'Content-Transfer-Encoding'=> 'binary',
    //         'Accept-Ranges'=> 'bytes'
    //     ]);
    // }
}
