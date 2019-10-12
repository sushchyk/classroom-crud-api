<?php

namespace App\Controller\Api;

use App\Exception\ClassroomNotFoundException;
use App\Exception\ValidationException;
use App\Service\ClassroomManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController
{
    /**
     * @var ClassroomManager
     */
    private $classroomManager;

    /**
     * ClassroomController constructor.
     *
     * @param ClassroomManager $classroomManager
     */
    public function __construct(ClassroomManager $classroomManager)
    {
        $this->classroomManager = $classroomManager;
    }

    /**
     * @Route("/api/classrooms", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function getCollection(): JsonResponse
    {
        $classrooms = $this->classroomManager->getClassroomsList();

        return new JsonResponse(['classrooms' => $classrooms]);
    }

    /**
     * @Route("/api/classrooms/{classroomId}", methods={"GET"})
     *
     * @param int $classroomId
     * @return JsonResponse
     */
    public function getItem(int $classroomId)
    {
        try {
            $classroom = $this-$this->classroomManager->getClassroomById($classroomId);
        }  catch (ClassroomNotFoundException $e) {
            return new JsonResponse(['errors' => [$e->getMessage()]], 404);
        }

        return new JsonResponse(['classroom' => $classroom]);
    }

    /**
     * @Route("/api/classrooms", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function new(Request $request): JsonResponse
    {
        $requestBody = json_decode($request->getContent(), true);

        try {
            $classroom = $this->classroomManager->createClassroom($requestBody);
        }   catch (ValidationException $e) {
            return new JsonResponse(['errors' => $e->getValidationErrors()], 400);
        }

        return new JsonResponse(['classroom' => $classroom], 201);
    }

    /**
     * @Route("/api/classrooms/{classroomId}", methods={"PUT"})
     *
     * @param Request $request
     * @param int $classroomId
     * @return JsonResponse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, int $classroomId)
    {
        $requestBody = json_decode($request->getContent(), true);

        try {
            $classroom = $this->classroomManager->updateClassroom($classroomId, $requestBody);
        }   catch (ValidationException $e) {
            return new JsonResponse(['errors' => $e->getValidationErrors()], 400);
        }   catch (ClassroomNotFoundException $e) {
            return new JsonResponse(['errors' => [$e->getMessage()]], 404);
        }

        return new JsonResponse(['classroom' => $classroom]);
    }

    /**
     * @Route("/api/classrooms/{classroomId}", methods={"DELETE"})
     *
     * @param int $classroomId
     * @return JsonResponse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(int $classroomId)
    {
        try {
            $this->classroomManager->deleteClassroom($classroomId);
        }  catch (ClassroomNotFoundException $e) {
            return new JsonResponse(['errors' => [$e->getMessage()]], 404);
        }

        return new JsonResponse('', 204);
    }
}