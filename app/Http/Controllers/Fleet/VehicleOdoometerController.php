<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\VehicleOdoometerDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateVehicleOdoometerRequest;
use App\Http\Requests\Fleet\UpdateVehicleOdoometerRequest;
use App\Repositories\Fleet\VehicleOdoometerRepository;
use App\Repositories\Fleet\VehicleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Fleet\VehicleDriver;
use Response;
use Exception;
use Illuminate\Support\Facades\Auth;

class VehicleOdoometerController extends AppBaseController
{
    /** @var  VehicleOdoometerRepository */
    protected $repository;
    protected $baseRoute = 'fleet.vehicleOdoometers';
    protected $baseView = 'fleet.vehicle_odoometers';
    public function __construct()
    {
        $this->repository = VehicleOdoometerRepository::class;
    }

    /**
     * Display a listing of the VehicleOdoometer.
     *
     * @param VehicleOdoometerDataTable $vehicleOdoometerDataTable
     * @return Response
     */
    public function index(VehicleOdoometerDataTable $vehicleOdoometerDataTable)
    {
        return $vehicleOdoometerDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new VehicleOdoometer.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created VehicleOdoometer in storage.
     *
     * @param CreateVehicleOdoometerRequest $request
     *
     * @return Response
     */
    public function store(CreateVehicleOdoometerRequest $request)
    {
        $input = $request->all();

        $vehicleOdoometer = $this->getRepositoryObj()->create($input);
        if($vehicleOdoometer instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleOdoometer->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/vehicleOdoometers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified VehicleOdoometer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vehicleOdoometer = $this->getRepositoryObj()->find($id);

        if (empty($vehicleOdoometer)) {
            Flash::error(__('models/vehicleOdoometers.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('vehicleOdoometer', $vehicleOdoometer);
    }

    /**
     * Show the form for editing the specified VehicleOdoometer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vehicleOdoometer = $this->getRepositoryObj()->find($id);

        if (empty($vehicleOdoometer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleOdoometers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('vehicleOdoometer', $vehicleOdoometer)->with($this->getOptionItems());
    }

    /**
     * Update the specified VehicleOdoometer in storage.
     *
     * @param  int              $id
     * @param UpdateVehicleOdoometerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVehicleOdoometerRequest $request)
    {
        $vehicleOdoometer = $this->getRepositoryObj()->find($id);

        if (empty($vehicleOdoometer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleOdoometers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $vehicleOdoometer = $this->getRepositoryObj()->update($request->all(), $id);
        if($vehicleOdoometer instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleOdoometer->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/vehicleOdoometers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified VehicleOdoometer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vehicleOdoometer = $this->getRepositoryObj()->find($id);

        if (empty($vehicleOdoometer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleOdoometers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/vehicleOdoometers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model VehicleOdoometer from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $vehicle = (new VehicleRepository())->allQuery();
        
        if(Auth::user()->driver_id){
            $vehicleDriver = VehicleDriver::where(['driver_id' => Auth::user()->driver_id])->first();            
            if($vehicleDriver){
                $vehicle->whereId($vehicleDriver->vehicle_id);
            }else{
                $vehicle->whereNull('id');
            }
        }
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'vehicleItems' => ['' => __('crud.option.vehicle_placeholder')] + $vehicle->get()->pluck('name', 'id')->toArray()
        ];
    }
}
