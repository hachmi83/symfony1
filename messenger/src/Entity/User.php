<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $compter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleteUser;

    /**
     * @ORM\Column(type="boolean")
     */
    private $updateUser;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $articles;

    /**
     * User constructor.
     * @param $compter
     */
    public function __construct()
    {
        $this->compter = 0;
        $this->updateUser = false;
        $this->deleteUser = false;
        $this->date = new \DateTimeImmutable();
        $this->articles = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getCompter()
    {
        return $this->compter;
    }

    /**
     * @param mixed $compter
     */
    public function setCompter($compter)
    {
        $this->compter = $compter;
    }

    public function addCompter()
    {
        $this->compter++;
    }

    public function minusCompter()
    {
        $this->compter--;
    }

    /**
     * @return false
     */
    public function getDeleteUser(): bool
    {
        return $this->deleteUser;
    }

    /**
     * @param false $deleteUser
     */
    public function setDeleteUser(bool $deleteUser): void
    {
        $this->deleteUser = $deleteUser;
    }

    /**
     * @return false
     */
    public function getUpdateUser(): bool
    {
        return $this->updateUser;
    }

    /**
     * @param false $updateUser
     */
    public function setUpdateUser(bool $updateUser): void
    {
        $this->updateUser = $updateUser;
    }

    public function status(): string
    {
        if ($this->updateUser) {
            return 'USER UPDATED';
        }
        return 'USER NOT UPDATED';
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

}
