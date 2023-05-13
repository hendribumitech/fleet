<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\VehicleChecklistDataTable;
use App\Http\Requests\Fleet\CreateVehicleChecklistRequest;
use App\Http\Requests\Fleet\UpdateVehicleChecklistRequest;
use App\Repositories\Fleet\VehicleChecklistRepository;
use App\Repositories\Fleet\VehicleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Fleet\ChecklistItemRepository;
use Response;
use Exception;

class VehicleChecklistController extends AppBaseController
{
    /** @var  VehicleChecklistRepository */
    protected $repository;
    protected $baseRoute = 'fleet.vehicleChecklists';
    protected $baseView = 'fleet.vehicle_checklists';
    public function __construct()
    {
        $this->repository = VehicleChecklistRepository::class;
    }

    /**
     * Display a listing of the VehicleChecklist.
     *
     * @param VehicleChecklistDataTable $vehicleChecklistDataTable
     * @return Response
     */
    public function index(VehicleChecklistDataTable $vehicleChecklistDataTable)
    {
        return $vehicleChecklistDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new VehicleChecklist.
     *
     * @return Response
     */
    public function create()
    {        
        return view($this->baseView.'.create')->with('vehicleChecklistItem', collect([]))->with($this->getOptionItems());
    }

    /**
     * Store a newly created VehicleChecklist in storage.
     *
     * @param CreateVehicleChecklistRequest $request
     *
     * @return Response
     */
    public function store(CreateVehicleChecklistRequest $request)
    {
        $input = $request->all();

        $vehicleChecklist = $this->getRepositoryObj()->create($input);
        if($vehicleChecklist instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleChecklist->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/vehicleChecklists.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified VehicleChecklist.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vehicleChecklist = $this->getRepositoryObj()->find($id);

        if (empty($vehicleChecklist)) {
            Flash::error(__('models/vehicleChecklists.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('vehicleChecklist', $vehicleChecklist);
    }

    /**
     * Show the form for editing the specified VehicleChecklist.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vehicleChecklist = $this->getRepositoryObj()->find($id);
        
        if (empty($vehicleChecklist)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleChecklists.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        $vehicleChecklistItem = $vehicleChecklist->vehicleChecklistItems->keyBy('checklist_item_id');
        return view($this->baseView.'.edit')->with(['vehicleChecklist' => $vehicleChecklist, 'vehicleChecklistItem' => $vehicleChecklistItem])->with($this->getOptionItems());
    }

    /**
     * Update the specified VehicleChecklist in storage.
     *
     * @param  int              $id
     * @param UpdateVehicleChecklistRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVehicleChecklistRequest $request)
    {
        $vehicleChecklist = $this->getRepositoryObj()->find($id);

        if (empty($vehicleChecklist)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleChecklists.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $vehicleChecklist = $this->getRepositoryObj()->update($request->all(), $id);
        if($vehicleChecklist instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $vehicleChecklist->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/vehicleChecklists.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified VehicleChecklist from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vehicleChecklist = $this->getRepositoryObj()->find($id);

        if (empty($vehicleChecklist)) {
            Flash::error(__('messages.not_found', ['model' => __('models/vehicleChecklists.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/vehicleChecklists.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model VehicleChecklist from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $vehicle = new VehicleRepository();
        $checklistItems = new ChecklistItemRepository();
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'vehicleItems' => ['' => __('crud.option.vehicle_placeholder')] + $vehicle->pluck(),
            'checklistItems' => $checklistItems->all(),
            'statusItems' => ['' => 'Pilih status', 'OK' => 'OK', 'NO' => 'NO']
        ];
    }
}
