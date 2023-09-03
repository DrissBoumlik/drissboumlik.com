<?php

namespace App\Livewire;

use Livewire\Component;

class Post extends Component
{
    public $post;

    public function mount($post = null)
    {
        $this->post = $post;
    }
    
    public function render()
    {
        return view('livewire.post');
    }
}
