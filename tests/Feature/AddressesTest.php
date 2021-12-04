<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AddressesTest extends TestCase
{
    use RefreshDatabase;

    public function testAListOfRecordsCanBeObtained()
    {
        Address::factory()->count(2)->create();

        $response = $this->getJson('/api/addresses');

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals(count($response['payload']), 2);
    }

    public function testTheFormatOfTheResponseIsCorrect()
    {
        $address = Address::factory()->create();

        $response = $this->getJson('/api/addresses');

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals($response['payload'], [[
            'id' => $address->id,
            'code' => $address->code,
            'settlement' => $address->settlement,
            'settlement_type' => $address->settlement_type,
            'municipality' => $address->municipality,
            'city' => $address->city,
            'zone' => $address->zone,
            'state' => [
                'id' => $address->state->id,
                'name' => $address->state->name
            ]
        ]]);
    }

    public function testCanLimitTheNumberOfRecordsToBeRetrieved()
    {
        Address::factory()->count(4)->create();

        $response = $this->getJson('/api/addresses?limit=3');
        $this->assertEquals($response->getStatusCode(), '200');
        $this->assertEquals(count($response['payload']), 3);
    }

    public function testByDefaultTheMinimumNumberOfRecordsToReturnIs30()
    {
        Address::factory()->count(40)->create();
        $response = $this->getJson('/api/addresses');
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
        Address::factory()->count($numberOfRecordsToBeCreated)->create();
        $response = $this->getJson(sprintf('/api/addresses?limit=%s',$limit));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRecordsCanBePaginated()
    {
        Address::factory()->count(9)->create();
        $response = $this->getJson('/api/addresses?limit=5&page=2');
        $this->assertEquals(count($response['payload']), 4);
    }

    public function testTheDefaultPageIsTheFirstPage()
    {
        Address::factory()->count(9)->create();
        $response = $this->getJson('/api/addresses?limit=5');
        $this->assertEquals(count($response['payload']), 5);
    }

    public function testReturnsZeroRecordsWhenThePageDoesNotExist()
    {
        Address::factory()->count(9)->create();
        $response = $this->getJson('/api/addresses?limit=5&page=20');
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
        $response = $this->getJson(sprintf('/api/addresses?page=%s', $invalidPage));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testGetRecordsByZipCode()
    {
        $state = State::factory()->create();

        $address = Address::factory()->create([
            'code' => '101',
            'settlement' => 'test',
            'settlement_type' => 'test',
            'municipality' => 'test',
            'city' => 'test',
            'zone' => 'test',
            'state_id' => $state->id
        ]);

        Address::factory()->create([
            'code' => '102',
            'settlement' => 'test2',
            'settlement_type' => 'test2',
            'municipality' => 'test2',
            'city' => 'test2',
            'zone' => 'test2',
            'state_id' => $state->id
        ]);

        $response = $this->getJson(sprintf('/api/addresses?code=%s', $address->code));

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals($response['payload'], [[
            'id' => $address->id,
            'code' => $address->code,
            'settlement' => $address->settlement,
            'settlement_type' => $address->settlement_type,
            'municipality' => $address->municipality,
            'city' => $address->city,
            'zone' => $address->zone,
            'state' => [
                'id' => $address->state->id,
                'name' => $address->state->name
            ]
        ]]);
    }

    public function testGetRecordsByMunicipality()
    {
        $state = State::factory()->create();

        $address = Address::factory()->create([
            'code' => '101',
            'settlement' => 'test',
            'settlement_type' => 'test',
            'municipality' => 'test',
            'city' => 'test',
            'zone' => 'test',
            'state_id' => $state->id
        ]);

        Address::factory()->create([
            'code' => '102',
            'settlement' => 'test2',
            'settlement_type' => 'test2',
            'municipality' => 'test2',
            'city' => 'test2',
            'zone' => 'test2',
            'state_id' => $state->id
        ]);

        $response = $this->getJson(sprintf('/api/addresses?municipality=%s', $address->municipality));

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals($response['payload'], [[
            'id' => $address->id,
            'code' => $address->code,
            'settlement' => $address->settlement,
            'settlement_type' => $address->settlement_type,
            'municipality' => $address->municipality,
            'city' => $address->city,
            'zone' => $address->zone,
            'state' => [
                'id' => $address->state->id,
                'name' => $address->state->name
            ]
        ]]);
    }

    public function testGetRecordsByCity()
    {
        $state = State::factory()->create();

        $address = Address::factory()->create([
            'code' => '101',
            'settlement' => 'test',
            'settlement_type' => 'test',
            'municipality' => 'test',
            'city' => 'test',
            'zone' => 'test',
            'state_id' => $state->id
        ]);

        Address::factory()->create([
            'code' => '102',
            'settlement' => 'test2',
            'settlement_type' => 'test2',
            'municipality' => 'test2',
            'city' => 'test2',
            'zone' => 'test2',
            'state_id' => $state->id
        ]);

        $response = $this->getJson(sprintf('/api/addresses?city=%s', $address->city));

        $this->assertEquals($response->getStatusCode(), '200');

        $this->assertEquals($response['payload'], [[
            'id' => $address->id,
            'code' => $address->code,
            'settlement' => $address->settlement,
            'settlement_type' => $address->settlement_type,
            'municipality' => $address->municipality,
            'city' => $address->city,
            'zone' => $address->zone,
            'state' => [
                'id' => $address->state->id,
                'name' => $address->state->name
            ]
        ]]);
    }
}
