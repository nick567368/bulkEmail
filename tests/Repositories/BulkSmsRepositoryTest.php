<?php namespace Tests\Repositories;

use App\Models\BulkSms;
use App\Repositories\BulkSmsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BulkSmsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BulkSmsRepository
     */
    protected $bulkSmsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bulkSmsRepo = \App::make(BulkSmsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->make()->toArray();

        $createdBulkSms = $this->bulkSmsRepo->create($bulkSms);

        $createdBulkSms = $createdBulkSms->toArray();
        $this->assertArrayHasKey('id', $createdBulkSms);
        $this->assertNotNull($createdBulkSms['id'], 'Created BulkSms must have id specified');
        $this->assertNotNull(BulkSms::find($createdBulkSms['id']), 'BulkSms with given id must be in DB');
        $this->assertModelData($bulkSms, $createdBulkSms);
    }

    /**
     * @test read
     */
    public function test_read_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();

        $dbBulkSms = $this->bulkSmsRepo->find($bulkSms->id);

        $dbBulkSms = $dbBulkSms->toArray();
        $this->assertModelData($bulkSms->toArray(), $dbBulkSms);
    }

    /**
     * @test update
     */
    public function test_update_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();
        $fakeBulkSms = BulkSms::factory()->make()->toArray();

        $updatedBulkSms = $this->bulkSmsRepo->update($fakeBulkSms, $bulkSms->id);

        $this->assertModelData($fakeBulkSms, $updatedBulkSms->toArray());
        $dbBulkSms = $this->bulkSmsRepo->find($bulkSms->id);
        $this->assertModelData($fakeBulkSms, $dbBulkSms->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();

        $resp = $this->bulkSmsRepo->delete($bulkSms->id);

        $this->assertTrue($resp);
        $this->assertNull(BulkSms::find($bulkSms->id), 'BulkSms should not exist in DB');
    }
}
