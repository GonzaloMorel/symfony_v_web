<?php

namespace VerantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="VerantBundle\Repository\UsuarioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Usuario implements UserInterface
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
     * @ORM\Column(name="rut", type="integer")
     * @Assert\NotBlank(message="Ingrese un Rut")
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
     * @ORM\Column(name="nombres", type="string", length=255)
     *
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apPat", type="string", length=50)
     * 
     */
    private $apPat;

    /**
     * @var string
     *
     * @ORM\Column(name="apMat", type="string", length=50)
     * 
     */
    private $apMat;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     * 
     */
    private $direccion;
    
    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumn(name="ciudad_id", referencedColumnName="id______prv")
     */
    private $ciudad;
    
    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id______prv")
     */
    private $region;

    /**
     * @var int
     *
     * ORM\Column(name="comuna_id", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumn(name="comuna_id", referencedColumnName="id______prv")
     * 
     */
    private $comuna;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     * 
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * 
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_usu", type="blob", nullable=true)
     */
    private $imagenUsu;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_usu_tipo", type="string", length=25, nullable=true)
     */
    private $imagenUsuTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_ci", type="blob", nullable=true)
     */
    private $imagenCi;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_ci_tipo", type="string", length=25, nullable=true)
     */
    private $imagenCiTipo;



    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string",  columnDefinition="ENUM('ROLE_SUPERVISOR','ROLE_ANALISTA', 'ROLE_SUPERUSER','ROLE_VERANT', 'ROLE_USER')",length=50)
     * 
     * 
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string",  columnDefinition="ENUM('ROLE_SUPERVISOR','ROLE_ANALISTA', 'ROLE_SUPERUSER','ROLE_VERANT', 'ROLE_USER')",length=50)
     * 
     * 
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=50, nullable=true)
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text", nullable=true)
     */
    private $texto;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_pais", type="string", length=10, nullable=true)
     */
    private $codigoPais;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="text", nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="text", nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="text", nullable=true)
     */
    private $linkedin;

    /**
     * @var bool
     *
     * @ORM\Column(name="publico", type="boolean")
     */
    private $publico;
        
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
     * @ORM\Column(name="password", type="string", length=255)
     * 
     */
    private $password;
    
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
     * Set rut
     *
     * @param integer $rut
     * @return Usuario
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
     * @return Usuario
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
     * Set nombres
     *
     * @param string $nombres
     * @return Usuario
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
     * Set apPat
     *
     * @param string $apPat
     * @return Usuario
     */
    public function setApPat($apPat)
    {
        $this->apPat = $apPat;

        return $this;
    }

    /**
     * Get apPat
     *
     * @return string 
     */
    public function getApPat()
    {
        return $this->apPat;
    }

    /**
     * Set apMat
     *
     * @param string $apMat
     * @return Usuario
     */
    public function setApMat($apMat)
    {
        $this->apMat = $apMat;

        return $this;
    }

    /**
     * Get apMat
     *
     * @return string 
     */
    public function getApMat()
    {
        return $this->apMat;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * Set email
     *
     * @param string $email
     * @return Usuario
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
     * Set imagenUsu
     *
     * @param string $imagenUsu
     * @return Usuario
     */
    public function setImagenUsu($imagenUsu)
    {
        $this->imagenUsu = $imagenUsu;
        
        return $this;
    }

    /**
     * Get imagenUsu
     *
     * @return string 
     */
    public function getImagenUsu()
    {
        if ($this->imagenUsu != ''){
            return stream_get_contents($this->imagenUsu);
        }
        return $this->imagenUsu;
    }

    /**
     * Set imagenUsuTipo
     *
     * @param string $imagenUsuTipo
     * @return Usuario
     */
    public function setImagenUsuTipo($imagenUsuTipo)
    {
        $this->imagenUsuTipo = $imagenUsuTipo;

        return $this;
    }

    /**
     * Get imagenUsuTipo
     *
     * @return string 
     */
    public function getImagenUsuTipo()
    {
        
        return $this->imagenUsuTipo;
    }

    /**
     * Set imagenCi
     *
     * @param string $imagenCi
     * @return Usuario
     */
    public function setImagenCi($imagenCi)
    {
        $this->imagenCi = $imagenCi;

        return $this;
    }

    /**
     * Get imagenCi
     *
     * @return string 
     */
    public function getImagenCi()
    {
        if ($this->imagenCi != ''){
            return stream_get_contents($this->imagenCi);
        }
        return $this->imagenCi;
    }

    /**
     * Set imagenCiTipo
     *
     * @param string $imagenCiTipo
     * @return Usuario
     */
    public function setImagenCiTipo($imagenCiTipo)
    {
        $this->imagenCiTipo = $imagenCiTipo;

        return $this;
    }

    /**
     * Get imagenCiTipo
     *
     * @return string 
     */
    public function getImagenCiTipo()
    {
        return $this->imagenCiTipo;
    }

    
    /**
     * Set roles
     *
     * @param string $roles
     * @return Usuario
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Usuario
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return Usuario
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Usuario
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
     * Set telefono
     *
     * @param integer $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
    
    /**
     * Set codigoPais
     *
     * @param string $codigoPais
     * @return Usuario
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
     * Set facebook
     *
     * @param string $facebook
     * @return Usuario
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
     * Set twitter
     *
     * @param string $twitter
     * @return Usuario
     */
    public function setTwitter($twitter)
    {
        $this->twiter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     * @return Usuario
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
     * Set publico
     *
     * @param boolean $publico
     * @return Usuario
     */
    public function setPublico($publico)
    {
        $this->publico = $publico;

        return $this;
    }

    /**
     * Get publico
     *
     * @return boolean 
     */
    public function getPublico()
    {
        return $this->publico;
    }
        
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * Set comuna
     *
     * @param \VerantBundle\Entity\Provincias $comuna
     * @return Usuario
     */
    public function setComuna(\VerantBundle\Entity\Provincias $comuna = null)
//    public function setComuna($comuna)
    {
        $this->comuna = $comuna;

        return $this;
    }

    /**
     * Get comuna
     *
     * return \VerantBundle\Entity\Provincias 
     * return User
     */
    public function getComuna()
    {
        return $this->comuna;
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
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
    
    
    /**
     * Set TERMINOS
     *
     * @param string $terminos
     * @return Usuario
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
     * @return Usuario
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
    
//    public function getRoles() {
        
//    }
    
    public function getSalt() {
        
    }
    
    public function getUsername(){
        
    }
    
    public function eraseCredentials() {
        
    }
    
    /**
     * Get ciudad
     *
     * @return \VerantBundle\Entity\Provincias 
     */
    function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Get region
     *
     * @return \VerantBundle\Entity\Provincias 
     */
    function getRegion()
    {
        return $this->region;
    }

    /**
     * Set comuna
     * param integer $ciudad
     * @param \VerantBundle\Entity\Provincias $ciudad
     * @return Empresa
     */
    function setCiudad(\VerantBundle\Entity\Provincias $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Set comuna
     * param integer $region
     * @param \VerantBundle\Entity\Provincias $region
     * @return Empresa
     */
    function setRegion(\VerantBundle\Entity\Provincias $region = null)
    {
        $this->region = $region;

        return $this;
    }


}
