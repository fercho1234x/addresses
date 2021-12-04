<?php

namespace Tests\Feature;

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StatesTest extends TestCase
{
    use RefreshDatabase;

    public function testAListOfRecordsCanBeObtained()
    {
        State::factory()->count(2)->create();
        $response = $this->getJson('/api/states');

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals(count($response['payload']), 2);
    }

    public function testTheFormatOfTheResponseIsCorrect()
    {
        $state = State::factory()->create();

        $response = $this->getJson('/api/states');

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals($response['payload'], [[
            'id' => $state->id,
            'name' => $state->name
        ]]);
    }

    public function testCanLimitTheNumberOfRecordsToBeRetrieved()
    {
        State::factory()->count(4)->create();

        $response = $this->getJson('/api/states?limit=3');
        $this->assertEquals($response->getStatusCode(), '200');
        $this->assertEquals(count($response['payload']), 3);
    }

    public function testByDefaultTheMinimumNumberOfRecordsToReturnIs30()
    {
        State::factory()->count(40)->create();
        $response = $this->getJson('/api/states');
        $this->assertEquals(count($response['payload']), 30);
    }

    public function providerInvalidLimits()
    {
        return [
            'Invalid argument' => [4, 'string'],
            'No more than 50 records can be obtained' => [51, '51'],
            'The minimum value is 1' => [2, '-1']
        ];
    }

    /**
     * @dataProvider providerInvalidLimits
    */
    public function testReturnUnprocessableIfTheLimitIsWrong(int $numberOfRecordsToBeCreated, string $limit)
    {
        State::factory()->count($numberOfRecordsToBeCreated)->create();
        $response = $this->getJson(sprintf('/api/states?limit=%s',$limit));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRecordsCanBePaginated()
    {
        State::factory()->count(9)->create();
        $response = $this->getJson('/api/states?limit=5&page=2');
        $this->assertEquals(count($response['payload']), 4);
    }

    public function testTheDefaultPageIsTheFirstPage()
    {
        State::factory()->count(9)->create();
        $response = $this->getJson('/api/states?limit=5');
        $this->assertEquals(count($response['payload']), 5);
    }

    public function testReturnsZeroRecordsWhenThePageDoesNotExist()
    {
        State::factory()->count(9)->create();
        $response = $this->getJson('/api/states?limit=5&page=20');
        $this->assertEquals(count($response['payload']), 0);
    }

    public function providerInvalidPages()
    {
        return[
            'Invalid argument' => ['string'],
            'The minimum value is 1' => [-1]
        ];
    }

    /**
     * @dataProvider providerInvalidPages
     */
    public function testReturnUnprocessableIfThePageIsWrong($invalidPage)
    {
        $response = $this->getJson(sprintf('/api/states?page=%s', $invalidPage));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
