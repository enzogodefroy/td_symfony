<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="basketdetail", indexes={@ORM\Index(name="idTimeslot", columns={"idTimeslot"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idEmployee", columns={"idEmployee"})})
 * @ORM\Entity
 */
class BasketDetail
{
    /**
     * @var \Product
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProduct", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \Basket
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Basket")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBasket", referencedColumnName="id")
     * })
     */
    private $basket;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", length=0, nullable=false)
     */
    private $quantity;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): self
    {
        $this->basket = $basket;

        return $this;
    }
}
