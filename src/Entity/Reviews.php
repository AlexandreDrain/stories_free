<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReviewsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ReviewsRepository::class)
 */
//  * @ApiResource(
//  *    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'reviews:list']]],
//  *    itemOperations: ['get' => ['normalization_context' => ['groups' => 'reviews:item']]],
//  *    paginationEnabled: false,
//  * )
//  * @ApiFilter(SearchFilter::class, properties: ['stories' => 'exact'])
class Reviews
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $liked;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $disliked;

    /**
     * @ORM\ManyToOne(targetEntity=Stories::class, inversedBy="reviews")
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $story;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="reviews")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="reviews_liked")
     */
    private $users_who_liked;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("post:read", "reviews:list", "reviews:item")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->users_who_liked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLiked(): ?int
    {
        return $this->liked;
    }

    public function setLiked(?int $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getDisliked(): ?int
    {
        return $this->disliked;
    }

    public function setDisliked(?int $disliked): self
    {
        $this->disliked = $disliked;

        return $this;
    }

    public function getStory(): ?Stories
    {
        return $this->story;
    }

    public function setStory(?Stories $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsersWhoLiked(): Collection
    {
        return $this->users_who_liked;
    }

    public function addUsersWhoLiked(Users $usersWhoLiked): self
    {
        if (!$this->users_who_liked->contains($usersWhoLiked)) {
            $this->users_who_liked[] = $usersWhoLiked;
            $usersWhoLiked->addReviewsLiked($this);
        }

        return $this;
    }

    public function removeUsersWhoLiked(Users $usersWhoLiked): self
    {
        if ($this->users_who_liked->removeElement($usersWhoLiked)) {
            $usersWhoLiked->removeReviewsLiked($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
