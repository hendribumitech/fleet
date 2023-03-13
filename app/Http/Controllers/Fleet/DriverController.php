<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\DriverDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateDriverRequest;
use App\Http\Requests\Fleet\UpdateDriverRequest;
use App\Repositories\Fleet\DriverRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Fleet\VehicleRepository;
use Response;
use Exception;

class DriverController extends AppBaseController
{
    /** @var  DriverRepository */
    protected $repository;
    protected $baseRoute = 'fleet.drivers';
    protected $baseView = 'fleet.drivers';
    public function __construct()
    {
        $this->repository = DriverRepository::class;
    }

    /**
     * Display a listing of the Driver.
     *
     * @param DriverDataTable $driverDataTable
     * @return Response
     */
    public function index(DriverDataTable $driverDataTable)
    {
        return $driverDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Driver.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Driver in storage.
     *
     * @param CreateDriverRequest $request
     *
     * @return Response
     */
    public function store(CreateDriverRequest $request)
    {
        $input = $request->all();

        $driver = $this->getRepositoryObj()->create($input);
        if($driver instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $driver->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/drivers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driver = $this->getRepositoryObj()->find($id);

        if (empty($driver)) {
            Flash::error(__('models/drivers.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('driver', $driver);
    }

    /**
     * Show the form for editing the specified Driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driver = $this->getRepositoryObj()->find($id);

        if (empty($driver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/drivers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        $optionItems = $this->getOptionItems();
        if($driver->vehicle_id){
            $optionItems['vehicleItems'] = $optionItems['vehicleItems'] + [$driver->vehicle_id => $driver->vehicle->name];
        }
        
        return view($this->baseView.'.edit')->with('driver', $driver)->with($optionItems);
    }

    /**
     * Update the specified Driver in storage.
     *
     * @param  int              $id
     * @param UpdateDriverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDriverRequest $request)
    {
        $driver = $this->getRepositoryObj()->find($id);

        if (empty($driver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/drivers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $driver = $this->getRepositoryObj()->update($request->all(), $id);
        if($driver instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $driver->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/drivers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Driver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driver = $this->getRepositoryObj()->find($id);

        if (empty($driver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/drivers.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/drivers.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Driver from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $vehicle = (new VehicleRepository(app()))->allQuery()->disableModelCaching()->doesntHave('vehicleDrivers');  
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'vehicleItems' => ['' => __('crud.option.vehicle_placeholder')] + $vehicle->pluck('name','id')->toArray()
        ];
    }
}
