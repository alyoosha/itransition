<?php

namespace App\Entity;

use App\Repository\ProductRepository;
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
    private $intProductDataId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $strProductName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $strProductDesc;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $strProductCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dtmAdded;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dtmDiscontinued;

    /**
     * @ORM\Column(type="datetime")
     */
    private $stmTimestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $intProductPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $intProductQty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntProductDataId(): ?int
    {
        return $this->intProductDataId;
    }

    public function setIntProductDataId(int $intProductDataId): self
    {
        $this->intProductDataId = $intProductDataId;

        return $this;
    }

    public function getStrProductName(): ?string
    {
        return $this->strProductName;
    }

    public function setStrProductName(string $strProductName): self
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    public function getStrProductDesc(): ?string
    {
        return $this->strProductDesc;
    }

    public function setStrProductDesc(string $strProductDesc): self
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    public function getStrProductCode(): ?string
    {
        return $this->strProductCode;
    }

    public function setStrProductCode(string $strProductCode): self
    {
        $this->strProductCode = $strProductCode;

        return $this;
    }

    public function getDtmAdded(): ?\DateTimeInterface
    {
        return $this->dtmAdded;
    }

    public function setDtmAdded(?\DateTimeInterface $dtmAdded): self
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

    public function getDtmDiscontinued(): ?\DateTimeInterface
    {
        return $this->dtmDiscontinued;
    }

    public function setDtmDiscontinued(?\DateTimeInterface $dtmDiscontinued): self
    {
        $this->dtmDiscontinued = $dtmDiscontinued;

        return $this;
    }

    public function getStmTimestamp(): ?\DateTimeInterface
    {
        return $this->stmTimestamp;
    }

    public function setStmTimestamp(\DateTimeInterface $stmTimestamp): self
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }

    public function getIntProductPrice(): ?int
    {
        return $this->intProductPrice;
    }

    public function setIntProductPrice(int $intProductPrice): self
    {
        $this->intProductPrice = $intProductPrice;

        return $this;
    }

    public function getIntProductQty(): ?int
    {
        return $this->intProductQty;
    }

    public function setIntProductQty(int $intProductQty): self
    {
        $this->intProductQty = $intProductQty;

        return $this;
    }
}
