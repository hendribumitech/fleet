<?php namespace Tests\Repositories;

use App\Models\Fleet\ChecklistItem;
use App\Repositories\Fleet\ChecklistItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ChecklistItemRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ChecklistItemRepository
     */
    protected $checklistItemRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->checklistItemRepo = \App::make(ChecklistItemRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->make()->toArray();

        $createdChecklistItem = $this->checklistItemRepo->create($checklistItem);

        $createdChecklistItem = $createdChecklistItem->toArray();
        $this->assertArrayHasKey('id', $createdChecklistItem);
        $this->assertNotNull($createdChecklistItem['id'], 'Created ChecklistItem must have id specified');
        $this->assertNotNull(ChecklistItem::find($createdChecklistItem['id']), 'ChecklistItem with given id must be in DB');
        $this->assertModelData($checklistItem, $createdChecklistItem);
    }

    /**
     * @test read
     */
    public function test_read_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();

        $dbChecklistItem = $this->checklistItemRepo->find($checklistItem->id);

        $dbChecklistItem = $dbChecklistItem->toArray();
        $this->assertModelData($checklistItem->toArray(), $dbChecklistItem);
    }

    /**
     * @test update
     */
    public function test_update_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();
        $fakeChecklistItem = ChecklistItem::factory()->make()->toArray();

        $updatedChecklistItem = $this->checklistItemRepo->update($fakeChecklistItem, $checklistItem->id);

        $this->assertModelData($fakeChecklistItem, $updatedChecklistItem->toArray());
        $dbChecklistItem = $this->checklistItemRepo->find($checklistItem->id);
        $this->assertModelData($fakeChecklistItem, $dbChecklistItem->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();

        $resp = $this->checklistItemRepo->delete($checklistItem->id);

        $this->assertTrue($resp);
        $this->assertNull(ChecklistItem::find($checklistItem->id), 'ChecklistItem should not exist in DB');
    }
}
