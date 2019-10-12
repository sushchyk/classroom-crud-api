<?php

namespace App\Tests\Functional;

use App\Tests\Fixture\LoadClassrooms;

class DeleteClassroomTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures([new LoadClassrooms()]);
    }

    /**
     * @test
     */
    public function itDeletesClassroom()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 1'])->getId();

        $response = $this->jsonRequest('DELETE', "/api/classrooms/$classroomId");

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEmpty($this->getClassroomRepository()->find($classroomId));
    }

    /**
     * @test
     */
    public function itReturnsErrorForDeleteWhenClassroomNotFound()
    {
        $classroomId = $this->getClassroomRepository()->findOneBy(['title' => 'Classroom 2'])->getId();

        $classroomIdForRequest = $classroomId . "2";
        $response = $this->jsonRequest('DELETE', "/api/classrooms/$classroomIdForRequest", []);

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals([
            'errors' => ["Classroom with id `$classroomIdForRequest` not found."]
        ], json_decode($response->getContent(), true));
    }
}