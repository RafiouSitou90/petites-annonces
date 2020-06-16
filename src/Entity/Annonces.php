<?php

namespace App\Entity;

use App\Entity\Traits\TimestampsTrait;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnoncesRepository::class)
 * @ORM\Table(name="tab_annonces")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Annonces
{
    use TimestampsTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @var string
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $title = '';

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $slug;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private string $content = '';

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private bool $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     * @var Users|null
     */
    private ?Users $users = null;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     * @var Categories|null
     */
    private ?Categories $categories = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Users|null
     */
    public function getUsers(): ?Users
    {
        return $this->users;
    }

    /**
     * @param Users|null $users
     * @return $this
     */
    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Categories|null
     */
    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    /**
     * @param Categories|null $categories
     * @return $this
     */
    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
