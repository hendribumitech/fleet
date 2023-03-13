<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\VehicleDocument;

class VehicleDocumentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/vehicle_documents', $vehicleDocument
        );

        $this->assertApiResponse($vehicleDocument);
    }

    /**
     * @test
     */
    public function test_read_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_documents/'.$vehicleDocument->id
        );

        $this->assertApiResponse($vehicleDocument->toArray());
    }

    /**
     * @test
     */
    public function test_update_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();
        $editedVehicleDocument = VehicleDocument::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/vehicle_documents/'.$vehicleDocument->id,
            $editedVehicleDocument
        );

        $this->assertApiResponse($editedVehicleDocument);
    }

    /**
     * @test
     */
    public function test_delete_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/vehicle_documents/'.$vehicleDocument->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/vehicle_documents/'.$vehicleDocument->id
        );

        $this->response->assertStatus(404);
    }
}
