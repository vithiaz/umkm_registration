<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Koperasi;

class MyKoperasiCard extends Component
{
    // Component Binding Variable
    public $koperasi;
    public $index;

    // Binding Variable
    public $edit_state;
    public $name;
    public $legal_number;
    public $legal_date;
    public $address;
    public $village;
    public $sub_district;

    protected $rules = [
        'name' => 'required|string',
        'legal_number' => 'required|string',
        'legal_date' => 'required|date',
        'address' => 'required|string',
        'village' => 'required|string',
        'sub_district' => 'required|string',
    ];

    // Data Kelurahan di Tomohon
    public $tomohon_data;

    public function updatedSubDistrict() {
        $this->village = '';
    }

    
    private function reset_state() {
        $this->edit_state = false;

        $this->name = $this->koperasi->name;
        $this->legal_number = $this->koperasi->legal_number;
        $this->legal_date = $this->koperasi->legal_date;
        $this->address = $this->koperasi->address;
        $this->village = $this->koperasi->village;
        $this->sub_district = $this->koperasi->sub_district;
    }

    public function mount($koperasi, $index) {
        $this->koperasi = $koperasi;
        $this->index = $index;
        $this->reset_state();
        $this->tomohon_data = [
            'Tomohon Barat' => [
                'Taratara',
                'Taratara I',
                'Taratara II',
                'Taratara III',
                'Woloan I',
                'Woloan I Utara',
                'Woloan II',
                'Woloan III',
            ],
            'Tomohon Selatan' => [
                'Kampung Jawa',
                'Lahendong',
                'Lansot',
                'Pangolombian',
                'Pinaras',
                'Tumatangtang',
                'Tumatangtang I',
                'Tondangow',
                'Uluindano',
                'Walian',
                'Walian I',
                'Walian II',
            ],
            'Tomohon Tengah' => [
                'Kamasi',
                'Kamasi I',
                'Kolongan',
                'Kolongan I',
                'Matani I',
                'Matani II',
                'Matani III',
                'Talete I',
                'Talete II',
            ],
            'Tomohon Timur' => [
                'Kumelembuay',
                'Paslaten I',
                'Paslaten II',
                'Rurukan',
                'Rurukan I',
            ],
            "Tomohon Utara" => [
                'Kakaskasen',
                'Kakaskasen I',
                'Kakaskasen II',
                'Kakaskasen III',
                'Kayawu',
                'Kinilow',
                'Kinilow I',
                'Tinoor I',
                'Tinoor II',
                'Wailan',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.my-koperasi-card');
    }

    public function toggle_edit_state() {
        $this->edit_state = !$this->edit_state;
        
        if (!$this->edit_state) {
            $this->reset_state();
        }

    }

    public function set_village($data) {
        $this->village = $data;
    }

    public function save_edit() {
        $this->validate();

        $koperasi = Koperasi::find($this->koperasi->id);
        $koperasi->name = $this->name;
        $koperasi->legal_number = $this->legal_number;
        $koperasi->legal_date = $this->legal_date;
        $koperasi->address = $this->address;
        $koperasi->village = $this->village;
        $koperasi->sub_district = $this->sub_district;

        if ($koperasi->status == 'rejected') {
            $koperasi->status = 'pending';
        }

        $koperasi->save();

        return redirect()->route('koperasi-registration')->with('message', 'Edit data koperasi berhasil');
        $this->reset_state();
    }

    public function delete() {
        $deleteUmkm = Koperasi::find($this->koperasi->id);
        $deleteUmkm->delete();

        return redirect()->route('koperasi-registration')->with('message', 'berhasil dihapus');
        $this->reset_state();
    }
}
