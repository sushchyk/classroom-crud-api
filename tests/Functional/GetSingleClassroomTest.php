<?php

namespace App\Tests\Functional;

use App\Tests\Fixture\LoadClassrooms;

class GetSingleClassroomTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures([new LoadClassrooms()]);
    }

    /**
     * @test
     */
    public function itReturnsSingleClassroom()
    {
        $classroom = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1']);

        $response = $this->jsonRequest('GET', "/api/classrooms/" . $classroom->getId());

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseBody['classroom']['id']);
        $this->assertNotEmpty($responseBody['classroom']['createdAt']);
        $this->assertEquals($classroom->getTitle(), $responseBody['classroom']['title']);
        $this->assertEquals($classroom->isActive(), $responseBody['classroom']['isActive']);
    }

    /**
     * @test
     */
    public function itReturnsErrorForGetItemWhenClassroomNotFound()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 2'])->getId();

        $classroomIdForRequest = $classroomId . "4";
        $response = $this->jsonRequest('GET', "/api/classrooms/$classroomIdForRequest", []);

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals([
            'errors' => ["Classroom with id `$classroomIdForRequest` not found."]
        ], json_decode($response->getContent(), true));
    }
}