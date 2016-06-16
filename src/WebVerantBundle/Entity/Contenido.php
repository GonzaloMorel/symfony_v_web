<?php

namespace WebVerantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Contenido
 *
 * @ORM\Table(name="contenido")
 * @ORM\Entity(repositoryClass="WebVerantBundle\Repository\ContenidoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contenido
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
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     * 
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitulo", type="string", length=255, nullable=true)
     */
    private $subtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text", nullable=true)
     */
    private $texto;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="blob", nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_tipo", type="string", length=25, nullable=true)
     */
    private $imagenTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="url_video", type="text", nullable=true)
     */
    private $urlVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="despliegue", type="string", columnDefinition="ENUM('HOME','SERV_PERS','SERV_EMP','ABOUT', 'FAQ', 'CONTACT', 'TERMINOS','CARR_ABOUT')",length=50)
     * 
     * 
     * 
     */
    //
    private $despliegue;

    /**
     * @var string
     *
     * @ORM\Column(name="posicion", type="string", columnDefinition="ENUM('PRIMARIO','SECUNDARIO','SERVICIO', 'PROCESO','CLIENTE')",length=50)
     *  
     * 
     */
    //
    private $posicion;
    
    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer", nullable=true)
     * 
     */
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="icono", type="string", length=50, nullable=true)
     */
    private $icono;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Contenido
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set subtitulo
     *
     * @param string $subtitulo
     * @return Contenido
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    /**
     * Get subtitulo
     *
     * @return string 
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Contenido
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Contenido
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        if ($this->imagen != ''){
            return stream_get_contents($this->imagen);
        }
        return $this->imagen;
    }

    /**
     * Set imagenTipo
     *
     * @param string $imagenTipo
     * @return Contenido
     */
    public function setImagenTipo($imagenTipo)
    {
        $this->imagenTipo = $imagenTipo;

        return $this;
    }

    /**
     * Get imagenTipo
     *
     * @return string 
     */
    public function getImagenTipo()
    {
        return $this->imagenTipo;
    }

    /**
     * Set urlVideo
     *
     * @param string $urlVideo
     * @return Contenido
     */
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }

    /**
     * Get urlVideo
     *
     * @return string 
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * Set despliegue
     *
     * @param string $despliegue
     * @return Contenido
     */
    public function setDespliegue($despliegue)
    {
        $this->despliegue = $despliegue;

        return $this;
    }

    /**
     * Get despliegue
     *
     * @return string 
     */
    public function getDespliegue()
    {
        return $this->despliegue;
    }

    /**
     * Set posicion
     *
     * @param string $posicion
     * @return Contenido
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return string 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set icono
     *
     * @param string $icono
     * @return Contenido
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;

        return $this;
    }

    /**
     * Get icono
     *
     * @return string 
     */
    public function getIcono()
    {
        return $this->icono;
    }
    
    /**
     * Set orden
     *
     * @param integer $orden
     * @return Contenido
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Contenido
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
     * @return Contenido
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
     * @return Contenido
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
