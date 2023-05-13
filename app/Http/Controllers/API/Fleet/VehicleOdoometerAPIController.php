<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateVehicleOdoometerAPIRequest;
use App\Http\Requests\API\Fleet\UpdateVehicleOdoometerAPIRequest;
use App\Models\Fleet\VehicleOdoometer;
use App\Repositories\Fleet\VehicleOdoometerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\VehicleOdoometerResource;
use Response;

/**
 * Class VehicleOdoometerController
 * @package App\Http\Controllers\API\Fleet
 */

class VehicleOdoometerAPIController extends AppBaseController
{
    /** @var  VehicleOdoometerRepository */
    private $vehicleOdoometerRepository;

    public function __construct(VehicleOdoometerRepository $vehicleOdoometerRepo)
    {
        $this->vehicleOdoometerRepository = $vehicleOdoometerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleOdoometers",
     *      summary="Get a listing of the VehicleOdoometers.",
     *      tags={"VehicleOdoometer"},
     *      description="Get all VehicleOdoometers",
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
     *                  @SWG\Items(ref="#/definitions/VehicleOdoometer")
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
        $vehicleOdoometers = $this->vehicleOdoometerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(VehicleOdoometerResource::collection($vehicleOdoometers), 'Vehicle Odoometers retrieved successfully');
    }

    /**
     * @param CreateVehicleOdoometerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/vehicleOdoometers",
     *      summary="Store a newly created VehicleOdoometer in storage",
     *      tags={"VehicleOdoometer"},
     *      description="Store VehicleOdoometer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleOdoometer that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleOdoometer")
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
     *                  ref="#/definitions/VehicleOdoometer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateVehicleOdoometerAPIRequest $request)
    {
        $input = $request->all();

        $vehicleOdoometer = $this->vehicleOdoometerRepository->create($input);

        return $this->sendResponse(new VehicleOdoometerResource($vehicleOdoometer), 'Vehicle Odoometer saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleOdoometers/{id}",
     *      summary="Display the specified VehicleOdoometer",
     *      tags={"VehicleOdoometer"},
     *      description="Get VehicleOdoometer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleOdoometer",
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
     *                  ref="#/definitions/VehicleOdoometer"
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
        /** @var VehicleOdoometer $vehicleOdoometer */
        $vehicleOdoometer = $this->vehicleOdoometerRepository->find($id);

        if (empty($vehicleOdoometer)) {
            return $this->sendError('Vehicle Odoometer not found');
        }

        return $this->sendResponse(new VehicleOdoometerResource($vehicleOdoometer), 'Vehicle Odoometer retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateVehicleOdoometerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/vehicleOdoometers/{id}",
     *      summary="Update the specified VehicleOdoometer in storage",
     *      tags={"VehicleOdoometer"},
     *      description="Update VehicleOdoometer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleOdoometer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleOdoometer that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleOdoometer")
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
     *                  ref="#/definitions/VehicleOdoometer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateVehicleOdoometerAPIRequest $request)
    {
        $input = $request->all();

        /** @var VehicleOdoometer $vehicleOdoometer */
        $vehicleOdoometer = $this->vehicleOdoometerRepository->find($id);

        if (empty($vehicleOdoometer)) {
            return $this->sendError('Vehicle Odoometer not found');
        }

        $vehicleOdoometer = $this->vehicleOdoometerRepository->update($input, $id);

        return $this->sendResponse(new VehicleOdoometerResource($vehicleOdoometer), 'VehicleOdoometer updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/vehicleOdoometers/{id}",
     *      summary="Remove the specified VehicleOdoometer from storage",
     *      tags={"VehicleOdoometer"},
     *      description="Delete VehicleOdoometer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleOdoometer",
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
        /** @var VehicleOdoometer $vehicleOdoometer */
        $vehicleOdoometer = $this->vehicleOdoometerRepository->find($id);

        if (empty($vehicleOdoometer)) {
            return $this->sendError('Vehicle Odoometer not found');
        }

        $vehicleOdoometer->delete();

        return $this->sendSuccess('Vehicle Odoometer deleted successfully');
    }
}
