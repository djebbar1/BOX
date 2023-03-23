<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("book:read")]
  
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("book:read")]
    #[Assert\NotBlank]
    #[Assert\Length(min:3)]


    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups("book:read")]
    #[Assert\NotBlank]
    #[Assert\Length(min:3)]

    private ?string $author = null;

    #[ORM\Column]
    #[Groups("book:read")]


    private ?int $isbn = null;

    #[ORM\Column]
    #[Groups("book:read")]


    private ?bool $isAvailable = null;

    #[ORM\Column(length: 255)]
    #[Groups("book:read")]

    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("book:read")]

    private ?string $resume = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
  
    private ?Borrow $idBorrow = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    #[Groups("book:read")]
    private Collection $idCategory;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[Groups("book:read")]
    private ?Box $idBox = null;
    public function __toString()
    {
        return $this->title;
    }
    public function __construct()
    {
        $this->idCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getIdBorrow(): ?Borrow
    {
        return $this->idBorrow;
    }

    public function setIdBorrow(?Borrow $idBorrow): self
    {
        $this->idBorrow = $idBorrow;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getIdCategory(): Collection
    {
        return $this->idCategory;
    }

    public function addIdCategory(Category $idCategory): self
    {
        if (!$this->idCategory->contains($idCategory)) {
            $this->idCategory->add($idCategory);
        }

        return $this;
    }

    public function removeIdCategory(Category $idCategory): self
    {
        $this->idCategory->removeElement($idCategory);

        return $this;
    }

    public function getIdBox(): ?Box
    {
        return $this->idBox;
    }

    public function setIdBox(?Box $idBox): self
    {
        $this->idBox = $idBox;

        return $this;
    }
}
