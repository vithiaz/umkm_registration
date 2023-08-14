<?php

namespace App\Http\Livewire\Components;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    // Binding Variable
    public $nip;
    public $birth;

    // Model Variable
    // public $User;

    protected $rules = [
        'nip' => 'required|numeric',
        'birth' => 'required',
    ];

    protected $messages = [
        'nip.required' => 'NIK tidak boleh kosong.',
        'nip.numeric' => 'NIK harus berupa angka.',
        'birth.required' => 'Tanggal Lahir tidak boleh kosong.',
    ];

    public function render()
    {
        return view('livewire.components.login');
    }

    public function login() {
        $this->validate();

        $User = User::where('nip', '=', $this->nip)->get()->first();
        $remember_me = true;

        if ($User) {
            if ($User->birth == $this->birth) {
                if (Auth::loginUsingId($User->id, $remember_me)) {
                    return redirect(request()->header('Referer'));
                } else {
                    session()->flash('error', 'Login Gagal!');
                }
            } else {
                $this->birth = '';
                session()->flash('error', 'Tanggal Lahir tidak cocok');
            }
        } else {
            $this->nip = '';
            $this->birth = '';
            session()->flash('error', 'NIK tidak terdaftar!');
        }
    }

    public function check_login() {
        $this->login();
    }
}
