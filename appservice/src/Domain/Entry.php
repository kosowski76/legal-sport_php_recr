<?php
namespace App\Domain;

use App\Infrastructure\Doctrine\EntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: EntryRepository::class)]
class Entry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['entry'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['entry'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['entry'])]
    private $category;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['entry'])]
    private $date;

    #[ORM\OneToMany(targetEntity: SubEntry::class, mappedBy: 'entry',
        cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['entry'])]
    private $subEntries;

    public function __construct()
    {
        $this->subEntries = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
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
    public function setDate($date): void
    {
        $this->date = $date;
    }

    // Getters and setters...
    /**
    * @return Collection|SubEntry[]
    */
    public function getSubEntries(): Collection
    {
        return $this->subEntries;
    }

    public function addSubEntry(SubEntry $subEntry): self
    {
        if (!$this->subEntries->contains($subEntry))
        {
            $this->subEntries[] = $subEntry;
            $subEntry->setEntry($this);
        }

        return $this;
    }

    public function removeSubEntry(SubEntry $subEntry): self
    {
        if ($this->subEntries->removeElement($subEntry))
        {
            // set the owning side to null (unless already changed)
            if ($subEntry->getEntry() === $this)
            {
                $subEntry->setEntry(null);
            }
        }

        return $this;
    }
}
