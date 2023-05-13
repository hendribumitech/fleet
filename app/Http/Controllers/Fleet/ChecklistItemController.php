<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\ChecklistItemDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateChecklistItemRequest;
use App\Http\Requests\Fleet\UpdateChecklistItemRequest;
use App\Repositories\Fleet\ChecklistItemRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ChecklistItemController extends AppBaseController
{
    /** @var  ChecklistItemRepository */
    protected $repository;
    protected $baseRoute = 'fleet.checklistItems';
    protected $baseView = 'fleet.checklist_items';
    public function __construct()
    {
        $this->repository = ChecklistItemRepository::class;
    }

    /**
     * Display a listing of the ChecklistItem.
     *
     * @param ChecklistItemDataTable $checklistItemDataTable
     * @return Response
     */
    public function index(ChecklistItemDataTable $checklistItemDataTable)
    {
        return $checklistItemDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new ChecklistItem.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created ChecklistItem in storage.
     *
     * @param CreateChecklistItemRequest $request
     *
     * @return Response
     */
    public function store(CreateChecklistItemRequest $request)
    {
        $input = $request->all();

        $checklistItem = $this->getRepositoryObj()->create($input);
        if($checklistItem instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $checklistItem->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/checklistItems.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified ChecklistItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $checklistItem = $this->getRepositoryObj()->find($id);

        if (empty($checklistItem)) {
            Flash::error(__('models/checklistItems.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('checklistItem', $checklistItem);
    }

    /**
     * Show the form for editing the specified ChecklistItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $checklistItem = $this->getRepositoryObj()->find($id);

        if (empty($checklistItem)) {
            Flash::error(__('messages.not_found', ['model' => __('models/checklistItems.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('checklistItem', $checklistItem)->with($this->getOptionItems());
    }

    /**
     * Update the specified ChecklistItem in storage.
     *
     * @param  int              $id
     * @param UpdateChecklistItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChecklistItemRequest $request)
    {
        $checklistItem = $this->getRepositoryObj()->find($id);

        if (empty($checklistItem)) {
            Flash::error(__('messages.not_found', ['model' => __('models/checklistItems.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $checklistItem = $this->getRepositoryObj()->update($request->all(), $id);
        if($checklistItem instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $checklistItem->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/checklistItems.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified ChecklistItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $checklistItem = $this->getRepositoryObj()->find($id);

        if (empty($checklistItem)) {
            Flash::error(__('messages.not_found', ['model' => __('models/checklistItems.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/checklistItems.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model ChecklistItem from storage.         
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
