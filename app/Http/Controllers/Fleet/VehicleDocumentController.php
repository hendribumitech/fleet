<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\VehicleDocumentDataTable;
use App\Http\Requests\Fleet\CreateVehicleDocumentRequest;
use App\Http\Requests\Fleet\UpdateVehicleDocumentRequest;
use App\Repositories\Fleet\VehicleDocumentRepository;
use App\Repositories\Fleet\DocumentRepository;
use App\Repositories\Fleet\VehicleRepository;
use App\Traits\UploadedFile;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Fleet\Vehicle;
use Response;
use Exception;

class VehicleDocumentController extends AppBaseController
{
    use UploadedFile;
    /** @var  VehicleDocumentRepository */
    protected $repository;
    protected $baseRoute = 'fleet.vehicles.documents';
    protected $baseView = 'fleet.vehicle_documents';
    
    public function __construct()
    {
        $this->repository = VehicleDocumentRepository::class;
        $this->pathFolder .= '/documents';
    }

    /**
     * Display a listing of the VehicleDocument.
     *
     * @param VehicleDocumentDataTable $vehicleDocumentDataTable
     * @return Response
     */
    public function index(Vehicle $vehicle, VehicleDocumentDataTable $vehicleDocumentDataTable)
    {
        return $vehicleDocumentDataTable->setVehicle($vehicle->id)->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView, 'vehicle' => $vehicle]);
    }

    /**
     * Show the form for creating a new VehicleDocument.
     *
     * @return Response
     */
    public function create(Vehicle $vehicle)
    {
        return view($this->baseView.'.create')->with(['vehicle' => $vehicle])->with($this->getOptionItems());
    }

    /**
     * Store a newly created VehicleDocument in storage.
     *
     * @param CreateVehicleDocumentRequest $request
     *
     * @return Response
     */
    public function store(Vehicle $vehicle, CreateVehicleDocumentRequest $request)
    {
        $input = $request->all();        
        if($request->file('file_upload')){
            $input['path_file'] = $this->uploadFile($request, 'file_upload');
        }
        $input['vehicle_id'] = $vehicle->id;
        $vehicleDocument = $this->getRepositoryObj()->create($input);
        if($vehicleDocument instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleDocument->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/vehicleDocuments.singular')]));

        return redirect(route($this->baseRoute.'.index', $vehicle->id));
    }

    /**
     * Display the specified VehicleDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Vehicle $vehicle, $id)
    {
        $vehicleDocument = $this->getRepositoryObj()->find($id);

        if (empty($vehicleDocument)) {
            Flash::error(__('models/vehicleDocuments.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('vehicleDocument', $vehicleDocument);
    }

    /**
     * Show the form for editing the specified VehicleDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Vehicle $vehicle, $id)
    {
        $vehicleDocument = $this->getRepositoryObj()->find($id);

        if (empty($vehicleDocument)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleDocuments.singular')]));

            return redirect(route($this->baseRoute.'.index', $vehicle->id));
        }
        
        return view($this->baseView.'.edit')->with(['vehicleDocument' => $vehicleDocument, 'vehicle' => $vehicle])->with($this->getOptionItems());
    }

    /**
     * Update the specified VehicleDocument in storage.
     *
     * @param  int              $id
     * @param UpdateVehicleDocumentRequest $request
     *
     * @return Response
     */
    public function update(Vehicle $vehicle, $id, UpdateVehicleDocumentRequest $request)
    {
        $vehicleDocument = $this->getRepositoryObj()->find($id);

        if (empty($vehicleDocument)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleDocuments.singular')]));

            return redirect(route($this->baseRoute.'.index', $vehicle->id));
        }
        $input = $request->all();
        $input['vehicle_id'] = $vehicle->id;
        $input['path_file'] = $vehicleDocument->getRawOriginal('path_file');
        if($request->file('file_upload')){            
            $pathFile = $this->uploadFile($request, 'file_upload');
            if($pathFile){
                $input['path_file'] = $pathFile;
            }
        }
        
        $vehicleDocument = $this->getRepositoryObj()->update($input, $id);
        if($vehicleDocument instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleDocument->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/vehicleDocuments.singular')]));

        return redirect(route($this->baseRoute.'.index', $vehicle->id));
    }

    /**
     * Remove the specified VehicleDocument from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Vehicle $vehicle, $id)
    {
        $vehicleDocument = $this->getRepositoryObj()->find($id);

        if (empty($vehicleDocument)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleDocuments.singular')]));

            return redirect(route($this->baseRoute.'.index', $vehicle->id));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/vehicleDocuments.singular')]));

        return redirect(route($this->baseRoute.'.index', $vehicle->id));
    }

    /**
     * Provide options item based on relationship model VehicleDocument from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $document = new DocumentRepository(app());
        $vehicle = new VehicleRepository(app());
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'documentItems' => ['' => __('crud.option.document_placeholder')] + $document->pluck(),
            'vehicleItems' => ['' => __('crud.option.vehicle_placeholder')] + $vehicle->pluck(),
            'activeItems' => ['1' => __('crud.state_active'), '0' => __('crud.state_nonactive')],
        ];
    }
}
