<?php

namespace App\Http\Livewire\Admin;

use App\Models\SolarRecomendationRequest;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class SolarRecomendationRequestTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public $status = 'pending';

    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'verifyRequest',
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

    public function verifyRequest($data) {
        $request_id = $data[0];

        $this->emitTo('admin.verify-solar-recomendation', 'setVerifyData', $request_id);
    }

    public function setUp(): array
    {
        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return SolarRecomendationRequest::with([
            'solar_recomendation',
            'umkm',
            'user',
        ])->where('status', '=', $this->status);
    }


    public function relationSearch(): array
    {
        return [
            'user' => [
                'full_name',
                'address',
            ],
        ];
    }


    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('status')
            ->addColumn('message')
            ->addColumn('umkm_name', fn (SolarRecomendationRequest $model) => $model->umkm->name)
            ->addColumn('user_name', fn (SolarRecomendationRequest $model) => $model->user->full_name)
            ->addColumn('nip', fn (SolarRecomendationRequest $model) => $model->user->nip)
            ->addColumn('owner_address', fn (SolarRecomendationRequest $model) => $model->user->address)
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (SolarRecomendationRequest $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Tanggal', 'created_at')
                ->sortable()
                ->searchable()
                ->hidden(),

            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->sortable()
                ->searchable(),

            Column::make('ID', 'id')
                ->searchable()
                ->hidden()
                ->sortable(),

            Column::make('Status', 'status')
                ->searchable()
                ->sortable(),

            Column::make('UMKM', 'umkm_name')
                ->searchable(),

            Column::make('Pemilik', 'user_name')
                ->searchable(),

            Column::make('NIK Pemilik', 'nip')
                ->searchable(),

            Column::make('Alamat Pemilik', 'owner_address')
                ->searchable()

        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            // Filter::inputText('name'),
            // Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    
    public function actions(): array
    {
        $actions = [
            Button::make('details', 'Detail')
                ->class('btn table-button-confirm')
                ->emit('verifyRequest', ['id']),
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
     * PowerGrid SolarRecomendationRequest Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($solar-recomendation-request) => $solar-recomendation-request->id === 1)
                ->hide(),
        ];
    }
    */
}
