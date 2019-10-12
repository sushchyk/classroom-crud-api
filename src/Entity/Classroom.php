<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassroomRepository")
 * @ORM\Table(name="classrooms")
 */
class Classroom implements \JsonSerializable
{
    /**
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Length(max="31")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     *
     * @ORM\Column(type="string", length=31)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @Assert\Type("boolean")
     * @Assert\NotNull()
     *
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     */
    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'isActive' => (bool) $this->isActive
        ];
    }
}