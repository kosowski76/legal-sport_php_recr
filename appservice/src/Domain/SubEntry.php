<?php
namespace App\Domain;

use App\Repository\SubEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubEntryRepository::class)]
class SubEntry
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
    private $value;
    
    #[ORM\ManyToOne(targetEntity: Entry::class, inversedBy: 'subEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private $entry;

    // Getters and setters...
}
