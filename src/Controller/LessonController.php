<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Entity\Tutorial;
use App\Repository\ResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lesson', name: 'lesson_')]
class LessonController extends AbstractController
{
    #[Route('/{id}', name: 'index')]
    public function index(Tutorial $tutorial): Response
    {
        $lessons = $tutorial->getLessons();

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
            'tutorial' => $tutorial
        ]);
    }

    #[Route('/show/{id}', requirements: ['id' => '\d+'], name: 'show')]
    public function show(
        Lesson $lesson,
        Request $request,
        ResponseRepository $responseRepository,
    ): Response {
        $tutorial = $lesson->getTutorial();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'BRAVO ! Vous avez validé le quiz !');
        }

        return $this->renderForm('lesson/show.html.twig', [
            'form' => $form,
            'lesson' => $lesson,
            'tutorial' => $tutorial
        ]);
    }
}
