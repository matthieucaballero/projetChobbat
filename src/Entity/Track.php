<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrackRepository")
 * @Vich\Uploadable
 */
class Track
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="tracks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="track_file", fileNameProperty="trackName", 
     * size="trackSize", originalName="originalName")
     * @Assert\File(
     *  mimeTypes = {"audio/mpeg", "audio/wav", "audio/ogg"}
     * )
     * 
     * @var File|null
     */
    private $trackFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $trackName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $trackSize;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $trackNumber;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }


    public function setTrackName(?string $trackName): void
    {
        $this->trackName = $trackName;
    }

    public function getTrackName(): ?string
    {
        return $this->trackName;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $trackFile
     */
    public function settrackFile(?File $trackFile = null): void
    {
        $this->trackFile = $trackFile;

        if (null !== $trackFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function gettrackFile(): ?File
    {
        return $this->trackFile;
    }

    public function settrackSize(?int $trackSize): void
    {
        $this->trackSize = $trackSize;
    }

    public function gettrackSize(): ?int
    {
        return $this->trackSize;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getTrackNumber(): ?int
    {
        return $this->trackNumber;
    }

    public function setTrackNumber(?int $trackNumber): self
    {
        $this->trackNumber = $trackNumber;

        return $this;
    }


}
