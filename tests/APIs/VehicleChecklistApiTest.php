<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\VehicleChecklist;

class VehicleChecklistApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/vehicle_checklists', $vehicleChecklist
        );

        $this->assertApiResponse($vehicleChecklist);
    }

    /**
     * @test
     */
    public function test_read_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_checklists/'.$vehicleChecklist->id
        );

        $this->assertApiResponse($vehicleChecklist->toArray());
    }

    /**
     * @test
     */
    public function test_update_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();
        $editedVehicleChecklist = VehicleChecklist::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/vehicle_checklists/'.$vehicleChecklist->id,
            $editedVehicleChecklist
        );

        $this->assertApiResponse($editedVehicleChecklist);
    }

    /**
     * @test
     */
    public function test_delete_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/vehicle_checklists/'.$vehicleChecklist->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_checklists/'.$vehicleChecklist->id
        );

        $this->response->assertStatus(404);
    }
}
