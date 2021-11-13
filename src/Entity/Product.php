<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $reference = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $tva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primary_image;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $files = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="array")
     */
    private $keywork = [];

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $id_category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $toHide;

    /**
     * @ORM\OneToMany(targetEntity=Reference::class, mappedBy="product", orphanRemoval=true)
     */
    private $referencesProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $primaryReference;

    public function __construct()
    {
        $this->referencesProduct = new ArrayCollection();
    }

    public function __toString() 
    {
        return "#" . $this->getId() . ' - ' . $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?array
    {
        return $this->reference;
    }

    public function setReference(array $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getPrimaryImage(): ?string
    {
        return $this->primary_image;
    }

    public function setPrimaryImage(string $primary_image): self
    {
        $this->primary_image = $primary_image;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getKeywork(): ?array
    {
        return $this->keywork;
    }

    public function setKeywork(array $keywork): self
    {
        $this->keywork = $keywork;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(?Category $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(?string $image4): self
    {
        $this->image4 = $image4;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getToHide(): ?bool
    {
        return $this->toHide;
    }

    public function setToHide(bool $toHide): self
    {
        $this->toHide = $toHide;

        return $this;
    }

    /**
     * @return Collection|Reference[]
     */
    public function getReferencesProduct(): Collection
    {
        return $this->referencesProduct;
    }

    public function addReferencesProduct(Reference $referencesProduct): self
    {
        if (!$this->referencesProduct->contains($referencesProduct)) {
            $this->referencesProduct[] = $referencesProduct;
            $referencesProduct->setProduct($this);
        }

        return $this;
    }

    public function removeReferencesProduct(Reference $referencesProduct): self
    {
        if ($this->referencesProduct->removeElement($referencesProduct)) {
            // set the owning side to null (unless already changed)
            if ($referencesProduct->getProduct() === $this) {
                $referencesProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getPrimaryReference(): ?string
    {
        return $this->primaryReference;
    }

    public function setPrimaryReference(string $primaryReference): self
    {
        $this->primaryReference = $primaryReference;

        return $this;
    }
}
