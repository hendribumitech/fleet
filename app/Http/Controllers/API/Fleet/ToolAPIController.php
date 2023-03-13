<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateToolAPIRequest;
use App\Http\Requests\API\Fleet\UpdateToolAPIRequest;
use App\Models\Fleet\Tool;
use App\Repositories\Fleet\ToolRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\ToolResource;
use Response;

/**
 * Class ToolController
 * @package App\Http\Controllers\API\Fleet
 */

class ToolAPIController extends AppBaseController
{
    /** @var  ToolRepository */
    private $toolRepository;

    public function __construct(ToolRepository $toolRepo)
    {
        $this->toolRepository = $toolRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/tools",
     *      summary="Get a listing of the Tools.",
     *      tags={"Tool"},
     *      description="Get all Tools",
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
     *                  @SWG\Items(ref="#/definitions/Tool")
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
        $tools = $this->toolRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ToolResource::collection($tools), 'Tools retrieved successfully');
    }

    /**
     * @param CreateToolAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tools",
     *      summary="Store a newly created Tool in storage",
     *      tags={"Tool"},
     *      description="Store Tool",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tool that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tool")
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
     *                  ref="#/definitions/Tool"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateToolAPIRequest $request)
    {
        $input = $request->all();

        $tool = $this->toolRepository->create($input);

        return $this->sendResponse(new ToolResource($tool), 'Tool saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tools/{id}",
     *      summary="Display the specified Tool",
     *      tags={"Tool"},
     *      description="Get Tool",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tool",
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
     *                  ref="#/definitions/Tool"
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
        /** @var Tool $tool */
        $tool = $this->toolRepository->find($id);

        if (empty($tool)) {
            return $this->sendError('Tool not found');
        }

        return $this->sendResponse(new ToolResource($tool), 'Tool retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateToolAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tools/{id}",
     *      summary="Update the specified Tool in storage",
     *      tags={"Tool"},
     *      description="Update Tool",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tool",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tool that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tool")
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
     *                  ref="#/definitions/Tool"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateToolAPIRequest $request)
    {
        $input = $request->all();

        /** @var Tool $tool */
        $tool = $this->toolRepository->find($id);

        if (empty($tool)) {
            return $this->sendError('Tool not found');
        }

        $tool = $this->toolRepository->update($input, $id);

        return $this->sendResponse(new ToolResource($tool), 'Tool updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/tools/{id}",
     *      summary="Remove the specified Tool from storage",
     *      tags={"Tool"},
     *      description="Delete Tool",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tool",
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
        /** @var Tool $tool */
        $tool = $this->toolRepository->find($id);

        if (empty($tool)) {
            return $this->sendError('Tool not found');
        }

        $tool->delete();

        return $this->sendSuccess('Tool deleted successfully');
    }
}
