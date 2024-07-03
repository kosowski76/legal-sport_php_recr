<?php
namespace App\Tests\Repository;
use App\Domain\Entry;
use App\Domain\SubEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntryRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    //    $this->entityManager = null; // avoid memory leaks
    }

    public function testAddEntry(): void
    {
        $entry = new Entry();
        $entry->setName('Test Entry');
        $entry->setCategory('Test Category');
        $entry->setDate(new \DateTime());
        
        $this->entityManager->persist($entry);
        $this->entityManager->flush();
        
        $entryRepository = $this->entityManager->getRepository(Entry::class);
        $savedEntry = $entryRepository->findOneBy(['name' => 'Test Entry']);
        
        $this->assertNotNull($savedEntry);
        $this->assertSame('Test Entry', $savedEntry->getName());
        $this->assertSame('Test Category', $savedEntry->getCategory());
        $this->assertCount(0, $savedEntry->getSubEntries());
    }

    public function testUpdateEntry(): void
    {
        $entryRepository = $this->entityManager->getRepository(Entry::class);
        $entry = $entryRepository->findOneBy(['name' => 'Test Entry']);

        $this->assertNotNull($entry);

        $entry->setName('Updated Entry');

        $this->entityManager->flush();

        $updatedEntry = $entryRepository->findOneBy(['name' => 'Updated Entry']);

        $this->assertNotNull($updatedEntry);
        $this->assertSame('Updated Entry', $updatedEntry->getName());
    }

    public function testGetEntry(): void
    {
        $entryRepository = $this->entityManager->getRepository(Entry::class);
        $entry = $entryRepository->findOneBy(['name' => 'Updated Entry']);
    }

}