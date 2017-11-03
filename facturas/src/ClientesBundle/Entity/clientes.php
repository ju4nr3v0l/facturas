<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * clientes
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity(repositoryClass="ClientesBundle\Repository\clientesRepository")
 */
class clientes
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
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var int
     *
     * @ORM\Column(name="Identificacion", type="integer")
     */
    private $identificacion;


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
     * Set nombres
     *
     * @param string $nombres
     *
     * @return clientes
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set identificacion
     *
     * @param integer $identificacion
     *
     * @return clientes
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return int
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }
}

