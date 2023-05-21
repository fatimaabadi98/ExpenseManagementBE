<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpenseRepository")
 */
class Expense
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * [Groups(['Expense:list', 'Expense:item'])]
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * [Groups(['Expense:list', 'Expense:item'])]
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * [Groups(['Expense:list', 'Expense:item'])]
     */
    private $value;

    // Getter and setter methods for the fields

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    // ...
}
