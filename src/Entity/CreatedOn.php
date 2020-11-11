<?php

namespace App\Entity;

use App\Repository\CreatedOnRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreatedOnRepository::class)
 */
class CreatedOn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatd_on;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_on;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdatdOn(): ?\DateTimeInterface
    {
        return $this->updatd_on;
    }

    public function setUpdatdOn(?\DateTimeInterface $updatd_on): self
    {
        $this->updatd_on = $updatd_on;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTimeInterface $created_on): self
    {
        $this->created_on = $created_on;

        return $this;
    }
}
