<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`users`")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *      fields={"username"},
 *      message="There is already an account with this username."
 * )
 * @UniqueEntity(
 *      fields={"email"},
 *      message="There is already an account with this email."
 * )
 */
class User implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=180, unique=true, nullable=false)
     * @Assert\NotBlank(message="Username cannot be blank.")
     * @Assert\Regex(
     *      pattern="/^[a-z0-9]+$/i", htmlPattern="^[a-zA-Z0-9]+$",
     *      message="The username '{{ value }}' is not a valid username.",
     * )
     * @Assert\Length(
     *      min=2, max=32,
     *      minMessage="Your username must be at least {{ limit }} characters long",
     *      maxMessage="Your username cannot be longer than {{ limit }} characters"
     * )
     */
    private $username;

    /**
     * @ORM\Column(name="roles", type="json", nullable=false)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     * Assert\NotBlank(message="Password cannot be blank.")
     * Assert\Length(
     *      min=6, max=4096,
     *      minMessage="Your password must be at least {{ limit }} characters long",
     *      maxMessage="Your password cannot be longer than {{ limit }} characters"
     */
    private $password;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=false)
     * @Assert\Email(message="The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="E-mail cannot be blank.")
     * @Assert\Length(
     *      max=32, maxMessage="E-mail cannot be longer than {{ limit }} characters"
     * )
     */
    private $email;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="First name cannot be blank.")
     * @Assert\Regex(
     *      pattern="/^[a-z]+$/i", htmlPattern="^[a-zA-Z]+$",
     *      message="The first name '{{ value }}' is not a valid name.",
     * )
     * @Assert\Length(
     *      min=2, max=32,
     *      minMessage="First name must be at least {{ limit }} characters long.",
     *      maxMessage="First name cannot be longer than {{ limit }} characters"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     * @Assert\Regex(
     *      pattern="/^[a-z]+$/i", htmlPattern="^[a-zA-Z]+$",
     *      message="The last name '{{ value }}' is not a valid name.",
     * )
     * @Assert\Length(
     *      max=32, maxMessage="Last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    public function __construct()
    {
        $this->roles = [];
        $this->created = new \DateTime('NOW'); # set default NOW
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has PERSONAL_USER
        $roles[] = 'PERSONAL_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->password = null;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }
}