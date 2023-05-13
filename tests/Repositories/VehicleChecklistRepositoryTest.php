<?php namespace Tests\Repositories;

use App\Models\Fleet\VehicleChecklist;
use App\Repositories\Fleet\VehicleChecklistRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VehicleChecklistRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VehicleChecklistRepository
     */
    protected $vehicleChecklistRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->vehicleChecklistRepo = \App::make(VehicleChecklistRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->make()->toArray();

        $createdVehicleChecklist = $this->vehicleChecklistRepo->create($vehicleChecklist);

        $createdVehicleChecklist = $createdVehicleChecklist->toArray();
        $this->assertArrayHasKey('id', $createdVehicleChecklist);
        $this->assertNotNull($createdVehicleChecklist['id'], 'Created VehicleChecklist must have id specified');
        $this->assertNotNull(VehicleChecklist::find($createdVehicleChecklist['id']), 'VehicleChecklist with given id must be in DB');
        $this->assertModelData($vehicleChecklist, $createdVehicleChecklist);
    }

    /**
     * @test read
     */
    public function test_read_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();

        $dbVehicleChecklist = $this->vehicleChecklistRepo->find($vehicleChecklist->id);

        $dbVehicleChecklist = $dbVehicleChecklist->toArray();
        $this->assertModelData($vehicleChecklist->toArray(), $dbVehicleChecklist);
    }

    /**
     * @test update
     */
    public function test_update_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();
        $fakeVehicleChecklist = VehicleChecklist::factory()->make()->toArray();

        $updatedVehicleChecklist = $this->vehicleChecklistRepo->update($fakeVehicleChecklist, $vehicleChecklist->id);

        $this->assertModelData($fakeVehicleChecklist, $updatedVehicleChecklist->toArray());
        $dbVehicleChecklist = $this->vehicleChecklistRepo->find($vehicleChecklist->id);
        $this->assertModelData($fakeVehicleChecklist, $dbVehicleChecklist->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_vehicle_checklist()
    {
        $vehicleChecklist = VehicleChecklist::factory()->create();

        $resp = $this->vehicleChecklistRepo->delete($vehicleChecklist->id);

        $this->assertTrue($resp);
        $this->assertNull(VehicleChecklist::find($vehicleChecklist->id), 'VehicleChecklist should not exist in DB');
    }
}
