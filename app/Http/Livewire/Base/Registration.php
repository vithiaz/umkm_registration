<?php

namespace App\Http\Livewire\Base;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Registration extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $nip;
    public $full_name;
    public $birth;
    public $gender;
    public $address;
    public $ktp;
    public $kk;
    public $photo;
    public $phone;

    protected $rules = [
        'nip' => 'required|numeric|unique:users,nip',
        'full_name' => 'required|string',
        'birth' => 'required|date',
        'gender' => 'required|string',
        'address' => 'required|string',
        'phone' => 'required|numeric',
        'ktp' => 'required|image|max:2048',
        'kk' => 'required|image|max:2048',
        'photo' => 'required|image|max:2048',
    ];

    protected $messages  = [
        'nip.required' => 'NIK tidak boleh kosong',
        'nip.numeric' => 'NIK hanya boleh diisi angka',
        'nip.unique' => 'NIK sudah terdaftar',
        'full_name.required' => 'Nama Lengkap tidak boleh kosong',
        'birth.required' => 'Tanggal Lahir tidak boleh kosong',
        'gender.required' => 'Jenis Kelamin tidak boleh kosong',
        'phone.required' => 'Nomor Telepon tidak boleh kosong',
        'address.required' => 'Alamat tidak boleh kosong',
        'ktp.required' => 'Foto KTP harus di upload',
        'kk.required' => 'Foto KK harus di upload',
        'photo.required' => 'Pass Foto harus di upload',
        'ktp.image' => 'Foto KTP harus berupa gambar',
        'kk.image' => 'Foto KK harus berupa gambar',
        'photo.image' => 'Pass Foto harus berupa gambar',
    ];

    public function mount() {
        $this->nip = '';
        $this->full_name = '';
        $this->birth = '';
        $this->gender = '';
        $this->address = '';
        $this->ktp = '';
        $this->kk = '';
        $this->photo = '';
        $this->phone = '';
    }

    public function render()
    {
        return view('livewire.base.registration')->layout('layouts.app');
    }

    public function register() {
        $this->validate();
        
        $newUser = new User;
        $newUser->is_admin = false;
        $newUser->active_status = 'pending';
        $newUser->nip = $this->nip;
        $newUser->full_name = $this->full_name;
        $newUser->gender = $this->gender;
        $newUser->birth = $this->birth;
        $newUser->address = $this->address;
        $newUser->phone = $this->phone;
        
        // Storing Image
        $ktp_path = $this->ktp->store('ktp');
        $kk_path = $this->kk->store('kk');
        $photo_path = $this->photo->store('photo');

        $newUser->ktp = $ktp_path;
        $newUser->kk = $kk_path;
        $newUser->photo = $photo_path;

        $newUser->save();
        return redirect()->route('homepage');
    }

}

