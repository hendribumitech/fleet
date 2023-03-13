<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\Tool;

class ToolApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tool()
    {
        $tool = Tool::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/tools', $tool
        );

        $this->assertApiResponse($tool);
    }

    /**
     * @test
     */
    public function test_read_tool()
    {
        $tool = Tool::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/tools/'.$tool->id
        );

        $this->assertApiResponse($tool->toArray());
    }

    /**
     * @test
     */
    public function test_update_tool()
    {
        $tool = Tool::factory()->create();
        $editedTool = Tool::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/tools/'.$tool->id,
            $editedTool
        );

        $this->assertApiResponse($editedTool);
    }

    /**
     * @test
     */
    public function test_delete_tool()
    {
        $tool = Tool::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/tools/'.$tool->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/tools/'.$tool->id
        );

        $this->response->assertStatus(404);
    }
}
