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
        $News->body = $this->process_image_on_body();
        $News->is_active = true;
        $News->save();

        return redirect()->route('admin.news')->with('message', 'Berita Ditambahkan');
    }

    private function process_image_on_body () {
        if ($this->body != null) {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($this->body);
            libxml_clear_errors();
            
            $dom_images = $dom->getElementsByTagName('img');
            foreach ($dom_images as $imageElem) {
                $src = $imageElem->getAttribute('src');
                if (preg_match('/data:image/', $src)) {
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    $file_name = uniqid('img_', true);
                    $file_path = ("storage/news_image/$file_name.$mimetype");
                    
                    //Decode and save image
                    list($type, $src) = explode(';', $src);
                    list(, $src)      = explode(',', $src);
                    $img = base64_decode($src);
                    file_put_contents(public_path($file_path), $img);
                    
                    $new_src = str_replace('admin.', '', asset($file_path));
                    $imageElem->removeAttribute('src');
                    $imageElem->setAttribute('src', $new_src);
                }
            }
            return $dom->saveHTML();  
        }
        return '';

    }



    public function set_status_filter($status) {
        $this->active_status = $status;
        $this->emitTo('news-table', 'set_active_status', $this->active_status);
    }

}
