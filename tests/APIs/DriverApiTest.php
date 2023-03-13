<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\Driver;

class DriverApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_driver()
    {
        $driver = Driver::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/drivers', $driver
        );

        $this->assertApiResponse($driver);
    }

    /**
     * @test
     */
    public function test_read_driver()
    {
        $driver = Driver::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/drivers/'.$driver->id
        );

        $this->assertApiResponse($driver->toArray());
    }

    /**
     * @test
     */
    public function test_update_driver()
    {
        $driver = Driver::factory()->create();
        $editedDriver = Driver::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/drivers/'.$driver->id,
            $editedDriver
        );

        $this->assertApiResponse($editedDriver);
    }

    /**
     * @test
     */
    public function test_delete_driver()
    {
        $driver = Driver::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/drivers/'.$driver->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/drivers/'.$driver->id
        );

        $this->response->assertStatus(404);
    }
}
