<?php
namespace App\Controller;

use App\Application\Handler\ListEntriesHandler;
use App\Domain\Entry;
use App\Infrastructure\Doctrine\EntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EntryController extends AbstractController
{
    protected ListEntriesHandler $listEntriesHandler;

    public function __construct(
        ListEntriesHandler $listEntriesHandler)
    {
        $this->listEntriesHandler = $listEntriesHandler;
    }

    #[Route('/entries', name: 'get_entries', methods: ['GET'])]
    public function index(): JsonResponse
    {
      //  $entries = $this->listEntriesHandler->handle();
      $entries = $this->listEntriesHandler->handle();

      $allEntries = [];

      foreach ($entries as $entry)
        {
            $allEntries[] = [
                'id' => $entry->getId(),
                'name' => $entry->getName(),
                'category' => $entry->getCategory(),
                'date' => $entry->getDate()
            ];
        }

        return new JsonResponse($allEntries);
    }

    #[Route('/entries', name: 'create_entry', methods: ['POST'])]
    public function create(
        Request $request, EntityManagerInterface $em,
        SerializerInterface $serializer): JsonResponse
    {
        $entry = $serializer->deserialize($request->getContent(), Entry::class, 'json');
        $em->persist($entry);
        $em->flush();
        return new JsonResponse(
            $serializer->serialize(
                $entry, 'json', ['groups' => 'entry']), JsonResponse::HTTP_CREATED, [], true);
    }

    #[Route('/entries/{id}', name: 'get_entry', methods: ['GET'])]
    public function getEntry(
        Entry $entry, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize(
                $entry, 'json', ['groups' => 'entry']), JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/entries/{id}', name: 'update_entry', methods: ['PUT'])]
    public function update(
        Entry $entry, Request $request, EntityManagerInterface $em,
        SerializerInterface $serializer): JsonResponse
    {
        $serializer->deserialize($request->getContent(), Entry::class, 'json', ['object_to_populate' => $entry]);
        $em->flush();

        return new JsonResponse(
            $serializer->serialize($entry, 'json', ['groups' => 'entry']), JsonResponse::HTTP_OK, [], true);
    }
}