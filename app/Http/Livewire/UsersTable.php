<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class UsersTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public $status = 'pending';

    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'verifyUser',
                'deleteUser',
                'refreshTable',
                'setStatusFilter',
            ]);
    }

    public function verifyUser($data) {
        $userID = $data[0];
        $User = User::find($userID);
        if ($User) {
            $User->active_status = 'active';
            
            if ($User->save()) {
                $msg = ['success' => 'User diverifikasi'];
            } else {
                $msg = ['danger' => 'Terjadi Kesalahan'];
            }
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
        }
    }
    public function deleteUser($data) {
        $userID = $data[0];
        $User = User::find($userID);

        if ($User) {
            if ($User->delete()) {
                $msg = ['info' => 'Pengajuan ditolak'];
            } else {
                $msg = ['danger' => 'Terjadi Kesalahan'];
            }
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
        }

    }

    public function refreshTable() {
        $this->fillData();
    }

    public function setStatusFilter($filter) {
        $this->status = $filter;
    }

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Detail::make()
                ->view('components.users-table-details')
                ->showCollapseIcon(),
        ];
    }

    public function datasource(): Builder
    {
        return User::where('active_status', '=', $this->status);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('nip')
            ->addColumn('full_name')
            ->addColumn('gender')
            ->addColumn('birth_date')
            ->addColumn('address')
            ->addColumn('ktp')
            ->addColumn('kk')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden(),

            Column::make('nip', 'nip')
                ->searchable(),

            Column::make('Nama Lengkap', 'full_name')
                ->searchable(),

            Column::make('Jenis Kelamin', 'gender')
                ->searchable(),

            Column::make('Tanggal Lahir', 'birth_date')
                ->searchable(),

            Column::make('Alamat', 'address')
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
                
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable()
                ->hidden(),
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name'),
            // Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }


    public function actions(): array
    {
        if ($this->status == 'pending') {
            $actions = [
                   Button::make('verify', 'Verifikasi')
                       ->class('btn table-button-confirm')
                       ->emit('verifyUser', ['id']),
                    Button::make('decine', 'Tolak')
                       ->class('btn table-button-decline')
                       ->emit('deleteUser', ['id']),
            ];
        } else {
            $actions = [];
        }
        
        return $actions;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($user) => $user->id === 1)
                ->hide(),
        ];
    }
    */
}
