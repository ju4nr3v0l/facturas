<?php

namespace FacturasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * facturas
 *
 * @ORM\Table(name="facturas")
 * @ORM\Entity(repositoryClass="FacturasBundle\Repository\facturasRepository")
 */
class facturas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroFactura", type="integer")
     */
    private $numeroFactura;

    /**
     * @var int
     *
     * @ORM\Column(name="idProducto", type="integer")
     */
    private $idProducto;

    /**
     * @var int
     *
     * @ORM\Column(name="idCliente", type="integer")
     */
    private $idCliente;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numeroFactura
     *
     * @param integer $numeroFactura
     *
     * @return facturas
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return int
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set idProducto
     *
     * @param integer $idProducto
     *
     * @return facturas
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;

        return $this;
    }

    /**
     * Get idProducto
     *
     * @return int
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Set idCliente
     *
     * @param integer $idCliente
     *
     * @return facturas
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * Get idCliente
     *
     * @return int
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }
}

