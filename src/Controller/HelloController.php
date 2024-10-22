<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Repository\VisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VisitRepository $visitRepository
    ) {
    }

    #[Route('/', name: 'app_hello')]
    public function index(Request $request): Response
    {
        $visit = new Visit();

        $visit->setUserAgent($request->headers->get('User-Agent'));

        $this->entityManager->persist($visit);
        $this->entityManager->flush();

        return $this->render('hello/index.html.twig', [
            'count' => $this->visitRepository->count()
        ]);
    }
}
