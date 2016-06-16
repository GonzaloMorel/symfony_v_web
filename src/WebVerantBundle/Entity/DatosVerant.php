<?php

namespace WebVerantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * DatosVerant
 *
 * @ORM\Table(name="datos_verant")
 * @ORM\Entity(repositoryClass="WebVerantBundle\Repository\DatosVerantRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class DatosVerant
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="rut", type="integer", unique=true)
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="dv", type="string", length=1)
     */
    private $dv;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=50, nullable=true)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_pais", type="string", length=10)
     */
    private $codigoPais;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono1", type="integer")
     */
    private $telefono1;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono2", type="integer", nullable=true)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="google_map", type="text", nullable=true)
     */
    private $googleMap;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="text", nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twiter", type="text", nullable=true)
     */
    private $twiter;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="text", nullable=true)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="google_plus", type="text", nullable=true)
     */
    private $googlePlus;

    /**
     * @var string
     *
     * @ORM\Column(name="rss", type="text", nullable=true)
     */
    private $rss;

    /**
     * @var string
     *
     * @ORM\Column(name="mision", type="text", nullable=true)
     */
    private $mision;

    /**
     * @var string
     *
     * @ORM\Column(name="vision", type="text", nullable=true)
     */
    private $vision;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="terminos", type="blob", nullable=true)
     */
    private $terminos;

    /**
     * @var string
     *
     * @ORM\Column(name="terminos_tipo", type="string", length=25, nullable=true)
     */
    private $terminosTipo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosVerant
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set rut
     *
     * @param integer $rut
     * @return DatosVerant
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return integer 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set dv
     *
     * @param string $dv
     * @return DatosVerant
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return string 
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return DatosVerant
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return DatosVerant
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set departamento
     *
     * @param string $departamento
     * @return DatosVerant
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set codigoPais
     *
     * @param string $codigoPais
     * @return DatosVerant
     */
    public function setCodigoPais($codigoPais)
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * Get codigoPais
     *
     * @return string 
     */
    public function getCodigoPais()
    {
        return $this->codigoPais;
    }

    /**
     * Set telefono1
     *
     * @param integer $telefono1
     * @return DatosVerant
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return integer 
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param integer $telefono2
     * @return DatosVerant
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return integer 
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DatosVerant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set googleMap
     *
     * @param string $googleMap
     * @return DatosVerant
     */
    public function setGoogleMap($googleMap)
    {
        $this->googleMap = $googleMap;

        return $this;
    }

    /**
     * Get googleMap
     *
     * @return string 
     */
    public function getGoogleMap()
    {
        return $this->googleMap;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return DatosVerant
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twiter
     *
     * @param string $twiter
     * @return DatosVerant
     */
    public function setTwiter($twiter)
    {
        $this->twiter = $twiter;

        return $this;
    }

    /**
     * Get twiter
     *
     * @return string 
     */
    public function getTwiter()
    {
        return $this->twiter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     * @return DatosVerant
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string 
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set googlePlus
     *
     * @param string $googlePlus
     * @return DatosVerant
     */
    public function setGooglePlus($googlePlus)
    {
        $this->googlePlus = $googlePlus;

        return $this;
    }

    /**
     * Get googlePlus
     *
     * @return string 
     */
    public function getGooglePlus()
    {
        return $this->googlePlus;
    }

    /**
     * Set rss
     *
     * @param string $rss
     * @return DatosVerant
     */
    public function setRss($rss)
    {
        $this->rss = $rss;

        return $this;
    }

    /**
     * Get rss
     *
     * @return string 
     */
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * Set mision
     *
     * @param string $mision
     * @return DatosVerant
     */
    public function setMision($mision)
    {
        $this->mision = $mision;

        return $this;
    }

    /**
     * Get mision
     *
     * @return string 
     */
    public function getMision()
    {
        return $this->mision;
    }

    /**
     * Set vision
     *
     * @param string $vision
     * @return DatosVerant
     */
    public function setVision($vision)
    {
        $this->vision = $vision;

        return $this;
    }

    /**
     * Get vision
     *
     * @return string 
     */
    public function getVision()
    {
        return $this->vision;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosVerant
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return DatosVerant
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return DatosVerant
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return DatosVerant
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set terminos
     *
     * @param string $terminos
     * @return DatosVerant
     */
    public function setTerminos($terminos)
    {
        $this->terminos = $terminos;

        return $this;
    }

    /**
     * Get terminos
     *
     * @return string 
     */
    public function getTerminos()
    {
        if ($this->terminos != ''){
            return stream_get_contents($this->terminos);
        }
        return $this->terminos;
    }
    
    /**
     * Set terminosTipo
     *
     * @param string $terminosTipo
     * @return DatosVerant
     */
    public function setTerminosTipo($terminosTipo)
    {
        $this->terminosTipo = $terminosTipo;

        return $this;
    }

    /**
     * Get terminosTipo
     *
     * @return string 
     */
    public function getTerminosTipo()
    {
        return $this->terminosTipo;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(){
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue(){
        $this->updatedAt = new \DateTime();
    }
    
    
    public function getRoles() {
        
    }
    
    public function getSalt() {
        
    }
    
    public function eraseCredentials() {
        
    }
}
