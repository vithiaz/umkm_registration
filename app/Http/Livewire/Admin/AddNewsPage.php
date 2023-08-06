<?php

namespace App\Http\Livewire\Admin;

use App\Models\News;
use Livewire\Component;

class AddNewsPage extends Component
{
    // Binding Variable
    public $title;
    public $body;
    public $active_status;

    protected $rules = [
        'title' => 'required',
        'body' => 'required',
    ];

    protected $messages = [
        'title' => 'Judul tidak boleh kosong',
        'body' => 'Isi berita tidak boleh kosong',
    ];

    public function mount() {
        $this->title = '';
        $this->body = '';
        $this->active_status = true;
    }
    
    public function render()
    {
        return view('livewire.admin.add-news-page')->layout('layouts.admin_app');
    }

    public function store_berita() {
        $this->validate();

        $News = new News;
        $News->title = $this->title;
        $News->body = $this->body;
        $News->is_active = true;
        $News->save();

        return redirect()->route('admin.news')->with('message', 'Berita Ditambahkan');
    }



    public function set_status_filter($status) {
        $this->active_status = $status;
        $this->emitTo('news-table', 'set_active_status', $this->active_status);
    }

}
