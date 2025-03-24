<?php

namespace App\Http\Livewire;

use App\Models\Koperasi;
use Illuminate\Support\Carbon;
use App\Exports\KoperasiExport;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class KoperasiTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public $status = 'pending';

    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'verifyKoperasi',
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

    public function verifyKoperasi($data) {
        $koperasi_id = $data[0];

        $this->emitTo('koperasi-verification', 'setVerifyData', $koperasi_id);
    }

    public function xlsx_export() {
        $current_time = Carbon::now()->timestamp;
        $filename = $this->status . '_report_koperasi_' . $current_time . '.xlsx';
        return (new KoperasiExport($this->status))->download($filename);
    }



    public function setUp(): array
    {
        return [
            Header::make()
                ->includeViewOnTop('components.audit-report-table-header-export')
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            // Detail::make()
            //     ->view('components.umkms-table-details')
            //     ->showCollapseIcon(),

        ];
    }

    public string $sortField = 'koperasi.updated_at';
    public string $sortDirection = 'desc';

    public function datasource(): Builder
    {
        return Koperasi::with([
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
            ->addColumn('legal_number')
            ->addColumn('legal_date')
            ->addColumn('legal_date_formatted', fn (Koperasi $model) => Carbon::parse($model->legal_date)->format('d/m/Y'))
            ->addColumn('address')
            ->addColumn('village')
            ->addColumn('sub_district')
            ->addColumn('owner_user', fn (Koperasi $model) => $model->user->full_name)
            ->addColumn('owner_address', fn (Koperasi $model) => $model->user->address)
            ->addColumn('updated_at')
            ->addColumn('updated_at_formatted', fn (Koperasi $model) => Carbon::parse($model->updated_at)->format('d/m/Y'))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Koperasi $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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

            Column::make('Nama', 'name')
                ->searchable(),

            Column::make('No. Badan Hukum', 'legal_number')
                ->searchable(),

            Column::make('Tanggal Badan Hukum', 'legal_date_formatted', 'legal_date')
                ->sortable()
                ->searchable(),

            Column::make('Desa / Kelurahan', 'village')
                ->searchable(),

            Column::make('Kecamatan', 'sub_district')
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
                    ->emit('verifyKoperasi', ['id']),
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
     * PowerGrid Koperasi Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($koperasi) => $koperasi->id === 1)
                ->hide(),
        ];
    }
    */
}
