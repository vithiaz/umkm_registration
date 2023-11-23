<?php

namespace App\Http\Livewire\Base;

use App\Models\News;
use App\Models\Umkm;
use Livewire\Component;
use App\Models\Koperasi;
use Livewire\WithPagination;

class Homepage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Model Variable
    public $umkm;
    public $koperasi;
    
    // Binding Variable
    public $koperasi_count;
    public $umkm_count;
    public $koperasi_sub_district;
    public $koperasi_district_label;
    public $umkm_sub_district;
    public $umkm_sub_district_label;

    public function mount() {
        $this->umkm = Umkm::where('status', '=', 'verified')->get();
        $this->umkm_sub_district = Umkm::where([
            ['status', '=', 'verified'],
            ])->get()->groupBy('sub_district')->toArray();
        $this->umkm_count = $this->umkm->count();
        
        $this->koperasi = Koperasi::where('status', '=', 'verified')->get();
        $this->koperasi_sub_district = Koperasi::where([
            ['status', '=', 'verified'],
        ])->get()->groupBy('sub_district')->toArray();
        $this->koperasi_count = $this->koperasi->count();
        
        $this->koperasi_sub_district_label = array_values(array_filter(array_keys($this->koperasi_sub_district), function($values) {
            return $values != '';
        }));
        $this->umkm_sub_district_label = array_values(array_filter(array_keys($this->umkm_sub_district), function($values) {
            return $values != '';
        }));
    }

    public function render()
    {
        $news = News::where('is_active', '=', true)->paginate(4);
        return view('livewire.base.homepage', ['News' => $news])->layout('layouts.app');
    }
}
