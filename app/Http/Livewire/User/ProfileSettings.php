<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\ActivationLog;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProfileSettings extends Component
{
    use WithFileUploads;

    // Model Variable
    public $User;
    public $ActivationMessage;

    // Binding Variable
    public $editState;
    public $nip_edit;
    public $fullname_edit;
    public $gender_edit;
    public $birth_edit;
    public $phone_edit;
    public $address_edit;
    public $profile_edit;
    public $ktp_edit;
    public $kk_edit;

    protected $rules = [
        'nip_edit' => 'required|numeric',
        'fullname_edit' => 'required|string',
        'gender_edit' => 'required|string',
        'birth_edit' => 'required|date',
        'phone_edit' => 'required|numeric',
        'address_edit' => 'required|string',
        'profile_edit' => 'nullable|image|max:2048',
        'ktp_edit' => 'nullable|image|max:2048',
        'kk_edit' => 'nullable|image|max:2048',
    ];

    private function reset_edit_state() {
        $this->editState = false;
        $this->nip_edit = $this->User->nip;
        $this->fullname_edit = $this->User->full_name;
        $this->gender_edit = $this->User->gender;
        $this->birth_edit = $this->User->birth;
        $this->phone_edit = $this->User->phone_edit;
        $this->address_edit = $this->User->address;
        $this->profile_edit = '';
        $this->ktp_edit = '';
        $this->kk_edit = '';
    }
    
    public function mount() {
        $this->User = Auth::user();
        $this->ActivationMessage = ActivationLog::where('user_id', '=', $this->User->id)
                                            ->orderByDesc('created_at')
                                            ->first();
        $this->reset_edit_state();
    }


    public function render()
    {
        return view('livewire.user.profile-settings')->layout('layouts.row-app');
    }

    public function set_edit_state($status) {
        if ($status == false) {
            $this->reset_edit_state();
        }
        
        if ($this->User->active_status != 'active') {
            $this->editState = $status;
        }       
    }

    
    public function save_edited() {
        $this->validate();
        
        $UserEdit = User::find($this->User->id);
        $UserEdit->nip = $this->nip_edit;
        $UserEdit->full_name = $this->fullname_edit;
        $UserEdit->gender = $this->gender_edit;
        $UserEdit->birth = $this->birth_edit;
        $UserEdit->address = $this->address_edit;
        $UserEdit->phone_edit = $this->phone_edit;

        if ($this->profile_edit) {
            $profile_dir = public_path() . '/storage/' . $UserEdit->photo;
            $UserEdit->photo = $this->profile_edit->store('photo');

            // Unlink the old files
            if (file_exists($profile_dir)) {
                unlink($profile_dir);
            }
        }
        if ($this->ktp_edit) {
            $ktp_dir = public_path() . '/storage/' . $UserEdit->ktp;
            $UserEdit->ktp = $this->ktp_edit->store('ktp');

            // Unlink the old files
            if (file_exists($ktp_dir)) {
                unlink($ktp_dir);
            }
        }
        if ($this->kk_edit) {
            $kk_dir = public_path() . '/storage/' . $UserEdit->kk;
            $UserEdit->kk = $this->kk_edit->store('kk');

            // Unlink the old files
            if (file_exists($kk_dir)) {
                unlink($kk_dir);
            }
        }

        if ($UserEdit->save()) {
            $msg = 'Data berhasil diubah';
        }
        else {
            $msg = 'Terjadi Kesalahan';
        }
        
        return redirect(request()->header('Referer'))->with('message', $msg);
    }

}
