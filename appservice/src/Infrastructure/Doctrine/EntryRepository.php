<?php
namespace App\Infrastructure\Doctrine;

use App\Domain\Entry;
use App\Domain\Repositories\EntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

class EntryRepository extends ServiceEntityRepository implements EntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        //$this->_em = $entityManager;
        parent::__construct($registry, Entry::class);
    }

    /**
     * @param Entry $entry
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Entry $entry)
    {
        $this->_em->persist($entry);
        $this->_em->flush();
    }
}
