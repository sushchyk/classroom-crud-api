<?php

namespace App\Tests;

use App\Entity\Classroom;
use App\Tests\Fixture\LoadClassrooms;
use App\Tests\Functional\BaseTestCase;

class UpdateClassroomTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures([new LoadClassrooms()]);
    }

    /**
     * @test
     */
    public function itUpdatesClassroom()
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
    public function itReturnsErrorForUpdateWhenClassroomNotFound()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1'])->getId();

        $classroomIdForRequest = $classroomId . "0";
        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomIdForRequest", []);

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
            'title' => null,
            'isActive' => null,
        ];

        $response = $this->jsonRequest('PUT', "/api/classrooms/$classroomId", $requestData);

        $this->assertEquals(400, $response->getStatusCode());

        $responseBody = json_decode($response->getContent(), true);
        $this->assertEquals([
            'errors' => [
                'title: This value should not be blank.',
                'title: This value should not be null.',
                'isActive: This value should not be null.',
            ]
        ], $responseBody);
    }
}