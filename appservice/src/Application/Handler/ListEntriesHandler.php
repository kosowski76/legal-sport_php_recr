<?php
namespace App\Application\Handler;

use App\Domain\Repositories\EntryRepositoryInterface;

class ListEntriesHandler
{
    protected EntryRepositoryInterface $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->entryRepository->findAll();
    }
}