<?php

namespace App\DataTables\Fleet;

use App\Models\Fleet\VehicleDocument;
use App\DataTables\BaseDataTable as DataTable;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class VehicleDocumentDataTable extends DataTable
{    
    private $vehicle;
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
        $dataTable->editColumn('path_file', function($item){
            if($item->path_file){
                return '<a href="'.Storage::url('').'?path='.$item->path_file.'" target="_blank">file attachment</a>';
            }
            return null;
        })->escapeColumns([]);
        return $dataTable->addColumn('action', function($item){
            return view($this->baseView.'.datatables_actions', array_merge($item->toArray(), ['baseRoute' => $this->getBaseRoute()]));
        });        
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\VehicleDocument $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VehicleDocument $model)
    {

        return $model->whereVehicleId($this->getVehicle())->select([$model->getTable().'.*'])->with(['document'])->newQuery();
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
            'name' => new Column(['title' => __('models/vehicleDocuments.fields.name'),'name' => 'name', 'data' => 'name', 'searchable' => true, 'elmsearch' => 'text']),
            'number' => new Column(['title' => __('models/vehicleDocuments.fields.number'),'name' => 'number', 'data' => 'number', 'searchable' => true, 'elmsearch' => 'text']),
            'document_id' => new Column(['title' => __('models/vehicleDocuments.fields.document_id'),'name' => 'document_id', 'data' => 'document.name', 'searchable' => true, 'elmsearch' => 'text']),
            // 'vehicle_id' => new Column(['title' => __('models/vehicleDocuments.fields.vehicle_id'),'name' => 'vehicle_id', 'data' => 'vehicle_id', 'searchable' => true, 'elmsearch' => 'text']),
            'path_file' => new Column(['title' => __('models/vehicleDocuments.fields.path_file'),'name' => 'path_file', 'data' => 'path_file', 'searchable' => true, 'elmsearch' => 'text']),
            'issued_at' => new Column(['title' => __('models/vehicleDocuments.fields.issued_at'),'name' => 'issued_at', 'data' => 'issued_at', 'searchable' => true, 'elmsearch' => 'text']),
            'expired_at' => new Column(['title' => __('models/vehicleDocuments.fields.expired_at'),'name' => 'expired_at', 'data' => 'expired_at', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'vehicle_documents_datatable_' . time();
    }

    /**
     * Get the value of vehicle
     */ 
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set the value of vehicle
     *
     * @return  self
     */ 
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
