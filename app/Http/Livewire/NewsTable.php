<?php

namespace App\Http\Livewire;

use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class NewsTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public $active_status = true;
    
    
    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'refreshTable',
                'set_inactive',
                'set_active_status',
            ]);
    }

    public function set_active_status($status) {
        $this->active_status = $status;
        $this->fillData();
    }
    
    
    public function set_inactive($data) {
        $news_id = $data[0];
        
        $News = News::find($news_id);
        if ($News) {
            $News->is_active = false;
            $News->save();

            $msg = ['success' => 'Berita di nonaktifkan'];
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
        }
    }


    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Detail::make()
                ->view('components.news-table-details')
                // ->options(['name' => 'Luan'])
                ->showCollapseIcon(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\News>
     */
    public function datasource(): Builder
    {
        return News::where('is_active', '=', $this->active_status);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('body')
            ->addColumn('body_html', fn (News $model) => strval($model->body))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (News $model) => Carbon::parse($model->created_at)->format('d/m/Y H:m'));
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
            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Waktu', 'created_at_formatted', 'created_at')
                ->sortable()
                ->searchable(),

            Column::make('ID', 'id')
                ->searchable()
                ->hidden()
                ->sortable(),

            Column::make('Judul', 'title')
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

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid News Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
        if ($this->active_status) {
            $buttons = [
                Button::make('deactivated', 'Nonaktifkan')
                    ->class('btn deactive-btn')
                    ->emit('set_inactive', ['id'])
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
     * PowerGrid News Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($news) => $news->id === 1)
                ->hide(),
        ];
    }
    */
}
