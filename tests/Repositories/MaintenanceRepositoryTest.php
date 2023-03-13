<?php namespace Tests\Repositories;

use App\Models\Fleet\Maintenance;
use App\Repositories\Fleet\MaintenanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MaintenanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MaintenanceRepository
     */
    protected $maintenanceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->maintenanceRepo = \App::make(MaintenanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_maintenance()
    {
        $maintenance = Maintenance::factory()->make()->toArray();

        $createdMaintenance = $this->maintenanceRepo->create($maintenance);

        $createdMaintenance = $createdMaintenance->toArray();
        $this->assertArrayHasKey('id', $createdMaintenance);
        $this->assertNotNull($createdMaintenance['id'], 'Created Maintenance must have id specified');
        $this->assertNotNull(Maintenance::find($createdMaintenance['id']), 'Maintenance with given id must be in DB');
        $this->assertModelData($maintenance, $createdMaintenance);
    }

    /**
     * @test read
     */
    public function test_read_maintenance()
    {
        $maintenance = Maintenance::factory()->create();

        $dbMaintenance = $this->maintenanceRepo->find($maintenance->id);

        $dbMaintenance = $dbMaintenance->toArray();
        $this->assertModelData($maintenance->toArray(), $dbMaintenance);
    }

    /**
     * @test update
     */
    public function test_update_maintenance()
    {
        $maintenance = Maintenance::factory()->create();
        $fakeMaintenance = Maintenance::factory()->make()->toArray();

        $updatedMaintenance = $this->maintenanceRepo->update($fakeMaintenance, $maintenance->id);

        $this->assertModelData($fakeMaintenance, $updatedMaintenance->toArray());
        $dbMaintenance = $this->maintenanceRepo->find($maintenance->id);
        $this->assertModelData($fakeMaintenance, $dbMaintenance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_maintenance()
    {
        $maintenance = Maintenance::factory()->create();

        $resp = $this->maintenanceRepo->delete($maintenance->id);

        $this->assertTrue($resp);
        $this->assertNull(Maintenance::find($maintenance->id), 'Maintenance should not exist in DB');
    }
}
