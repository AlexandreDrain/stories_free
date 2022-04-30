<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("post:read")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Stories::class, inversedBy="tags")
     */
    private $stories;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Stories>
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Stories $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
        }

        return $this;
    }

    public function removeStory(Stories $story): self
    {
        $this->stories->removeElement($story);

        return $this;
    }
}
