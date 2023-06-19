<?php

namespace App\Entity;

use App\Repository\CitationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CitationRepository::class)]
class Citation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('quote:read')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('quote:read')]
    private ?string $quote = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('quote:read')]
    private ?string $caractere = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'citations')]
    #[Groups('quote:read')]
    private Collection $author;

    #[ORM\Column]
    #[Groups('quote:read')]
    private ?int $countSave = null;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): static
    {
        $this->quote = $quote;

        return $this;
    }

    public function getCaractere(): ?string
    {
        return $this->caractere;
    }

    public function setCaractere(string $caractere): static
    {
        $this->caractere = $caractere;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(User $author): static
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(User $author): static
    {
        $this->author->removeElement($author);

        return $this;
    }

    public function getCountSave(): ?int
    {
        return $this->countSave;
    }

    public function setCountSave(int $countSave): static
    {
        $this->countSave = $countSave;

        return $this;
    }
}
