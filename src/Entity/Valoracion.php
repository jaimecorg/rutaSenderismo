<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValoracionRepository::class)
 */
class Valoracion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $puntuacion;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $puntuacionMedia;

    /**
     * @ORM\Column(type="text")
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity=Ruta::class, inversedBy="valoraciones")
     */
    private $ruta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPuntuacion(): ?int
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(int $puntuacion): self
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    public function getPuntuacionMedia(): ?float
    {
        return $this->puntuacionMedia;
    }

    public function setPuntuacionMedia(?float $puntuacionMedia): self
    {
        $this->puntuacionMedia = $puntuacionMedia;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getRuta(): ?Ruta
    {
        return $this->ruta;
    }

    public function setRuta(?Ruta $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }
}
