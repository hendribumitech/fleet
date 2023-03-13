<?php

namespace App\Http\Controllers\API\Fleet;

use App\Http\Requests\API\Fleet\CreateMaintenanceAPIRequest;
use App\Http\Requests\API\Fleet\UpdateMaintenanceAPIRequest;
use App\Models\Fleet\Maintenance;
use App\Repositories\Fleet\MaintenanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Fleet\MaintenanceResource;
use Response;

/**
 * Class MaintenanceController
 * @package App\Http\Controllers\API\Fleet
 */

class MaintenanceAPIController extends AppBaseController
{
    /** @var  MaintenanceRepository */
    private $maintenanceRepository;

    public function __construct(MaintenanceRepository $maintenanceRepo)
    {
        $this->maintenanceRepository = $maintenanceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/maintenances",
     *      summary="Get a listing of the Maintenances.",
     *      tags={"Maintenance"},
     *      description="Get all Maintenances",
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
     *                  @SWG\Items(ref="#/definitions/Maintenance")
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
        $maintenances = $this->maintenanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(MaintenanceResource::collection($maintenances), 'Maintenances retrieved successfully');
    }

    /**
     * @param CreateMaintenanceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/maintenances",
     *      summary="Store a newly created Maintenance in storage",
     *      tags={"Maintenance"},
     *      description="Store Maintenance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Maintenance that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Maintenance")
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
     *                  ref="#/definitions/Maintenance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMaintenanceAPIRequest $request)
    {
        $input = $request->all();

        $maintenance = $this->maintenanceRepository->create($input);

        return $this->sendResponse(new MaintenanceResource($maintenance), 'Maintenance saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/maintenances/{id}",
     *      summary="Display the specified Maintenance",
     *      tags={"Maintenance"},
     *      description="Get Maintenance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Maintenance",
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
     *                  ref="#/definitions/Maintenance"
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
        /** @var Maintenance $maintenance */
        $maintenance = $this->maintenanceRepository->find($id);

        if (empty($maintenance)) {
            return $this->sendError('Maintenance not found');
        }

        return $this->sendResponse(new MaintenanceResource($maintenance), 'Maintenance retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMaintenanceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/maintenances/{id}",
     *      summary="Update the specified Maintenance in storage",
     *      tags={"Maintenance"},
     *      description="Update Maintenance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Maintenance",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Maintenance that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Maintenance")
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
     *                  ref="#/definitions/Maintenance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMaintenanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Maintenance $maintenance */
        $maintenance = $this->maintenanceRepository->find($id);

        if (empty($maintenance)) {
            return $this->sendError('Maintenance not found');
        }

        $maintenance = $this->maintenanceRepository->update($input, $id);

        return $this->sendResponse(new MaintenanceResource($maintenance), 'Maintenance updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/maintenances/{id}",
     *      summary="Remove the specified Maintenance from storage",
     *      tags={"Maintenance"},
     *      description="Delete Maintenance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Maintenance",
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
        /** @var Maintenance $maintenance */
        $maintenance = $this->maintenanceRepository->find($id);

        if (empty($maintenance)) {
            return $this->sendError('Maintenance not found');
        }

        $maintenance->delete();

        return $this->sendSuccess('Maintenance deleted successfully');
    }
}
