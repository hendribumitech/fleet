<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\VehicleOdoometer;

class VehicleOdoometerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/vehicle_odoometers', $vehicleOdoometer
        );

        $this->assertApiResponse($vehicleOdoometer);
    }

    /**
     * @test
     */
    public function test_read_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_odoometers/'.$vehicleOdoometer->id
        );

        $this->assertApiResponse($vehicleOdoometer->toArray());
    }

    /**
     * @test
     */
    public function test_update_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();
        $editedVehicleOdoometer = VehicleOdoometer::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/vehicle_odoometers/'.$vehicleOdoometer->id,
            $editedVehicleOdoometer
        );

        $this->assertApiResponse($editedVehicleOdoometer);
    }

    /**
     * @test
     */
    public function test_delete_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/vehicle_odoometers/'.$vehicleOdoometer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_odoometers/'.$vehicleOdoometer->id
        );

        $this->response->assertStatus(404);
    }
}
