<?php

namespace App\Entity;

use App\Entity\Traits\TimestampsTrait;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 * @ORM\Table(name="tab_categories")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Categories
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
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private string $name = '';

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="categories")
     * @var Categories|null
     */
    private ?Categories $parent = null;

    /**
     * @ORM\OneToMany(targetEntity=Categories::class, mappedBy="parent")
     * @var ArrayCollection|Categories[]
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="categories")
     * @var ArrayCollection|Annonces[]
     */
    private $annonces;

    /**
     * Categories constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Categories|null
     */
    public function getParent(): ?Categories
    {
        return $this->parent;
    }

    /**
     * @param Categories|null $parent
     * @return $this
     */
    public function setParent(?Categories $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Categories $category
     * @return $this
     */
    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setParent($this);
        }

        return $this;
    }

    /**
     * @param Categories $category
     * @return $this
     */
    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getParent() === $this) {
                $category->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Annonces[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    /**
     * @param Annonces $annonce
     * @return $this
     */
    public function addAnnonce(Annonces $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setCategories($this);
        }

        return $this;
    }

    /**
     * @param Annonces $annonce
     * @return $this
     */
    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getCategories() === $this) {
                $annonce->setCategories(null);
            }
        }

        return $this;
    }
}
