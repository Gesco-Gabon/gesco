<?php declare(strict_types=1);

namespace Gesco\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class UserBase
{
     /**
     * @var UuidInterface|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid", unique=true)
     * @Groups({"admin:read", "operator:read"})
     */
    protected ?UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"admin:read", "admin:write", "operator:write", "operator:read"})
     * @Assert\NotBlank
     */
    protected string $firstname;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"admin:read", "admin:write", "operator:write", "operator:read"})
     * @Assert\NotBlank
     */
    protected string $lastname;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"admin:write", "admin:read", "operator:write", "operator:read"})
     * @Assert\NotBlank()
     * @Assert\Choice({"m", "f"})
     */
    protected string $sex;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"admin:read", "operator:read"})
     */
    protected \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
