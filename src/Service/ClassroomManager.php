<?php

namespace App\Service;

use App\Entity\Classroom;
use App\Exception\ClassroomNotFoundException;
use App\Exception\ValidationException;
use App\Form\ClassroomStatusType;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use App\Utils\FormErrorsFormatter;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormFactoryInterface;

class ClassroomManager
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ClassroomRepository
     */
    private $classroomRepository;

    /**
     * @var FormErrorsFormatter
     */
    private $formErrorsFormatter;

    public function __construct(
        ClassroomRepository $classroomRepository,
        FormFactoryInterface $formFactory,
        FormErrorsFormatter $formErrorsFormatter
    )  {
        $this->formFactory = $formFactory;
        $this->classroomRepository = $classroomRepository;
        $this->formErrorsFormatter = $formErrorsFormatter;
    }

    /**
     * @return Classroom[]
     */
    public function getClassroomsList(): array
    {
        return $this->classroomRepository->findAll();
    }

    /**
     * @param int $classroomId
     * @return Classroom
     *
     * @throws ClassroomNotFoundException
     */
    public function getClassroomById(int $classroomId): Classroom
    {
        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($classroomId);

        if ($classroom === null) {
            throw new ClassroomNotFoundException($classroomId);
        }

        return $classroom;
    }

    /**
     * @param array $formData
     * @return Classroom
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ValidationException
     * @throws ClassroomNotFoundException
     * @throws \Exception
     */
    public function createClassroom(array $formData): Classroom
    {
        $classroom = new Classroom();

        $form = $this->formFactory
            ->create(ClassroomType::class, $classroom)
            ->submit($formData, false);

        if (!$form->isValid()) {
            throw new ValidationException($this->formErrorsFormatter->formatFormErrors($form));
        }

        $classroom->setCreatedAt(new \DateTime());

        $this->classroomRepository->saveClassroom($classroom);

        return $classroom;
    }

    /**
     * @param int $classroomId
     * @param array $formData
     * @return Classroom
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ValidationException
     * @throws ClassroomNotFoundException
     */
    public function updateClassroom(int $classroomId, array $formData): Classroom
    {
        $classroom = $this->getClassroomById($classroomId);

        $form = $this->formFactory
            ->create(ClassroomType::class, $classroom)
            ->submit($formData);

        if (!$form->isValid()) {
            throw new ValidationException($this->formErrorsFormatter->formatFormErrors($form));
        }

        $this->classroomRepository->saveClassroom($classroom);

        return $classroom;
    }

    /**
     * @param int $classroomId
     * @param array $formData
     * @return Classroom
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateClassroomStatus(int $classroomId, array $formData): Classroom
    {
        $classroom = $this->getClassroomById($classroomId);

        $form = $this->formFactory
            ->create(ClassroomStatusType::class, $classroom)
            ->submit($formData);

        if (!$form->isValid()) {
            throw new ValidationException($this->formErrorsFormatter->formatFormErrors($form));
        }

        $this->classroomRepository->saveClassroom($classroom);

        return $classroom;
    }

    /**
     * @param int $classroomId
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteClassroom(int $classroomId): void
    {
        $classroom = $this->getClassroomById($classroomId);

        $this->classroomRepository->deleteClassroom($classroom);
    }
}