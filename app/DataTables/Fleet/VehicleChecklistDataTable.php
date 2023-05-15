<?php

namespace App\DataTables\Fleet;

use App\Models\Fleet\VehicleChecklist;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Fleet\VehicleRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class VehicleChecklistDataTable extends DataTable
{    
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'vehicle_id' => \App\DataTables\FilterClass\InKeyword::class,
        'checklist_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
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
     * @param \App\Models\VehicleChecklist $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VehicleChecklist $model)
    {
        return $model->with(['vehicle'])->select([$model->getTable().'.*'])->newQuery();
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
                'order'     => [[1, 'desc']],
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
            'vehicle_id' => new Column(['title' => __('models/vehicleChecklists.fields.vehicle_id'),'name' => 'vehicle_id', 'data' => 'vehicle.name', 'searchable' => true, 'elmsearch' => 'dropdown', 'multiple' => 'multiple', 'listItem' => $vehicleItems]),
            'checklist_date' => new Column(['title' => __('models/vehicleChecklists.fields.checklist_date'),'name' => 'checklist_date', 'data' => 'checklist_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'summary' => new Column(['title' => __('models/vehicleChecklists.fields.summary'),'name' => 'summary', 'data' => 'summary', 'searchable' => false, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'vehicle_checklists_datatable_' . time();
    }
}
