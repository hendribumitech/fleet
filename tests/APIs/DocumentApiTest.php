<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Fleet\Document;

class DocumentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_document()
    {
        $document = Document::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/fleet/documents', $document
        );

        $this->assertApiResponse($document);
    }

    /**
     * @test
     */
    public function test_read_document()
    {
        $document = Document::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/fleet/documents/'.$document->id
        );

        $this->assertApiResponse($document->toArray());
    }

    /**
     * @test
     */
    public function test_update_document()
    {
        $document = Document::factory()->create();
        $editedDocument = Document::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/fleet/documents/'.$document->id,
            $editedDocument
        );

        $this->assertApiResponse($editedDocument);
    }

    /**
     * @test
     */
    public function test_delete_document()
    {
        $document = Document::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/fleet/documents/'.$document->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/fleet/documents/'.$document->id
        );

        $this->response->assertStatus(404);
    }
}
