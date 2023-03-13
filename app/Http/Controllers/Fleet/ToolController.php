<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\ToolDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateToolRequest;
use App\Http\Requests\Fleet\UpdateToolRequest;
use App\Repositories\Fleet\ToolRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ToolController extends AppBaseController
{
    /** @var  ToolRepository */
    protected $repository;
    protected $baseRoute = 'fleet.tools';
    protected $baseView = 'fleet.tools';
    public function __construct()
    {
        $this->repository = ToolRepository::class;
    }

    /**
     * Display a listing of the Tool.
     *
     * @param ToolDataTable $toolDataTable
     * @return Response
     */
    public function index(ToolDataTable $toolDataTable)
    {
        return $toolDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Tool.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Tool in storage.
     *
     * @param CreateToolRequest $request
     *
     * @return Response
     */
    public function store(CreateToolRequest $request)
    {
        $input = $request->all();

        $tool = $this->getRepositoryObj()->create($input);
        if($tool instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $tool->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/tools.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Tool.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tool = $this->getRepositoryObj()->find($id);

        if (empty($tool)) {
            Flash::error(__('models/tools.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('tool', $tool);
    }

    /**
     * Show the form for editing the specified Tool.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tool = $this->getRepositoryObj()->find($id);

        if (empty($tool)) {
            Flash::error(__('messages.not_found', ['model' => __('models/tools.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('tool', $tool)->with($this->getOptionItems());
    }

    /**
     * Update the specified Tool in storage.
     *
     * @param  int              $id
     * @param UpdateToolRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateToolRequest $request)
    {
        $tool = $this->getRepositoryObj()->find($id);

        if (empty($tool)) {
            Flash::error(__('messages.not_found', ['model' => __('models/tools.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $tool = $this->getRepositoryObj()->update($request->all(), $id);
        if($tool instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $tool->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/tools.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Tool from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tool = $this->getRepositoryObj()->find($id);

        if (empty($tool)) {
            Flash::error(__('messages.not_found', ['model' => __('models/tools.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/tools.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Tool from storage.         
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
