<?php

namespace App\Entity;

use App\Repository\RutaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RutaRepository::class)
 */
class Ruta
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
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $direccion;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $distancia;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $desnivel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="rutas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity=Valoracion::class, mappedBy="ruta")
     */
    private $valoraciones;

    /**
     * @ORM\OneToMany(targetEntity=Imagen::class, mappedBy="ruta", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $imagenes;


    public function __construct()
    {
        $this->valoraciones = new ArrayCollection();
        $this->imagenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getDistancia(): ?float
    {
        return $this->distancia;
    }

    public function setDistancia(?float $distancia): self
    {
        $this->distancia = $distancia;

        return $this;
    }

    public function getDesnivel(): ?int
    {
        return $this->desnivel;
    }

    public function setDesnivel(?int $desnivel): self
    {
        $this->desnivel = $desnivel;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, Valoracion>
     */
    public function getValoraciones(): Collection
    {
        return $this->valoraciones;
    }

    public function addValoraciones(Valoracion $valoraciones): self
    {
        if (!$this->valoraciones->contains($valoraciones)) {
            $this->valoraciones[] = $valoraciones;
            $valoraciones->setRuta($this);
        }

        return $this;
    }

    public function removeValoracione(Valoracion $valoraciones): self
    {
        if ($this->valoraciones->removeElement($valoraciones)) {
            // set the owning side to null (unless already changed)
            if ($valoraciones->getRuta() === $this) {
                $valoraciones->setRuta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Imagen>
     */
    public function getImagenes(): Collection
    {
        return $this->imagenes;
    }

    public function addImagen(Imagen $imagen): self
    {
        if (!$this->imagenes->contains($imagen)) {
            $this->imagenes[] = $imagen;
            $imagen->setRuta($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): self
    {
        if ($this->imagenes->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getRuta() === $this) {
                $imagen->setRuta(null);
            }
        }

        return $this;
    }
}
