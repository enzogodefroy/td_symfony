<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="commanddetail", indexes={@ORM\Index(name="idTimeslot", columns={"idTimeslot"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idEmployee", columns={"idEmployee"})})
 * @ORM\Entity
 */
class CommandDetail
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
     * @var \Command
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Command")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCommand", referencedColumnName="id")
     * })
     */
    private $command;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", length=0, nullable=false)
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="prepared", type="boolean", length=0, nullable=false)
     */
    private $prepared;

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

    public function getPrepared()
    {
        return $this->prepared;
    }

    public function setPrepared($prepared): self
    {
        $this->prepared = $prepared;

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

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }
}
