<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Vich\Uploadable
 */
class Book
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRead;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $bookPhotoName;

    /**
     * @Assert\File(
     *     mimeTypes = {
     *         "image/jpeg",
     *         "image/png",
     *     },
     *     mimeTypesMessage = "Некорректный файл фотографии!",
     *     maxSize = "5M",
     * )
     * @Vich\UploadableField(mapping="books_photos", fileNameProperty="bookPhotoName")
     */
    private $bookPhotoFile;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $bookFileName;

    /**
     * @Assert\File(
     *     mimeTypes = {
     *         "application/pdf",
     *         "application/msword",
     *         "text/xml",
     *         "text/plain",
     *         "text/markdown",
     *         "application/vnd.oasis.opendocument.text",
     *         "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *     },
     *     maxSize = "5M",
     *     mimeTypesMessage = "Некорректный файл книги!"
     * )
     * @Vich\UploadableField(mapping="books_files", fileNameProperty="bookFileName")
     */
    private $bookFileFile;

    public function __construct()
    {
        $this->dateRead = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDateRead(): ?\DateTimeInterface
    {
        return $this->dateRead;
    }

    public function setDateRead(\DateTimeInterface $dateRead): self
    {
        $this->dateRead = $dateRead;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getBookPhotoName(): ?string
    {
        return $this->bookPhotoName;
    }

    public function setBookPhotoName(?string $photoName): self
    {
        $this->bookPhotoName = $photoName;

        return $this;
    }

    public function getBookPhotoFile()
    {
        return $this->bookPhotoFile;
    }

    public function setBookPhotoFile($photoFile): void
    {
        $this->bookPhotoFile = $photoFile;
        if ($photoFile) {
            $this->bookPhotoName = $photoFile->getFileName();
        }
    }

    public function getBookFileName(): ?string
    {
        return $this->bookFileName;
    }

    public function setBookFileName(?string $fileName): self
    {
        $this->bookFileName = $fileName;

        return $this;
    }

    public function getBookFileFile()
    {
        return $this->bookFileFile;
    }

    public function setBookFileFile($bookFile): void
    {
        $this->bookFileFile = $bookFile;
    }
}
