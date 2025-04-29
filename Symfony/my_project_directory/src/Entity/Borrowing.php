<?php

namespace App\Entity;

use App\Repository\BorrowingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorrowingRepository::class)]
class Borrowing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $borrowDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $returnDate = null;

    #[ORM\ManyToOne(inversedBy: 'borrowings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'borrowings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reader $reader = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowDate(): ?\DateTime
    {
        return $this->borrowDate;
    }

    public function setBorrowDate(\DateTime $borrowDate): static
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTime
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTime $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getReader(): ?Reader
    {
        return $this->reader;
    }

    public function setReader(?Reader $reader): static
    {
        $this->reader = $reader;

        return $this;
    }
}
