<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\MaintenanceDataTable;
use App\Http\Requests\Fleet\CreateMaintenanceRequest;
use App\Http\Requests\Fleet\UpdateMaintenanceRequest;
use App\Repositories\Fleet\MaintenanceRepository;
use App\Repositories\Fleet\VehicleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Fleet\Vehicle;
use App\Repositories\Fleet\CategoryRepository;
use Carbon\Carbon;
use Response;
use Exception;
use PDF;

class MaintenanceController extends AppBaseController
{
    /** @var  MaintenanceRepository */
    protected $repository;
    protected $baseRoute = 'fleet.maintenances';
    protected $baseView = 'fleet.maintenances';
    public function __construct()
    {
        $this->repository = MaintenanceRepository::class;
    }

    /**
     * Display a listing of the Maintenance.
     *
     * @param MaintenanceDataTable $maintenanceDataTable
     * @return Response
     */
    public function index(MaintenanceDataTable $maintenanceDataTable)
    {
        return $maintenanceDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Maintenance.
     *
     * @return Response
     */
    public function create()
    {        
        return view($this->baseView.'.create')->with($this->getOptionItems())->with(['end' => false]);;
    }

    /**
     * Store a newly created Maintenance in storage.
     *
     * @param CreateMaintenanceRequest $request
     *
     * @return Response
     */
    public function store(CreateMaintenanceRequest $request)
    {
        $input = $request->all();

        $maintenance = $this->getRepositoryObj()->create($input);
        if($maintenance instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $maintenance->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/maintenances.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Maintenance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $maintenance = $this->getRepositoryObj()->find($id);

        if (empty($maintenance)) {
            Flash::error(__('models/maintenances.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('maintenance', $maintenance);
    }

    /**
     * Show the form for editing the specified Maintenance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $maintenance = $this->getRepositoryObj()->find($id);
        $services = $maintenance->maintenanceServices;
        $spareparts = $maintenance->maintenanceSpareparts;        
        if (empty($maintenance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/maintenances.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        if(empty($maintenance->getRawOriginal('end'))){
            $maintenance->end = localFormatDateTime(Carbon::now());
        }
        $tmpIndex = 'tmp_'.time();
        return view($this->baseView.'.edit')->with(['maintenance' => $maintenance, 'services' => $services, 'spareparts' => $spareparts, 'tmpIndex' => $tmpIndex])->with($this->getOptionItems())->with(['end' => true]);
    }

    /**
     * Update the specified Maintenance in storage.
     *
     * @param  int              $id
     * @param UpdateMaintenanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMaintenanceRequest $request)
    {
        $maintenance = $this->getRepositoryObj()->find($id);

        if (empty($maintenance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/maintenances.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $maintenance = $this->getRepositoryObj()->update($request->all(), $id);
        if($maintenance instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $maintenance->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/maintenances.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Maintenance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $maintenance = $this->getRepositoryObj()->find($id);

        if (empty($maintenance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/maintenances.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/maintenances.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Maintenance from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $vehicle = new VehicleRepository();
        $categories = new CategoryRepository();
        return [
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'vehicleItems' => ['' => __('crud.option.vehicle_placeholder')] + $vehicle->pluck(),
            'categoryItems' => ['' => __('crud.option.vehicle_placeholder')] + $categories->pluck()
        ];
    }

    public function history(int $vehicleId){
        $vehicle = Vehicle::with(['maintenances' => function($q){
            $q->with('maintenanceSpareparts', 'maintenanceServices');
        }])->find($vehicleId);
        $path = './vendor/images/logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $headerHtml = view('fleet.maintenances.header_pdf',['vehicle' => $vehicle, 'base64' => $base64])->render();
        $html = view('fleet.maintenances.history_pdf',['vehicle' => $vehicle, 'base64' => $base64])->render();
        
        //$headerHtml = '<div>Test header saja</div>';
        //$footerHtml = '<footer>ini footer</footer>';
        $pdf = PDF::loadHTML($html)->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-top', 30)                
            ->setOption('margin-bottom', 20)
            ->setOption('footer-center', '[page]/[topage]')
            ->setOption('header-html', $headerHtml);
          //  ->setOption('footer-html', $footerHtml);
        // PDF::loadView('pdf.payslip',['payroll' => $payroll])->setPaper('a4')->setOrientation('landscape');
        return $pdf->download('history_maintenance_'.$vehicle->registration_number.'.pdf');

    }
}
