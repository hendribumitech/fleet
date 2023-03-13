<?php

namespace App\Http\Controllers\Fleet;

use App\DataTables\Fleet\DocumentDataTable;
use App\Http\Requests\Fleet;
use App\Http\Requests\Fleet\CreateDocumentRequest;
use App\Http\Requests\Fleet\UpdateDocumentRequest;
use App\Repositories\Fleet\DocumentRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class DocumentController extends AppBaseController
{
    /** @var  DocumentRepository */
    protected $repository;
    protected $baseRoute = 'fleet.documents';
    protected $baseView = 'fleet.documents';
    public function __construct()
    {
        $this->repository = DocumentRepository::class;
    }

    /**
     * Display a listing of the Document.
     *
     * @param DocumentDataTable $documentDataTable
     * @return Response
     */
    public function index(DocumentDataTable $documentDataTable)
    {
        return $documentDataTable->setBaseView($this->baseView)->setBaseRoute($this->baseRoute)->render($this->baseView.'.index', ['baseView' => $this->baseView]);
    }

    /**
     * Show the form for creating a new Document.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->baseView.'.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Document in storage.
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $input = $request->all();

        $document = $this->getRepositoryObj()->create($input);
        if($document instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $document->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/documents.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Display the specified Document.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $document = $this->getRepositoryObj()->find($id);

        if (empty($document)) {
            Flash::error(__('models/documents.singular').' '.__('messages.not_found'));

            return redirect(route($this->baseRoute.'.index'));
        }

        return view($this->baseView.'.show')->with('document', $document);
    }

    /**
     * Show the form for editing the specified Document.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $document = $this->getRepositoryObj()->find($id);

        if (empty($document)) {
            Flash::error(__('messages.not_found', ['model' => __('models/documents.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }
        
        return view($this->baseView.'.edit')->with('document', $document)->with($this->getOptionItems());
    }

    /**
     * Update the specified Document in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentRequest $request)
    {
        $document = $this->getRepositoryObj()->find($id);

        if (empty($document)) {
            Flash::error(__('messages.not_found', ['model' => __('models/documents.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $document = $this->getRepositoryObj()->update($request->all(), $id);
        if($document instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $document->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/documents.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $document = $this->getRepositoryObj()->find($id);

        if (empty($document)) {
            Flash::error(__('messages.not_found', ['model' => __('models/documents.singular')]));

            return redirect(route($this->baseRoute.'.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/documents.singular')]));

        return redirect(route($this->baseRoute.'.index'));
    }

    /**
     * Provide options item based on relationship model Document from storage.         
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
