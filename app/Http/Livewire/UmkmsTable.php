<?php

namespace App\Http\Livewire;

use App\Models\Umkm;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class UmkmsTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public $status = 'pending';

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

    public function refreshTable() {
        $this->fillData();
    }

    public function setStatusFilter($filter) {
        $this->status = $filter;
    }

    public function verifyUmkm($data) {
        $umkm_id = $data[0];

        $this->emitTo('umkm-verification', 'setVerifyData', $umkm_id);
    }


    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            // Detail::make()
            //     ->view('components.umkms-table-details')
            //     ->showCollapseIcon(),

        ];
    }

    public string $sortField = 'umkm.updated_at';

    public function datasource(): Builder
    {
        return Umkm::with([
                        'user',
                    ])->where('status', '=', $this->status);
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
                'address',
            ],
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('type')
            ->addColumn('owner_user', fn (Umkm $model) => $model->user->full_name)
            ->addColumn('owner_address', fn (Umkm $model) => $model->user->address)
            ->addColumn('recomendation_docs')
            ->addColumn('updated_at')
            ->addColumn('updated_at_formatted', fn (Umkm $model) => Carbon::parse($model->updated_at)->format('d/m/Y'))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Umkm $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden(),
            
            Column::make('Tanggal', 'updated_at_formatted', 'updated_at')
                ->sortable()
                ->searchable(),
                
            Column::make('Jenis', 'type')
                ->searchable()
                ->sortable(),

            Column::make('Nama', 'name')
                ->searchable(),

            Column::make('Nama Pemilik', 'owner_user')
                ->searchable(),

            Column::make('Alamat Pemilik', 'owner_address')
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
                
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable()
                ->hidden()
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
        // if ($this->status == 'pending') {
        //     $actions = [
        //            Button::make('details', 'Detail')
        //                ->class('btn table-button-confirm')
        //                ->emit('verifyUmkm', ['id']),
        //     ];
        // } else {
        //     $actions = [];
        // }
        
        $actions = [
                Button::make('details', 'Detail')
                    ->class('btn table-button-confirm')
                    ->emit('verifyUmkm', ['id']),
        ];

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
     * PowerGrid Umkm Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($umkm) => $umkm->id === 1)
                ->hide(),
        ];
    }
    */
}
