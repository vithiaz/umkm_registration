<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Koperasi;
use Illuminate\Support\Facades\Auth;

class AddKoperasi extends Component
{

    // Binding Variable
    public $name;
    public $legal_number;
    public $legal_date;
    public $address;
    public $village;
    public $sub_district;
    public $city;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'name' => 'required|string',
        'legal_number' => 'required|string',
        'legal_date' => 'required|date',
        'address' => 'required|string',
        'village' => 'required|string',
        'sub_district' => 'required|string',
    ];

    // Data Kelurahan di Tomohon
    public $tomohon_data = [
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

    public function updatedSubDistrict() {
        $this->village = '';
    }

    public function mount() {
        $this->reset_data();
    }

    public function render()
    {
        return view('livewire.components.add-koperasi');
    }

    public function store() {
        $this->validate();

        $koperasi = new Koperasi;
        $koperasi->name = $this->name;
        $koperasi->legal_number = $this->legal_number;
        $koperasi->legal_date = $this->legal_date;
        $koperasi->status = 'pending';
        $koperasi->address = $this->address;
        $koperasi->village = $this->village;
        $koperasi->sub_district = $this->sub_district;
        $koperasi->city = "Tomohon";
        $koperasi->owner_user = Auth::user()->id;
        $koperasi->save();

        return redirect()->route('koperasi-registration')->with('message', 'Koperasi dalam pengajuan');
        $this->reset_data();
    }

    public function reset_data() {
        $this->name = '';
        $this->legal_number = '';
        $this->legal_date = '';
        $this->address = '';
        $this->village = '';
        $this->sub_district = '';
        $this->city = '';
    }

    public function set_village($data) {
        $this->village = $data;
    }

}
