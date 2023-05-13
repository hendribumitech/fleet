<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateChecklistItemAPIRequest;
use App\Http\Requests\API\Fleet\UpdateChecklistItemAPIRequest;
use App\Models\Fleet\ChecklistItem;
use App\Repositories\Fleet\ChecklistItemRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\ChecklistItemResource;
use Response;

/**
 * Class ChecklistItemController
 * @package App\Http\Controllers\API\Fleet
 */

class ChecklistItemAPIController extends AppBaseController
{
    /** @var  ChecklistItemRepository */
    private $checklistItemRepository;

    public function __construct(ChecklistItemRepository $checklistItemRepo)
    {
        $this->checklistItemRepository = $checklistItemRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/checklistItems",
     *      summary="Get a listing of the ChecklistItems.",
     *      tags={"ChecklistItem"},
     *      description="Get all ChecklistItems",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/ChecklistItem")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $checklistItems = $this->checklistItemRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ChecklistItemResource::collection($checklistItems), 'Checklist Items retrieved successfully');
    }

    /**
     * @param CreateChecklistItemAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/checklistItems",
     *      summary="Store a newly created ChecklistItem in storage",
     *      tags={"ChecklistItem"},
     *      description="Store ChecklistItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ChecklistItem that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ChecklistItem")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ChecklistItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateChecklistItemAPIRequest $request)
    {
        $input = $request->all();

        $checklistItem = $this->checklistItemRepository->create($input);

        return $this->sendResponse(new ChecklistItemResource($checklistItem), 'Checklist Item saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/checklistItems/{id}",
     *      summary="Display the specified ChecklistItem",
     *      tags={"ChecklistItem"},
     *      description="Get ChecklistItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ChecklistItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ChecklistItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var ChecklistItem $checklistItem */
        $checklistItem = $this->checklistItemRepository->find($id);

        if (empty($checklistItem)) {
            return $this->sendError('Checklist Item not found');
        }

        return $this->sendResponse(new ChecklistItemResource($checklistItem), 'Checklist Item retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateChecklistItemAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/checklistItems/{id}",
     *      summary="Update the specified ChecklistItem in storage",
     *      tags={"ChecklistItem"},
     *      description="Update ChecklistItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ChecklistItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ChecklistItem that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ChecklistItem")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ChecklistItem"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateChecklistItemAPIRequest $request)
    {
        $input = $request->all();

        /** @var ChecklistItem $checklistItem */
        $checklistItem = $this->checklistItemRepository->find($id);

        if (empty($checklistItem)) {
            return $this->sendError('Checklist Item not found');
        }

        $checklistItem = $this->checklistItemRepository->update($input, $id);

        return $this->sendResponse(new ChecklistItemResource($checklistItem), 'ChecklistItem updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/checklistItems/{id}",
     *      summary="Remove the specified ChecklistItem from storage",
     *      tags={"ChecklistItem"},
     *      description="Delete ChecklistItem",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ChecklistItem",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var ChecklistItem $checklistItem */
        $checklistItem = $this->checklistItemRepository->find($id);

        if (empty($checklistItem)) {
            return $this->sendError('Checklist Item not found');
        }

        $checklistItem->delete();

        return $this->sendSuccess('Checklist Item deleted successfully');
    }
}
