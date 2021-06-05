<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BulkSms;

class BulkSmsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/bulk_sms', $bulkSms
        );

        $this->assertApiResponse($bulkSms);
    }

    /**
     * @test
     */
    public function test_read_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/bulk_sms/'.$bulkSms->id
        );

        $this->assertApiResponse($bulkSms->toArray());
    }

    /**
     * @test
     */
    public function test_update_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();
        $editedBulkSms = BulkSms::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/bulk_sms/'.$bulkSms->id,
            $editedBulkSms
        );

        $this->assertApiResponse($editedBulkSms);
    }

    /**
     * @test
     */
    public function test_delete_bulk_sms()
    {
        $bulkSms = BulkSms::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/bulk_sms/'.$bulkSms->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/bulk_sms/'.$bulkSms->id
        );

        $this->response->assertStatus(404);
    }
}
