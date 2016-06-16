<?php

namespace VerantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincias
 *
 * @ORM\Table(name="provincias", indexes={@ORM\Index(name="IDX_9F631427B99FF3B7", columns={"padre___prv"})})
 * @ORM\Entity
 */
class Provincias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id______prv", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="provincias_id______prv_seq", allocationSize=1, initialValue=1)
     */
    private $idPrv;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo__prv", type="string", length=64, nullable=true)
     */
    private $codigoPrv;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre__prv", type="string", length=128, nullable=true)
     */
    private $nombrePrv;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden___prv", type="bigint", nullable=true)
     */
    private $ordenPrv;

    /**
     * @var \Provincias
     *
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="padre___prv", referencedColumnName="id______prv")
     * })
     */
    private $padrePrv;
    


    /**
     * Get idPrv
     *
     * @return integer 
     */
    public function getIdPrv()
    {
        return $this->idPrv;
    }

    /**
     * Set codigoPrv
     *
     * @param string $codigoPrv
     * @return Provincias
     */
    public function setCodigoPrv($codigoPrv)
    {
        $this->codigoPrv = $codigoPrv;

        return $this;
    }

    /**
     * Get codigoPrv
     *
     * @return string 
     */
    public function getCodigoPrv()
    {
        return $this->codigoPrv;
    }

    /**
     * Set nombrePrv
     *
     * @param string $nombrePrv
     * @return Provincias
     */
    public function setNombrePrv($nombrePrv)
    {
        $this->nombrePrv = $nombrePrv;

        return $this;
    }

    /**
     * Get nombrePrv
     *
     * @return string 
     */
    public function getNombrePrv()
    {
        return $this->nombrePrv;
    }

    /**
     * Set ordenPrv
     *
     * @param integer $ordenPrv
     * @return Provincias
     */
    public function setOrdenPrv($ordenPrv)
    {
        $this->ordenPrv = $ordenPrv;

        return $this;
    }

    /**
     * Get ordenPrv
     *
     * @return integer 
     */
    public function getOrdenPrv()
    {
        return $this->ordenPrv;
    }

    /**
     * Set padrePrv
     *
     * @param \VerantBundle\Entity\Provincias $padrePrv
     * @return Provincias
     */
    public function setPadrePrv(\VerantBundle\Entity\Provincias $padrePrv = null)
    {
        $this->padrePrv = $padrePrv;

        return $this;
    }

    /**
     * Get padrePrv
     *
     * @return \VerantBundle\Entity\Provincias 
     */
    public function getPadrePrv()
    {
        return $this->padrePrv;
    }
}
