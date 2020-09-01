<?php

namespace Gesco\Entity;

use Gesco\Entity\Operator;
use Doctrine\ORM\Mapping as ORM;
use Gesco\Repository\LocationRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 * @ApiResource(
 *      iri="http://schema.org/Location",
 *      normalizationContext={"groups"={"location:read"}},
 *      denormalizationContext={"groups"={"location:write"}}
 * )
 */
class Location
{
    public const AVAILABLE_PLACES = [
        "box",
        "etal",
        "place",
        "kiosque",
        "magasin"
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"location:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"location:read", "location:write", "operator:read", "operator:write"})
     * @Assert\Choice(
     *      Location::AVAILABLE_PLACES, message="choose a valid place for location"
     * )
     */
    private string $place;

    /**
     * @ORM\ManyToMany(targetEntity=Operator::class, inversedBy="locations")
     */
    private ArrayCollection $operators;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private bool $current;

    public function __construct()
    {
        $this->operators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection|Operator[]
     */
    public function getOperators(): Collection
    {
        return $this->operators;
    }

    public function addOperator(Operator $operator): self
    {
        if (!$this->operators->contains($operator)) {
            $this->operators[] = $operator;
        }

        return $this;
    }

    public function removeOperator(Operator $operator): self
    {
        if ($this->operators->contains($operator)) {
            $this->operators->removeElement($operator);
        }

        return $this;
    }

    public function getCurrent(): ?bool
    {
        return $this->current;
    }

    public function setCurrent(bool $current): self
    {
        $this->current = $current;

        return $this;
    }
}
