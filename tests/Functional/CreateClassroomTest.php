<?php

namespace App\Tests;

use App\Tests\Functional\BaseTestCase;

class CreateClassroomTest extends BaseTestCase
{
    /**
     * @test
     */
    public function itCreatesClassroom()
    {
        $requestData = [
            'title' =>  'Test Title',
            'isActive' => 0
        ];

        $response = $this->jsonRequest('POST', '/api/classrooms', $requestData);

        $this->assertEquals(201, $response->getStatusCode());

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
    public function itReturnsErrorForCreateWhenClassroomDataIsEmpty()
    {
        $requestData = [
            'title' => null,
            'isActive' => null,
        ];

        $response = $this->jsonRequest('POST', '/api/classrooms', $requestData);

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