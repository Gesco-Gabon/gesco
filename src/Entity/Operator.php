<?php

namespace Gesco\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gesco\Entity\UserBase;
use Gesco\Repository\OperatorRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=OperatorRepository::class)
 * @ORM\Table(name="operator")
 * @UniqueEntity(fields={"identityNumber"})
 * @ApiResource(
 *      iri="http://schema.org/Operator",
 *      normalizationContext={"groups"={"operator:read"}},
 *      denormalizationContext={"groups"={"operator:write"}}
 * )
 */
class Operator extends UserBase
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"operator:read"})
     * @Assert\DateTime(format="dd-MM-yyyy")
     */
    private \DateTime $birthDate;

    /**
     * @SerializedName("birthDate")
     * @Groups({"operator:write"})
     * @Assert\NotBlank
     */
    private string $plainBirthDate;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     * @Assert\NotBlank
     */
    private string $birthPlace;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     * @Assert\NotBlank
     * @Assert\Choice(
     *      callback={"Gesco\Helper\NationalitiesHelper", "getNationalities"}
     * )
     */
    private string $nationality;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     */
    private string $phoneNumber;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     * @Assert\NotBlank
     * @Assert\Choice(
     *      callback={"Gesco\Helper\ActivityHelper", "getActivities"}
     * )
     */
    private string $activity;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     * @Assert\NotBlank
     * @Assert\Choice(
     *      callback={"Gesco\Helper\IdentityHelper", "getValidIdentities"}
     * )
     */
    private string $identityDocument;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"operator:read", "operator:write"})
     * @Assert\NotBlank
     */
    private string $identityNumber;

    /**
     * @ORM\ManyToMany(targetEntity=Location::class, mappedBy="operators")
     */
    private $locations;


    public function __construct()
    {
        parent::__construct();
        $this->locations = new ArrayCollection();
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\Datetime $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPlainBirthDate(): string
    {
        return $this->plainBirthDate;
    }

    public function setPlainBirthDate(string $plainBirthDate): self
    {
        $this->plainBirthDate = $plainBirthDate;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getIdentityDocument(): ?string
    {
        return $this->identityDocument;
    }

    public function setIdentityDocument(string $identityDocument): self
    {
        $this->identityDocument = $identityDocument;

        return $this;
    }

    public function getIdentityNumber(): ?string
    {
        return $this->identityNumber;
    }

    public function setIdentityNumber(string $identityNumber): self
    {
        $this->identityNumber = $identityNumber;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->addOperator($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            $location->removeOperator($this);
        }

        return $this;
    }
}
