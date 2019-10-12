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
        $requestData = [
            'title' =>  'New Title',
            'isActive' => 0
        ];

        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1'])->getId();

        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomId", $requestData);

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseBody['classroom']['id']);
        $this->assertNotEmpty($responseBody['classroom']['createdAt']);
        $this->assertEquals($requestData['title'], $responseBody['classroom']['title']);
        $this->assertEquals($requestData['isActive'], $responseBody['classroom']['isActive']);

        $this->assertNotEmpty($this->getClassroomRepository()->findOneBy($requestData));
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