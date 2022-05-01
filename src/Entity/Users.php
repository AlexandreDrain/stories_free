<?php

namespace App\Entity;

use App\Entity\Reviews;
use App\Entity\Stories;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
//  * @ApiResource(
//  *    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'users:list']]],
//  *    itemOperations: ['get' => ['normalization_context' => ['groups' => 'users:item']]],
//  *    paginationEnabled: false,
//  * )
//  * @ApiFilter(SearchFilter::class, properties: ['stories' => 'exact'])
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read", "users:list", "users:item")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("post:read", "users:list", "users:item")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("post:read", "users:list", "users:item")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read", "users:list", "users:item")
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity=Stories::class, mappedBy="user")
     */
    private $stories;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read", "users:list", "users:item")
     */
    private $aboutUser;

    /**
     * @ORM\ManyToMany(targetEntity=Stories::class, inversedBy="users_who_liked")
     */
    private $stories_liked;

    /**
     * @ORM\OneToMany(targetEntity=Reviews::class, mappedBy="users")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Reviews::class, inversedBy="users_who_liked")
     */
    private $reviews_liked;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
        $this->stories_liked = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->reviews_liked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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
            $story->setUser($this);
        }

        return $this;
    }

    public function removeStory(Stories $story): self
    {
        if ($this->stories->removeElement($story)) {
            // set the owning side to null (unless already changed)
            if ($story->getUser() === $this) {
                $story->setUser(null);
            }
        }

        return $this;
    }

    public function getAboutUser(): ?string
    {
        return $this->aboutUser;
    }

    public function setAboutUser(?string $aboutUser): self
    {
        $this->aboutUser = $aboutUser;

        return $this;
    }

    /**
     * @return Collection<int, Stories>
     */
    public function getStoriesLiked(): Collection
    {
        return $this->stories_liked;
    }

    public function addStoriesLiked(Stories $storiesLiked): self
    {
        if (!$this->stories_liked->contains($storiesLiked)) {
            $this->stories_liked[] = $storiesLiked;
        }

        return $this;
    }

    public function removeStoriesLiked(Stories $storiesLiked): self
    {
        $this->stories_liked->removeElement($storiesLiked);

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
            $review->setUsers($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUsers() === $this) {
                $review->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviewsLiked(): Collection
    {
        return $this->reviews_liked;
    }

    public function addReviewsLiked(Reviews $reviewsLiked): self
    {
        if (!$this->reviews_liked->contains($reviewsLiked)) {
            $this->reviews_liked[] = $reviewsLiked;
        }

        return $this;
    }

    public function removeReviewsLiked(Reviews $reviewsLiked): self
    {
        $this->reviews_liked->removeElement($reviewsLiked);

        return $this;
    }
}
