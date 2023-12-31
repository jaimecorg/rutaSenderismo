<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     * @Assert\Email()
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $nombreUsuario;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $clave;

    /**
     * @ORM\OneToMany(targetEntity=Ruta::class, mappedBy="usuario")
     */
    private $rutas;

    /**
     * @ORM\OneToMany(targetEntity=Valoracion::class, mappedBy="usuario", cascade={"remove"})
     */
    private $valoraciones;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     */
    private $permisos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrador;

    /**
     * @ORM\Column(type="boolean")
     */
    private $moderador;

    public function __construct()
    {
        $this->rutas = new ArrayCollection();
        $this->valoraciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombreUsuario): self
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * @return Collection<int, Ruta>
     */
    public function getRutas(): Collection
    {
        return $this->rutas;
    }

    public function addRuta(Ruta $ruta): self
    {
        if (!$this->rutas->contains($ruta)) {
            $this->rutas[] = $ruta;
            $ruta->setUsuario($this);
        }

        return $this;
    }

    public function removeRuta(Ruta $ruta): self
    {
        if ($this->rutas->removeElement($ruta)) {
            // set the owning side to null (unless already changed)
            if ($ruta->getUsuario() === $this) {
                $ruta->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Valoracion>
     */
    public function getValoraciones(): Collection
    {
        return $this->valoraciones;
    }

    public function addValoracione(Valoracion $valoracione): self
    {
        if (!$this->valoraciones->contains($valoracione)) {
            $this->valoraciones[] = $valoracione;
            $valoracione->setUsuario($this);
        }

        return $this;
    }

    public function removeValoracione(Valoracion $valoracione): self
    {
        if ($this->valoraciones->removeElement($valoracione)) {
            // set the owning side to null (unless already changed)
            if ($valoracione->getUsuario() === $this) {
                $valoracione->setUsuario(null);
            }
        }

        return $this;
    }

    public function getPermisos(): ?string
    {
        return $this->permisos;
    }

    public function setPermisos(string $permisos): self
    {
        $this->permisos = $permisos;

        return $this;
    }

    public function getAdministrador()
    {
        return $this->administrador;
    }

    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
        return $this;
    }

    public function getModerador()
    {
        return $this->moderador;
    }

    public function setModerador($moderador)
    {
        $this->moderador = $moderador;
        return $this;
    }

    /*
        ADMIN: borra
        MODERADOR: modifica
        USUARIO: crea
        No Usuario: solo lista
    */
    public function getRoles()
    {
        $roles = ['ROLE_USUARIO'];

        if ($this->getAdministrador()) {
            $roles[] = 'ROLE_ADMIN';
        }

        if ($this->getModerador()) {
            $roles[] = 'ROLE_MODERADOR';
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->clave;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getNombreUsuario();
    }

    public function eraseCredentials()
    {
    }
}
