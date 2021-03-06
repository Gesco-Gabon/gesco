<?php declare(strict_types=1);

namespace Gesco\Entity;

use Ramsey\Uuid\Uuid;
use Gesco\Entity\UserBase;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Gesco\Repository\UserRepository;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORm\Entity()
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"})
 * @ApiResource(
 *      iri="http://schema.org/User",
 *      normalizationContext={"groups": {"user:read"}},
 *      denormalizationContext={"groups": {"user:write"}}
 * )
 */
class User extends UserBase implements UserInterface
{

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Assert\Email()
     */
    protected string $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @SerializedName("password")
     * @Groups({"user:write"})
     * @Assert\NotBlank
     */
    private ?string $plainPassword;

    public function __construct()
    {
        parent::__construct();

        $this->setRoles(["ROLE_USER"]);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return$this->roles;
    }

    public function setRoles(array $role): self
    {
        $role = \array_unique($role);

        if (\in_array($role[0], $this->roles, true)) {
            throw new \LogicException(sprintf("User %s have already role `%s`", $this->getUsername(), $role[0]));
        }

        $this->roles[] = $role;

        return $this;
    }

    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
