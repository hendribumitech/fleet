<?php

namespace App\DataTables\Fleet;

use App\Models\Fleet\Vehicle;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class VehicleDataTable extends DataTable
{
    
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        //'name' => \App\DataTables\FilterClass\MatchKeyword::class,        
    ];
    
    private $mapColumnSearch = [
        //'entity.name' => 'entity_id',
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        if (!empty($this->columnFilterOperator)) {
            foreach ($this->columnFilterOperator as $column => $operator) {
                $columnSearch = $this->mapColumnSearch[$column] ?? $column;
                $dataTable->filterColumn($column, new $operator($columnSearch));                
            }
        }
        return $dataTable->addColumn('action', function($item){
            return view($this->baseView.'.datatables_actions', array_merge($item->toArray(), ['baseRoute' => $this->getBaseRoute()]));
        });        
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Vehicle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vehicle $model)
    {
        return $model->select([$model->getTable().'.*'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
                    [
                       'extend' => 'create',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-plus"></i> ' .__('auth.app.create').''
                    ],
                    [
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
                    ],
                    [
                       'extend' => 'import',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-upload"></i> ' .__('auth.app.import').''
                    ],
                    [
                       'extend' => 'print',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-print"></i> ' .__('auth.app.print').''
                    ],
                    [
                       'extend' => 'reset',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-undo"></i> ' .__('auth.app.reset').''
                    ],
                    [
                       'extend' => 'reload',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-refresh"></i> ' .__('auth.app.reload').''
                    ],
                ];
                
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"row" <"col-md-6"B><"col-md-6 text-end"l>>rtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => $buttons,
                 'language' => [
                   'url' => url('vendor/datatables/i18n/en-gb.json'),
                 ],
                 'responsive' => true,
                 'fixedHeader' => true,
                 'orderCellsTop' => true     
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'registration_number' => new Column(['title' => __('models/vehicles.fields.registration_number'),'name' => 'registration_number', 'data' => 'registration_number', 'searchable' => true, 'elmsearch' => 'text']),
            'name' => new Column(['title' => __('models/vehicles.fields.name'),'name' => 'name', 'data' => 'name', 'searchable' => true, 'elmsearch' => 'text']),
            'merk' => new Column(['title' => __('models/vehicles.fields.merk'),'name' => 'merk', 'data' => 'merk', 'searchable' => true, 'elmsearch' => 'text']),
            'engine_number' => new Column(['title' => __('models/vehicles.fields.engine_number'),'name' => 'engine_number', 'data' => 'engine_number', 'searchable' => true, 'elmsearch' => 'text']),
            //'identity_number' => new Column(['title' => __('models/vehicles.fields.identity_number'),'name' => 'identity_number', 'data' => 'identity_number', 'searchable' => true, 'elmsearch' => 'text']),
            //'owner_name' => new Column(['title' => __('models/vehicles.fields.owner_name'),'name' => 'owner_name', 'data' => 'owner_name', 'searchable' => true, 'elmsearch' => 'text']),
            //'registration_year' => new Column(['title' => __('models/vehicles.fields.registration_year'),'name' => 'registration_year', 'data' => 'registration_year', 'searchable' => true, 'elmsearch' => 'text']),
            //'purchase_date' => new Column(['title' => __('models/vehicles.fields.purchase_date'),'name' => 'purchase_date', 'data' => 'purchase_date', 'searchable' => true, 'elmsearch' => 'text']),
            //'vehicle_ownership_number' => new Column(['title' => __('models/vehicles.fields.vehicle_ownership_number'),'name' => 'vehicle_ownership_number', 'data' => 'vehicle_ownership_number', 'searchable' => true, 'elmsearch' => 'text']),
            'cilinder_capacity' => new Column(['title' => __('models/vehicles.fields.cilinder_capacity'),'name' => 'cilinder_capacity', 'class' => 'text-end' ,'data' => 'cilinder_capacity', 'searchable' => false, 'elmsearch' => 'text']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'vehicles_datatable_' . time();
    }

    
}
