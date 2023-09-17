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

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Figure $figure_id = null;

    #[ORM\Column(length: 255)]
    private ?string $media_path = null;

    #[ORM\Column(length: 255)]
    private ?string $groupe = null;

    #[ORM\Column]
    private ?bool $firstMedia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFigureId(): ?Figure
    {
        return $this->figure_id;
    }

    public function setFigureId(?Figure $figure_id): static
    {
        $this->figure_id = $figure_id;

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

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): static
    {
        $this->groupe = $groupe;

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
