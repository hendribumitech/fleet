<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\Sparepart;

class SparepartApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sparepart()
    {
        $sparepart = Sparepart::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/spareparts', $sparepart
        );

        $this->assertApiResponse($sparepart);
    }

    /**
     * @test
     */
    public function test_read_sparepart()
    {
        $sparepart = Sparepart::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/spareparts/'.$sparepart->id
        );

        $this->assertApiResponse($sparepart->toArray());
    }

    /**
     * @test
     */
    public function test_update_sparepart()
    {
        $sparepart = Sparepart::factory()->create();
        $editedSparepart = Sparepart::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/spareparts/'.$sparepart->id,
            $editedSparepart
        );

        $this->assertApiResponse($editedSparepart);
    }

    /**
     * @test
     */
    public function test_delete_sparepart()
    {
        $sparepart = Sparepart::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/spareparts/'.$sparepart->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/spareparts/'.$sparepart->id
        );

        $this->response->assertStatus(404);
    }
}
