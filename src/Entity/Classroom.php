<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'classroom', targetEntity: Pupil::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $pupils;

    #[ORM\ManyToOne(inversedBy: 'classroom')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $teacher = null;

    public function __construct()
    {
        $this->pupils = new ArrayCollection();
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
     * @return Collection<int, Pupil>
     */
    public function getPupils(): Collection
    {
        return $this->pupils;
    }

    public function addPupil(Pupil $pupil): self
    {
        if (!$this->pupils->contains($pupil)) {
            $this->pupils->add($pupil);
            $pupil->setClassroom($this);
        }

        return $this;
    }

    public function removePupil(Pupil $pupil): self
    {
        if ($this->pupils->removeElement($pupil)) {
            // set the owning side to null (unless already changed)
            if ($pupil->getClassroom() === $this) {
                $pupil->setClassroom(null);
            }
        }

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
