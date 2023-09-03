<?php

namespace App\Livewire;

use Livewire\Component;

class Resume extends Component
{
    public $data;

    public function mount()
    {
        $this->data = $this->load_data();
    }
    
    public function render()
    {
        return view('livewire.resume');
    }
    private function load_data()
    {
        $data = new \stdClass();

        $data->sections = [];
        // $data->summary = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/summary.json"));
        $data->sections['experiences'] = json_decode(\File::get(base_path() . "/database/data/resume/experiences.json"));
        $data->sections['competences'] = json_decode(\File::get(base_path() . "/database/data/resume/competences.json"));
        $data->sections['education'] = json_decode(\File::get(base_path() . "/database/data/resume/education.json"));
        // $data->sections['portfolio'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/portfolio.json"));
        // $data->sections['certificates'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/certificates.json"));
        $data->sections['passion'] = json_decode(\File::get(base_path() . "/database/data/resume/passion.json"));
        $data->sections['other_exp'] = json_decode(\File::get(base_path() . "/database/data/resume/other_exp.json"));
        $data->sections['recommandations'] = json_decode(\File::get(base_path() . "/database/data/resume/recommandations.json"));
		$data->sections['recommandations']->items = collect($data->sections['recommandations']->items)->shuffle()->all();
        $data->sections['experiences']->items = array_map(function($item) {
            $item->duration = calculateDate($item->start_date, $item->end_date);
            return $item;
        }, $data->sections['experiences']->items);

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();

        $data->title = 'Driss Boumlik | Resume';
        
        return $data;
    }
}
