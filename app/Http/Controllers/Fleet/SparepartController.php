<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\SparepartDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateSparepartRequest;
use App\Http\Requests\Fleet\UpdateSparepartRequest;
use App\Repositories\Fleet\SparepartRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SparepartController extends AppBaseController
{
    /** @var  SparepartRepository */
    protected $repository;
    protected $baseRoute = 'fleet.spareparts';
    protected $baseView = 'fleet.spareparts';
    public function __construct()
    {
        $this->repository = SparepartRepository::class;
    }

    /**
     * Display a listing of the Sparepart.
     *
     * @param SparepartDataTable $sparepartDataTable
     * @return Response
     */
    public function index(SparepartDataTable $sparepartDataTable)
    {
        return $sparepartDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Sparepart.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Sparepart in storage.
     *
     * @param CreateSparepartRequest $request
     *
     * @return Response
     */
    public function store(CreateSparepartRequest $request)
    {
        $input = $request->all();

        $sparepart = $this->getRepositoryObj()->create($input);
        if($sparepart instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $sparepart->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/spareparts.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Sparepart.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sparepart = $this->getRepositoryObj()->find($id);

        if (empty($sparepart)) {
            Flash::error(__('models/spareparts.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('sparepart', $sparepart);
    }

    /**
     * Show the form for editing the specified Sparepart.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sparepart = $this->getRepositoryObj()->find($id);

        if (empty($sparepart)) {
            Flash::error(__('messages.not_found', ['model' => __('models/spareparts.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('sparepart', $sparepart)->with($this->getOptionItems());
    }

    /**
     * Update the specified Sparepart in storage.
     *
     * @param  int              $id
     * @param UpdateSparepartRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSparepartRequest $request)
    {
        $sparepart = $this->getRepositoryObj()->find($id);

        if (empty($sparepart)) {
            Flash::error(__('messages.not_found', ['model' => __('models/spareparts.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $sparepart = $this->getRepositoryObj()->update($request->all(), $id);
        if($sparepart instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $sparepart->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/spareparts.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Sparepart from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sparepart = $this->getRepositoryObj()->find($id);

        if (empty($sparepart)) {
            Flash::error(__('messages.not_found', ['model' => __('models/spareparts.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/spareparts.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Sparepart from storage.         
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
