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

class ClassroomStatusController
{
    /**
     * @var ClassroomManager
     */
    private $classroomManager;

    public function __construct(ClassroomManager $classroomManager)
    {
        $this->classroomManager = $classroomManager;
    }

    /**
     * @Route("/api/classrooms/{classroomId}/status", methods={"PUT"})
     *
     * @param Request $request
     * @param int $classroomId
     *
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, int $classroomId)
    {
        $requestData = json_decode($request->getContent(), true);

        try {
            $classroom = $this->classroomManager->updateClassroomStatus($classroomId, $requestData);
        } catch (ValidationException $e) {
            return new JsonResponse(['errors' => $e->getValidationErrors()], 400);
        } catch (ClassroomNotFoundException $e) {
            return new JsonResponse(['errors' => [$e->getMessage()]], 404);
        }

        return new JsonResponse(['classroom' => $classroom]);
    }
}