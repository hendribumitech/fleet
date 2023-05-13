<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\ChecklistItem;

class ChecklistItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/checklist_items', $checklistItem
        );

        $this->assertApiResponse($checklistItem);
    }

    /**
     * @test
     */
    public function test_read_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/checklist_items/'.$checklistItem->id
        );

        $this->assertApiResponse($checklistItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();
        $editedChecklistItem = ChecklistItem::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/checklist_items/'.$checklistItem->id,
            $editedChecklistItem
        );

        $this->assertApiResponse($editedChecklistItem);
    }

    /**
     * @test
     */
    public function test_delete_checklist_item()
    {
        $checklistItem = ChecklistItem::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/checklist_items/'.$checklistItem->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/checklist_items/'.$checklistItem->id
        );

        $this->response->assertStatus(404);
    }
}
