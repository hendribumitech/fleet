<?php namespace Tests\Repositories;

use App\Models\Fleet\VehicleOdoometer;
use App\Repositories\Fleet\VehicleOdoometerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VehicleOdoometerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VehicleOdoometerRepository
     */
    protected $vehicleOdoometerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->vehicleOdoometerRepo = \App::make(VehicleOdoometerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->make()->toArray();

        $createdVehicleOdoometer = $this->vehicleOdoometerRepo->create($vehicleOdoometer);

        $createdVehicleOdoometer = $createdVehicleOdoometer->toArray();
        $this->assertArrayHasKey('id', $createdVehicleOdoometer);
        $this->assertNotNull($createdVehicleOdoometer['id'], 'Created VehicleOdoometer must have id specified');
        $this->assertNotNull(VehicleOdoometer::find($createdVehicleOdoometer['id']), 'VehicleOdoometer with given id must be in DB');
        $this->assertModelData($vehicleOdoometer, $createdVehicleOdoometer);
    }

    /**
     * @test read
     */
    public function test_read_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();

        $dbVehicleOdoometer = $this->vehicleOdoometerRepo->find($vehicleOdoometer->id);

        $dbVehicleOdoometer = $dbVehicleOdoometer->toArray();
        $this->assertModelData($vehicleOdoometer->toArray(), $dbVehicleOdoometer);
    }

    /**
     * @test update
     */
    public function test_update_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();
        $fakeVehicleOdoometer = VehicleOdoometer::factory()->make()->toArray();

        $updatedVehicleOdoometer = $this->vehicleOdoometerRepo->update($fakeVehicleOdoometer, $vehicleOdoometer->id);

        $this->assertModelData($fakeVehicleOdoometer, $updatedVehicleOdoometer->toArray());
        $dbVehicleOdoometer = $this->vehicleOdoometerRepo->find($vehicleOdoometer->id);
        $this->assertModelData($fakeVehicleOdoometer, $dbVehicleOdoometer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_vehicle_odoometer()
    {
        $vehicleOdoometer = VehicleOdoometer::factory()->create();

        $resp = $this->vehicleOdoometerRepo->delete($vehicleOdoometer->id);

        $this->assertTrue($resp);
        $this->assertNull(VehicleOdoometer::find($vehicleOdoometer->id), 'VehicleOdoometer should not exist in DB');
    }
}
