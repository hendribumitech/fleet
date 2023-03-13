<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\VehicleDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateVehicleRequest;
use App\Http\Requests\Fleet\UpdateVehicleRequest;
use App\Repositories\Fleet\VehicleRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class VehicleController extends AppBaseController
{
    /** @var  VehicleRepository */
    protected $repository;
    protected $baseRoute = 'fleet.vehicles';
    protected $baseView = 'fleet.vehicles';
    public function __construct()
    {
        $this->repository = VehicleRepository::class;
    }

    /**
     * Display a listing of the Vehicle.
     *
     * @param VehicleDataTable $vehicleDataTable
     * @return Response
     */
    public function index(VehicleDataTable $vehicleDataTable)
    {
        return $vehicleDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Vehicle.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Vehicle in storage.
     *
     * @param CreateVehicleRequest $request
     *
     * @return Response
     */
    public function store(CreateVehicleRequest $request)
    {
        $input = $request->all();

        $vehicle = $this->getRepositoryObj()->create($input);
        if($vehicle instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicle->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/vehicles.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Vehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vehicle = $this->getRepositoryObj()->find($id);

        if (empty($vehicle)) {
            Flash::error(__('models/vehicles.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('vehicle', $vehicle);
    }

    /**
     * Show the form for editing the specified Vehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vehicle = $this->getRepositoryObj()->find($id);

        if (empty($vehicle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicles.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('vehicle', $vehicle)->with($this->getOptionItems());
    }

    /**
     * Update the specified Vehicle in storage.
     *
     * @param  int              $id
     * @param UpdateVehicleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVehicleRequest $request)
    {
        $vehicle = $this->getRepositoryObj()->find($id);

        if (empty($vehicle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicles.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $vehicle = $this->getRepositoryObj()->update($request->all(), $id);
        if($vehicle instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicle->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/vehicles.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Vehicle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vehicle = $this->getRepositoryObj()->find($id);

        if (empty($vehicle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicles.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/vehicles.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Vehicle from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
                        
        ];
    }
}
