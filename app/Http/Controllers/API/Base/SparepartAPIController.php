<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Requests\API\Base\CreateSparepartAPIRequest;
use App\Http\Requests\API\Base\UpdateSparepartAPIRequest;
use App\Models\Base\Sparepart;
use App\Repositories\Base\SparepartRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Base\SparepartResource;
use Response;

/**
 * Class SparepartController
 * @package App\Http\Controllers\API\Base
 */

class SparepartAPIController extends AppBaseController
{
    /** @var  SparepartRepository */
    private $sparepartRepository;

    public function __construct(SparepartRepository $sparepartRepo)
    {
        $this->sparepartRepository = $sparepartRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/spareparts",
     *      summary="Get a listing of the Spareparts.",
     *      tags={"Sparepart"},
     *      description="Get all Spareparts",
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
     *                  @SWG\Items(ref="#/definitions/Sparepart")
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
        $spareparts = $this->sparepartRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SparepartResource::collection($spareparts), 'Spareparts retrieved successfully');
    }

    /**
     * @param CreateSparepartAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/spareparts",
     *      summary="Store a newly created Sparepart in storage",
     *      tags={"Sparepart"},
     *      description="Store Sparepart",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Sparepart that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Sparepart")
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
     *                  ref="#/definitions/Sparepart"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSparepartAPIRequest $request)
    {
        $input = $request->all();

        $sparepart = $this->sparepartRepository->create($input);

        return $this->sendResponse(new SparepartResource($sparepart), 'Sparepart saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/spareparts/{id}",
     *      summary="Display the specified Sparepart",
     *      tags={"Sparepart"},
     *      description="Get Sparepart",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sparepart",
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
     *                  ref="#/definitions/Sparepart"
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
        /** @var Sparepart $sparepart */
        $sparepart = $this->sparepartRepository->find($id);

        if (empty($sparepart)) {
            return $this->sendError('Sparepart not found');
        }

        return $this->sendResponse(new SparepartResource($sparepart), 'Sparepart retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSparepartAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/spareparts/{id}",
     *      summary="Update the specified Sparepart in storage",
     *      tags={"Sparepart"},
     *      description="Update Sparepart",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sparepart",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Sparepart that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Sparepart")
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
     *                  ref="#/definitions/Sparepart"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSparepartAPIRequest $request)
    {
        $input = $request->all();

        /** @var Sparepart $sparepart */
        $sparepart = $this->sparepartRepository->find($id);

        if (empty($sparepart)) {
            return $this->sendError('Sparepart not found');
        }

        $sparepart = $this->sparepartRepository->update($input, $id);

        return $this->sendResponse(new SparepartResource($sparepart), 'Sparepart updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/spareparts/{id}",
     *      summary="Remove the specified Sparepart from storage",
     *      tags={"Sparepart"},
     *      description="Delete Sparepart",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Sparepart",
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
        /** @var Sparepart $sparepart */
        $sparepart = $this->sparepartRepository->find($id);

        if (empty($sparepart)) {
            return $this->sendError('Sparepart not found');
        }

        $sparepart->delete();

        return $this->sendSuccess('Sparepart deleted successfully');
    }
}
