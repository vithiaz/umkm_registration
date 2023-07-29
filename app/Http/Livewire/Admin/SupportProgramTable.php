<?php

namespace App\Http\Livewire\Admin;

use App\Models\SupportProgram as SupportProgramModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class SupportProgramTable extends PowerGridComponent
{
    use ActionButton;

    public bool $active_status = true;

    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'refreshTable',
                'setStatusFilter',
            ]);
    }

    public function refreshTable() {
        $this->fillData();
    }

    public function setStatusFilter($status) {
        $this->active_status = $status;
    }


    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return SupportProgramModel::with(['umkm'])->where('active', '=', $this->active_status);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('program_type')
            ->addColumn('description')
            ->addColumn('quota')
            ->addColumn('open_date')
            ->addColumn('open_date_formatted', fn (SupportProgramModel $model) => Carbon::parse($model->open_date)->format('d/m/Y'))
            ->addColumn('end_date')
            ->addColumn('end_date_formatted', fn (SupportProgramModel $model) => Carbon::parse($model->end_date)->format('d/m/Y'))
            ->addColumn('umkm_count', fn (SupportProgramModel $model) => $model->umkm->count())
            ->addColumn('quota_formatted', function (SupportProgramModel $model) {
                $quota_num = $model->quota;
                $member_count = $model->umkm->count();
                if ($quota_num || $quota_num > 0) {
                    return strval($member_count) . ' / ' . strval($quota_num);
                } else {
                    return strval($member_count) . ' / ' . '&#8734;';
                }
            })
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (SupportProgramModel $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->hidden()
                ->searchable()
                ->sortable(),

            Column::make('Program', 'program_type')
                ->searchable()
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
                
            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->searchable(),

            Column::make('Nama Program', 'name')
                ->searchable(),

            Column::make('Deskripsi', 'description')
                ->hidden()
                ->searchable(),

            Column::make('Kuota', 'quota_formatted')
                ->searchable(),

            Column::make('Tanggal Pendaftaran', 'open_date')
                ->hidden()
                ->searchable(),
            
            Column::make('Tanggal Pendaftaran', 'open_date_formatted', 'open_date')
                ->searchable(),

            Column::make('Penutupan Pendaftaran', 'end_date')
                ->hidden()
                ->searchable(),
            
            Column::make('Penutupan Pendaftaran', 'end_date_formatted', 'end_date')
                ->searchable(),
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

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid SupportProgram Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
           Button::make('details', 'Detail')
                ->class('btn table-button-confirm')
                ->route('admin.umkm-program-details', ['program_id' => 'id'])
                ->target('_self'),
        ];
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid SupportProgram Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($support-program) => $support-program->id === 1)
                ->hide(),
        ];
    }
    */
}
