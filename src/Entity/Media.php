<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Figure $figure = null;

    #[ORM\Column(type: "string", enumType: MediaGroupe::class)]
    private ?MediaGroupe $groupe = null;

    #[ORM\Column(length: 255)]
    private ?string $media_path = null;

    #[ORM\Column]
    private ?bool $firstMedia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): static
    {
        $this->figure = $figure;

        return $this;
    }

    public function getGroupe(): ?MediaGroupe
    {
        return $this->groupe;
    }

    public function setGroupe(MediaGroupe $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getMediaPath(): ?string
    {
        return $this->media_path;
    }

    public function setMediaPath(string $media_path): static
    {
        $this->media_path = $media_path;

        return $this;
    }

    public function isFirstMedia(): ?bool
    {
        return $this->firstMedia;
    }

    public function setFirstMedia(bool $firstMedia): static
    {
        $this->firstMedia = $firstMedia;

        return $this;
    }
}
