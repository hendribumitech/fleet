<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateVehicleDocumentAPIRequest;
use App\Http\Requests\API\Fleet\UpdateVehicleDocumentAPIRequest;
use App\Models\Fleet\VehicleDocument;
use App\Repositories\Fleet\VehicleDocumentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\VehicleDocumentResource;
use Response;

/**
 * Class VehicleDocumentController
 * @package App\Http\Controllers\API\Fleet
 */

class VehicleDocumentAPIController extends AppBaseController
{
    /** @var  VehicleDocumentRepository */
    private $vehicleDocumentRepository;

    public function __construct(VehicleDocumentRepository $vehicleDocumentRepo)
    {
        $this->vehicleDocumentRepository = $vehicleDocumentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleDocuments",
     *      summary="Get a listing of the VehicleDocuments.",
     *      tags={"VehicleDocument"},
     *      description="Get all VehicleDocuments",
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
     *                  @SWG\Items(ref="#/definitions/VehicleDocument")
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
        $vehicleDocuments = $this->vehicleDocumentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(VehicleDocumentResource::collection($vehicleDocuments), 'Vehicle Documents retrieved successfully');
    }

    /**
     * @param CreateVehicleDocumentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/vehicleDocuments",
     *      summary="Store a newly created VehicleDocument in storage",
     *      tags={"VehicleDocument"},
     *      description="Store VehicleDocument",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleDocument that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleDocument")
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
     *                  ref="#/definitions/VehicleDocument"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateVehicleDocumentAPIRequest $request)
    {
        $input = $request->all();

        $vehicleDocument = $this->vehicleDocumentRepository->create($input);

        return $this->sendResponse(new VehicleDocumentResource($vehicleDocument), 'Vehicle Document saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleDocuments/{id}",
     *      summary="Display the specified VehicleDocument",
     *      tags={"VehicleDocument"},
     *      description="Get VehicleDocument",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleDocument",
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
     *                  ref="#/definitions/VehicleDocument"
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
        /** @var VehicleDocument $vehicleDocument */
        $vehicleDocument = $this->vehicleDocumentRepository->find($id);

        if (empty($vehicleDocument)) {
            return $this->sendError('Vehicle Document not found');
        }

        return $this->sendResponse(new VehicleDocumentResource($vehicleDocument), 'Vehicle Document retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateVehicleDocumentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/vehicleDocuments/{id}",
     *      summary="Update the specified VehicleDocument in storage",
     *      tags={"VehicleDocument"},
     *      description="Update VehicleDocument",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleDocument",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleDocument that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleDocument")
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
     *                  ref="#/definitions/VehicleDocument"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateVehicleDocumentAPIRequest $request)
    {
        $input = $request->all();

        /** @var VehicleDocument $vehicleDocument */
        $vehicleDocument = $this->vehicleDocumentRepository->find($id);

        if (empty($vehicleDocument)) {
            return $this->sendError('Vehicle Document not found');
        }

        $vehicleDocument = $this->vehicleDocumentRepository->update($input, $id);

        return $this->sendResponse(new VehicleDocumentResource($vehicleDocument), 'VehicleDocument updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/vehicleDocuments/{id}",
     *      summary="Remove the specified VehicleDocument from storage",
     *      tags={"VehicleDocument"},
     *      description="Delete VehicleDocument",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleDocument",
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
        /** @var VehicleDocument $vehicleDocument */
        $vehicleDocument = $this->vehicleDocumentRepository->find($id);

        if (empty($vehicleDocument)) {
            return $this->sendError('Vehicle Document not found');
        }

        $vehicleDocument->delete();

        return $this->sendSuccess('Vehicle Document deleted successfully');
    }
}
