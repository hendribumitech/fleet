<?php

namespace App\DataTables\Fleet;

use App\Models\Fleet\Maintenance;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Fleet\CategoryRepository;
use App\Repositories\Fleet\VehicleRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class MaintenanceDataTable extends DataTable
{
    
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'vehicle_id' => \App\DataTables\FilterClass\InKeyword::class,
        'categories_id' => \App\DataTables\FilterClass\InKeyword::class,
        'status' => \App\DataTables\FilterClass\InKeyword::class,
        'start' =>  \App\DataTables\FilterClass\BetweenKeyword::class,
        'end' =>  \App\DataTables\FilterClass\BetweenKeyword::class,
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
        $dataTable->editColumn('sparepart', function($item){
            $result = ['services' => [], 'spareparts' => []];
            $result['services'] = $item->maintenanceServices->pluck('description')->toArray();            
            $result['spareparts'] = $item->maintenanceSpareparts->map(function($item){
                return $item->sparepart->name.' ('.$item->quantity.')';
            })->toArray();
            return '<div>
                <div><div>Services :</div><ul><li>'.implode('</li><li>',$result['services']).'</li></ul></div>
                <hr>
                <div><div>Spareparts :</div><ul><li>'.implode('</li><li>',$result['spareparts']).'</li></ul></div>
                </div>';
        })->escapeColumns([]);
        return $dataTable->addColumn('action', function($item){
            return view($this->baseView.'.datatables_actions', array_merge($item->toArray(), ['baseRoute' => $this->getBaseRoute()]));
        });        
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Maintenance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Maintenance $model)
    {
        $vehicleId = $this->request()->get('vehicle_id');
        $query = $model->select([$model->getTable().'.*'])->with(['vehicle', 'maintenanceSpareparts', 'maintenanceServices', 'categories'])->newQuery();
        if($vehicleId){
            $query->where(['vehicle_id' => $vehicleId]);
        }        
        return $query; 
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
        $categoriesItems = convertArrayPairValueWithKey((new CategoryRepository())->pluck());
        $statusItem = convertArrayPairValueWithKey(['On Progress' => 'On Progress','Complete' => 'Complete']);
        return [
            'vehicle_id' => new Column(['title' => __('models/maintenances.fields.vehicle_id'),'name' => 'vehicle_id', 'data' => 'vehicle.name', 'searchable' => true, 'elmsearch' => 'dropdown', 'multiple' => 'multiple', 'listItem' => $vehicleItems]),
            'categories_id' => new Column(['title' => __('models/maintenances.fields.categories_id'),'name' => 'categories_id', 'data' => 'categories.name', 'defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'dropdown', 'multiple' => 'multiple', 'listItem' => $categoriesItems]),
            'odometer' => new Column(['title' => __('models/maintenances.fields.odometer'),'name' => 'odometer', 'data' => 'odometer', 'searchable' => false, 'elmsearch' => 'text', 'class' => 'text-end']),
            'start' => new Column(['title' => __('models/maintenances.fields.start'),'name' => 'start', 'data' => 'start', 'searchable' => true, 'elmsearch' => 'datetimerange']),
            'end' => new Column(['title' => __('models/maintenances.fields.end'),'name' => 'end', 'data' => 'end', 'searchable' => true, 'elmsearch' => 'datetimerange']),
            'sparepart' => new Column(['title' => __('models/maintenances.fields.spareparts'),'name' => 'sparepart', 'data' => 'sparepart', 'defaultContent' => '-', 'searchable' => false, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/maintenances.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text']),
            'status' => new Column(['title' => __('models/maintenances.fields.status'),'name' => 'status', 'data' => 'status', 'searchable' => true, 'elmsearch' => 'dropdown', 'multiple' => 'multiple','listItem' => $statusItem])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'maintenances_datatable_' . time();
    }

    
}
