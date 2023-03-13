<?php

namespace App\DataTables\Fleet;

use App\Models\Fleet\Driver;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Fleet\VehicleRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class DriverDataTable extends DataTable
{
    
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'vehicle_id' => \App\DataTables\FilterClass\InKeyword::class
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
     * @param \App\Models\Driver $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Driver $model)
    {
        return $model->select([$model->getTable().'.*'])->with(['vehicle'])->newQuery();
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
        $vehicleItems = convertArrayPairValueWithKey((new VehicleRepository())->pluck());
        return [
            'name' => new Column(['title' => __('models/drivers.fields.name'),'name' => 'name', 'data' => 'name', 'searchable' => true, 'elmsearch' => 'text']),
            'code' => new Column(['title' => __('models/drivers.fields.code'),'name' => 'code', 'data' => 'code', 'searchable' => true, 'elmsearch' => 'text']),
            'vehicle_id' => new Column(['title' => __('models/drivers.fields.vehicle_id'),'name' => 'vehicle_id', 'data' => 'vehicle.name', 'defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $vehicleItems, 'multiple' => 'multiple'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'drivers_datatable_' . time();
    }

    
}
