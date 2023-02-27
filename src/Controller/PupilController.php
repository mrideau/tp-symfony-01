<?php

namespace App\Controller;

use App\Entity\Pupil;
use App\Form\PupilType;
use App\Repository\PupilRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/pupils')]
class PupilController extends AbstractController
{
    #[Route('/', name: 'app_pupil_index', methods: ['GET'])]
    public function index(PupilRepository $pupilRepository): Response
    {
        return $this->render('pupil/index.html.twig', [
            'pupils' => $pupilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pupil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PupilRepository $pupilRepository): Response
    {
        $pupil = new Pupil();
        $form = $this->createForm(PupilType::class, $pupil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pupilRepository->save($pupil, true);

            return $this->redirectToRoute('app_pupil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pupil/new.html.twig', [
            'pupil' => $pupil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pupil_show', methods: ['GET'])]
    public function show(Pupil $pupil): Response
    {
        return $this->render('pupil/show.html.twig', [
            'pupil' => $pupil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pupil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pupil $pupil, PupilRepository $pupilRepository): Response
    {
        $form = $this->createForm(PupilType::class, $pupil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pupilRepository->save($pupil, true);

            return $this->redirectToRoute('app_pupil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pupil/edit.html.twig', [
            'pupil' => $pupil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pupil_delete', methods: ['POST'])]
    public function delete(Request $request, Pupil $pupil, PupilRepository $pupilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pupil->getId(), $request->request->get('_token'))) {
            $pupilRepository->remove($pupil, true);
        }

        return $this->redirectToRoute('app_pupil_index', [], Response::HTTP_SEE_OTHER);
    }
}
