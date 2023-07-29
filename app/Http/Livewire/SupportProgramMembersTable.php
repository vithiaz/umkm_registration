<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use App\Models\SupportProgramMember;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class SupportProgramMembersTable extends PowerGridComponent
{
    use ActionButton;
    
    // Binding Variable
    public $status = 'pending';
    public string $program_id;

    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'verifyUmkm',
                'refreshTable',
                'setStatusFilter',
            ]);
    }

    public function verifyUmkm($data) {
        $ProgramMemberId = $data[0];
        
        $ProgramMember = SupportProgramMember::find($ProgramMemberId);
        if ($ProgramMember) {
            $ProgramMember->status = 'verified';

            if ($ProgramMember->save()) {
                $msg = ['success' => 'Umkm didaftarkan'];
            } else {
                $msg = ['danger' => 'Terjadi Kesalahan'];
            }
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
        }
        
    }
    public function setStatusFilter($filter) {
        $this->status = $filter;
    }

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Detail::make()
                ->view('components.support-program-members-table-details')
                ->showCollapseIcon(),
        ];
    }

    public function datasource(): Builder
    {
        return SupportProgramMember::with(['umkm', 'user'])->where([
            ['program_id', '=', $this->program_id],
            ['status', '=', $this->status],
        ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('status')
            ->addColumn('umkm_name', fn (SupportProgramMember $model) => $model->umkm->name)
            ->addColumn('owner_name', fn (SupportProgramMember $model) => $model->user->full_name)
            ->addColumn('owner_address', fn (SupportProgramMember $model) => $model->user->address)
            ->addColumn('owner_photo', fn (SupportProgramMember $model) => $model->user->photo)
            ->addColumn('owner_ktp', fn (SupportProgramMember $model) => $model->user->ktp)
            ->addColumn('owner_kk', fn (SupportProgramMember $model) => $model->user->kk)
            ->addColumn('permission_docs', fn (SupportProgramMember $model) => $model->umkm->permission_docs)
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (SupportProgramMember $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable(),

            Column::make('ID', 'id')
                ->searchable()
                ->hidden(),

            Column::make('Nama', 'umkm_name')
                ->searchable(),

            Column::make('Nama Pemilik', 'owner_name')
                ->searchable(),

            Column::make('Alamat Pemilik', 'owner_address')
                ->searchable(),

        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name'),
            // Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid SupportProgramMember Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        
        if ($this->status == 'pending') {
            $buttons = [
                Button::make('verify', 'Daftarkan ke Program')
                ->class('btn table-button-confirm')
                ->emit('verifyUmkm', ['id']),
            ];
        } else {
            $buttons = [];    
        }

        return $buttons;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid SupportProgramMember Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($support-program-member) => $support-program-member->id === 1)
                ->hide(),
        ];
    }
    */
}
