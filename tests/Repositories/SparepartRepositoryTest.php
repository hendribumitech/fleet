<?php namespace Tests\Repositories;

use App\Models\Fleet\Sparepart;
use App\Repositories\Fleet\SparepartRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SparepartRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SparepartRepository
     */
    protected $sparepartRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sparepartRepo = \App::make(SparepartRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sparepart()
    {
        $sparepart = Sparepart::factory()->make()->toArray();

        $createdSparepart = $this->sparepartRepo->create($sparepart);

        $createdSparepart = $createdSparepart->toArray();
        $this->assertArrayHasKey('id', $createdSparepart);
        $this->assertNotNull($createdSparepart['id'], 'Created Sparepart must have id specified');
        $this->assertNotNull(Sparepart::find($createdSparepart['id']), 'Sparepart with given id must be in DB');
        $this->assertModelData($sparepart, $createdSparepart);
    }

    /**
     * @test read
     */
    public function test_read_sparepart()
    {
        $sparepart = Sparepart::factory()->create();

        $dbSparepart = $this->sparepartRepo->find($sparepart->id);

        $dbSparepart = $dbSparepart->toArray();
        $this->assertModelData($sparepart->toArray(), $dbSparepart);
    }

    /**
     * @test update
     */
    public function test_update_sparepart()
    {
        $sparepart = Sparepart::factory()->create();
        $fakeSparepart = Sparepart::factory()->make()->toArray();

        $updatedSparepart = $this->sparepartRepo->update($fakeSparepart, $sparepart->id);

        $this->assertModelData($fakeSparepart, $updatedSparepart->toArray());
        $dbSparepart = $this->sparepartRepo->find($sparepart->id);
        $this->assertModelData($fakeSparepart, $dbSparepart->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sparepart()
    {
        $sparepart = Sparepart::factory()->create();

        $resp = $this->sparepartRepo->delete($sparepart->id);

        $this->assertTrue($resp);
        $this->assertNull(Sparepart::find($sparepart->id), 'Sparepart should not exist in DB');
    }
}
