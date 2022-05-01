<?php

namespace App\Entity;

use App\Entity\Tags;
use App\Entity\Users;
use App\Entity\Reviews;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StoriesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

// * @ApiResource(
//     *    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'stories:list']]],
//     *    itemOperations: ['get' => ['normalization_context' => ['groups' => 'stories:item']]],
//     *    order: ['liked' => 'DESC'],
//     *    paginationEnabled: false,
//     * )
//  =>
// Couldn't find constant collectionOperations, class App\Entity\Stories.

/**
 * @ORM\Entity(repositoryClass=StoriesRepository::class)
 * @ApiResource
 */
class Stories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $liked;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $disliked;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="stories")
     * @Groups("post:read")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, mappedBy="stories")
     * @Groups("post:read")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Reviews::class, mappedBy="story")
     * @Groups("post:read")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="stories_liked")
     */
    private $users_who_liked;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("post:read", "stories:list", "stories:item")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->users_who_liked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function setLiked(int $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getDisliked(): ?int
    {
        return $this->disliked;
    }

    public function setDisliked(int $disliked): self
    {
        $this->disliked = $disliked;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addStory($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeStory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setStory($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getStory() === $this) {
                $review->setStory(null);
            }
        }

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
            $usersWhoLiked->addStoriesLiked($this);
        }

        return $this;
    }

    public function removeUsersWhoLiked(Users $usersWhoLiked): self
    {
        if ($this->users_who_liked->removeElement($usersWhoLiked)) {
            $usersWhoLiked->removeStoriesLiked($this);
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
