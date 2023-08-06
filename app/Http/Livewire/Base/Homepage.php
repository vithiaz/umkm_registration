<?php

namespace App\Http\Livewire\Base;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;

class Homepage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $news = News::where('is_active', '=', true)->paginate(4);
        return view('livewire.base.homepage', ['News' => $news])->layout('layouts.app');
    }
}
