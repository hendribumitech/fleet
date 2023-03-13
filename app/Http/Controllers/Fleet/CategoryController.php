<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\CategoryDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateCategoryRequest;
use App\Http\Requests\Fleet\UpdateCategoryRequest;
use App\Repositories\Fleet\CategoryRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    protected $repository;
    protected $baseRoute = 'fleet.categories';
    protected $baseView = 'fleet.categories';
    public function __construct()
    {
        $this->repository = CategoryRepository::class;
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = $this->getRepositoryObj()->create($input);
        if($category instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $category->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/categories.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->getRepositoryObj()->find($id);

        if (empty($category)) {
            Flash::error(__('models/categories.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->getRepositoryObj()->find($id);

        if (empty($category)) {
            Flash::error(__('messages.not_found', ['model' => __('models/categories.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('category', $category)->with($this->getOptionItems());
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->getRepositoryObj()->find($id);

        if (empty($category)) {
            Flash::error(__('messages.not_found', ['model' => __('models/categories.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $category = $this->getRepositoryObj()->update($request->all(), $id);
        if($category instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $category->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/categories.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->getRepositoryObj()->find($id);

        if (empty($category)) {
            Flash::error(__('messages.not_found', ['model' => __('models/categories.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/categories.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Category from storage.         
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
