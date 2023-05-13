<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateVehicleChecklistAPIRequest;
use App\Http\Requests\API\Fleet\UpdateVehicleChecklistAPIRequest;
use App\Models\Fleet\VehicleChecklist;
use App\Repositories\Fleet\VehicleChecklistRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\VehicleChecklistResource;
use Response;

/**
 * Class VehicleChecklistController
 * @package App\Http\Controllers\API\Fleet
 */

class VehicleChecklistAPIController extends AppBaseController
{
    /** @var  VehicleChecklistRepository */
    private $vehicleChecklistRepository;

    public function __construct(VehicleChecklistRepository $vehicleChecklistRepo)
    {
        $this->vehicleChecklistRepository = $vehicleChecklistRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleChecklists",
     *      summary="Get a listing of the VehicleChecklists.",
     *      tags={"VehicleChecklist"},
     *      description="Get all VehicleChecklists",
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
     *                  @SWG\Items(ref="#/definitions/VehicleChecklist")
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
        $vehicleChecklists = $this->vehicleChecklistRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(VehicleChecklistResource::collection($vehicleChecklists), 'Vehicle Checklists retrieved successfully');
    }

    /**
     * @param CreateVehicleChecklistAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/vehicleChecklists",
     *      summary="Store a newly created VehicleChecklist in storage",
     *      tags={"VehicleChecklist"},
     *      description="Store VehicleChecklist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleChecklist that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleChecklist")
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
     *                  ref="#/definitions/VehicleChecklist"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateVehicleChecklistAPIRequest $request)
    {
        $input = $request->all();

        $vehicleChecklist = $this->vehicleChecklistRepository->create($input);

        return $this->sendResponse(new VehicleChecklistResource($vehicleChecklist), 'Vehicle Checklist saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/vehicleChecklists/{id}",
     *      summary="Display the specified VehicleChecklist",
     *      tags={"VehicleChecklist"},
     *      description="Get VehicleChecklist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleChecklist",
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
     *                  ref="#/definitions/VehicleChecklist"
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
        /** @var VehicleChecklist $vehicleChecklist */
        $vehicleChecklist = $this->vehicleChecklistRepository->find($id);

        if (empty($vehicleChecklist)) {
            return $this->sendError('Vehicle Checklist not found');
        }

        return $this->sendResponse(new VehicleChecklistResource($vehicleChecklist), 'Vehicle Checklist retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateVehicleChecklistAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/vehicleChecklists/{id}",
     *      summary="Update the specified VehicleChecklist in storage",
     *      tags={"VehicleChecklist"},
     *      description="Update VehicleChecklist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleChecklist",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="VehicleChecklist that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/VehicleChecklist")
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
     *                  ref="#/definitions/VehicleChecklist"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateVehicleChecklistAPIRequest $request)
    {
        $input = $request->all();

        /** @var VehicleChecklist $vehicleChecklist */
        $vehicleChecklist = $this->vehicleChecklistRepository->find($id);

        if (empty($vehicleChecklist)) {
            return $this->sendError('Vehicle Checklist not found');
        }

        $vehicleChecklist = $this->vehicleChecklistRepository->update($input, $id);

        return $this->sendResponse(new VehicleChecklistResource($vehicleChecklist), 'VehicleChecklist updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/vehicleChecklists/{id}",
     *      summary="Remove the specified VehicleChecklist from storage",
     *      tags={"VehicleChecklist"},
     *      description="Delete VehicleChecklist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of VehicleChecklist",
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
        /** @var VehicleChecklist $vehicleChecklist */
        $vehicleChecklist = $this->vehicleChecklistRepository->find($id);

        if (empty($vehicleChecklist)) {
            return $this->sendError('Vehicle Checklist not found');
        }

        $vehicleChecklist->delete();

        return $this->sendSuccess('Vehicle Checklist deleted successfully');
    }
}
