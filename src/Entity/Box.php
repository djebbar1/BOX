<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("book:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column]
    #[Groups("book:read")]
    private ?int $zipcode = null;

    #[ORM\Column(length: 255)]
    #[Groups("book:read")]
    private ?string $city = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups("book:read")]
    private array $geoLoc = [];

    #[ORM\Column]
    #[Groups("book:read")]
    private ?int $capacity = null;

    #[ORM\OneToMany(mappedBy: 'idBox', targetEntity: Book::class)]
    
    private Collection $books;
    public function __toString()
    {
        return $this->street;
    }
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getGeoLoc(): array
    {
        return $this->geoLoc;
    }

    public function setGeoLoc(array $geoLoc): self
    {
        $this->geoLoc = $geoLoc;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setIdBox($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getIdBox() === $this) {
                $book->setIdBox(null);
            }
        }

        return $this;
    }
}
