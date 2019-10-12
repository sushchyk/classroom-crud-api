<?php

namespace App\Tests\Functional;

use App\Tests\Fixture\LoadClassrooms;

class GetClassroomsListTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures([new LoadClassrooms()]);
    }

    /**
     * @test
     */
    public function itReturnsClassroomsList()
    {
        $response = $this->jsonRequest('GET', "/api/classrooms");

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertCount(2, $responseBody['classrooms']);
    }
}