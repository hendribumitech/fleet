<?php namespace Tests\Repositories;

use App\Models\Fleet\Tool;
use App\Repositories\Fleet\ToolRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ToolRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ToolRepository
     */
    protected $toolRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->toolRepo = \App::make(ToolRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tool()
    {
        $tool = Tool::factory()->make()->toArray();

        $createdTool = $this->toolRepo->create($tool);

        $createdTool = $createdTool->toArray();
        $this->assertArrayHasKey('id', $createdTool);
        $this->assertNotNull($createdTool['id'], 'Created Tool must have id specified');
        $this->assertNotNull(Tool::find($createdTool['id']), 'Tool with given id must be in DB');
        $this->assertModelData($tool, $createdTool);
    }

    /**
     * @test read
     */
    public function test_read_tool()
    {
        $tool = Tool::factory()->create();

        $dbTool = $this->toolRepo->find($tool->id);

        $dbTool = $dbTool->toArray();
        $this->assertModelData($tool->toArray(), $dbTool);
    }

    /**
     * @test update
     */
    public function test_update_tool()
    {
        $tool = Tool::factory()->create();
        $fakeTool = Tool::factory()->make()->toArray();

        $updatedTool = $this->toolRepo->update($fakeTool, $tool->id);

        $this->assertModelData($fakeTool, $updatedTool->toArray());
        $dbTool = $this->toolRepo->find($tool->id);
        $this->assertModelData($fakeTool, $dbTool->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tool()
    {
        $tool = Tool::factory()->create();

        $resp = $this->toolRepo->delete($tool->id);

        $this->assertTrue($resp);
        $this->assertNull(Tool::find($tool->id), 'Tool should not exist in DB');
    }
}
