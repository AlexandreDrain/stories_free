<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
//  * @ApiResource(
//  *    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'tags:list']]],
//  *    itemOperations: ['get' => ['normalization_context' => ['groups' => 'tags:item']]],
//  *    paginationEnabled: false,
//  * )
//  * @ApiFilter(SearchFilter::class, properties: ['stories' => 'exact'])
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read", "tags:list", "tags:item")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("post:read", "tags:list", "tags:item")
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
