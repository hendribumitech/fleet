<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\Maintenance;

class MaintenanceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_maintenance()
    {
        $maintenance = Maintenance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/maintenances', $maintenance
        );

        $this->assertApiResponse($maintenance);
    }

    /**
     * @test
     */
    public function test_read_maintenance()
    {
        $maintenance = Maintenance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/maintenances/'.$maintenance->id
        );

        $this->assertApiResponse($maintenance->toArray());
    }

    /**
     * @test
     */
    public function test_update_maintenance()
    {
        $maintenance = Maintenance::factory()->create();
        $editedMaintenance = Maintenance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/maintenances/'.$maintenance->id,
            $editedMaintenance
        );

        $this->assertApiResponse($editedMaintenance);
    }

    /**
     * @test
     */
    public function test_delete_maintenance()
    {
        $maintenance = Maintenance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/maintenances/'.$maintenance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/maintenances/'.$maintenance->id
        );

        $this->response->assertStatus(404);
    }
}
