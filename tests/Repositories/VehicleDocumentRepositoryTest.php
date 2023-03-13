<?php namespace Tests\Repositories;

use App\Models\Fleet\VehicleDocument;
use App\Repositories\Fleet\VehicleDocumentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VehicleDocumentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VehicleDocumentRepository
     */
    protected $vehicleDocumentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->vehicleDocumentRepo = \App::make(VehicleDocumentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->make()->toArray();

        $createdVehicleDocument = $this->vehicleDocumentRepo->create($vehicleDocument);

        $createdVehicleDocument = $createdVehicleDocument->toArray();
        $this->assertArrayHasKey('id', $createdVehicleDocument);
        $this->assertNotNull($createdVehicleDocument['id'], 'Created VehicleDocument must have id specified');
        $this->assertNotNull(VehicleDocument::find($createdVehicleDocument['id']), 'VehicleDocument with given id must be in DB');
        $this->assertModelData($vehicleDocument, $createdVehicleDocument);
    }

    /**
     * @test read
     */
    public function test_read_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();

        $dbVehicleDocument = $this->vehicleDocumentRepo->find($vehicleDocument->id);

        $dbVehicleDocument = $dbVehicleDocument->toArray();
        $this->assertModelData($vehicleDocument->toArray(), $dbVehicleDocument);
    }

    /**
     * @test update
     */
    public function test_update_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();
        $fakeVehicleDocument = VehicleDocument::factory()->make()->toArray();

        $updatedVehicleDocument = $this->vehicleDocumentRepo->update($fakeVehicleDocument, $vehicleDocument->id);

        $this->assertModelData($fakeVehicleDocument, $updatedVehicleDocument->toArray());
        $dbVehicleDocument = $this->vehicleDocumentRepo->find($vehicleDocument->id);
        $this->assertModelData($fakeVehicleDocument, $dbVehicleDocument->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_vehicle_document()
    {
        $vehicleDocument = VehicleDocument::factory()->create();

        $resp = $this->vehicleDocumentRepo->delete($vehicleDocument->id);

        $this->assertTrue($resp);
        $this->assertNull(VehicleDocument::find($vehicleDocument->id), 'VehicleDocument should not exist in DB');
    }
}
