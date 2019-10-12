<?php

namespace App\Tests\Functional;

use App\Tests\Fixture\LoadClassrooms;

class UpdateClassroomStatusTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures([new LoadClassrooms()]);
    }
    /**
     * @test
     */
    public function itUpdatesClassroomStatus()
    {
        $requestData = [
            'isActive' => 1
        ];

        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 2'])->getId();

        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomId/status", $requestData);

        $this->assertEquals(200, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertEquals($requestData['isActive'], $responseBody['classroom']['isActive']);

        $this->assertNotEmpty($this->getClassroomRepository()->findOneBy($requestData));
    }

    /**
     * @test
     */
    public function itReturnsErrorForUpdateWhenClassroomNotFound()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1'])->getId();

        $classroomIdForRequest = $classroomId . "0";
        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomIdForRequest/status", []);

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals([
            'errors' => ["Classroom with id `$classroomIdForRequest` not found."]
        ], json_decode($response->getContent(), true));
    }

    /**
     * @test
     */
    public function itReturnsErrorForUpdateWhenClassroomDataIsInvalid()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1'])->getId();

        $requestData = [
            'isActive' => null,
        ];

        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomId/status", $requestData);

        $this->assertEquals(400, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertEquals([
            'errors' => [
                'isActive: This value should not be null.',
            ]
        ], $responseBody);
    }
}