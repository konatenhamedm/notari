<?php

namespace App\Controller;

use App\Entity\DocumentTypeActe;
use App\Form\GestionTypeActeType;
use App\Repository\DocumentTypeActeRepository;
use App\Repository\GestionTypeActeRepository;
use App\Repository\TypeRepository;
use App\Repository\WorkflowRepository;
use App\Entity\GestionTypeActe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/admin")
 * il s'agit du workflow des module
 */
class DocumentTypeActeController extends AbstractController
{
    /**
     * @Route("/documentTypeActe", name="documentTypeActe")
     * @param GestionTypeActeRepository $repository
     * @return Response
     */
    public function index(GestionTypeActeRepository $repository): Response
    {

        $pagination = $repository->findBy(['active' => 1]);
//dd($pagination);
        return $this->render('_admin/documentTypeActe/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'titre' => 'titre',
                'type_acte' => 'type_acte',
                'nombre_total_jour' => 'nombre_total_jour',


            ],
            'modal' => 'modal',

            'titre' => 'Liste des documentTypeActe',
        ]);
    }

    /**
     * @Route("/documentTypeActe/new", name="documentTypeActe_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TypeRepository $repository
     * @param DocumentTypeActeRepository $documentsRepository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, TypeRepository $repository,DocumentTypeActeRepository $documentsRepository): Response
    {
        $document = new GestionTypeActe();

        $documents = $documentsRepository->getFichierLibelle("Acte de vente");

        foreach ($documents as $item){

            $document->addDocumentTypeActe($item);
        }

        $form = $this->createForm(GestionTypeActeType::class, $document, [
            'method' => 'POST',
            'action' => $this->generateUrl('documentTypeActe_new')
        ]);
        $form->handleRequest($request);
      //  dd($request);


        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {
            $response = [];
            $redirect = $this->generateUrl('dashboard');
            $datas = $form->get('documentTypeActes')->getData();
           // dd($datas);
            $typeActe = $repository->find($request->get('type'));


            if ($form->isValid()) {

                foreach ($datas as $data) {
                    //dd($data->getId());
                    $data->setType($typeActe);
                }
                $document->setActive(1);
                $em->persist($document);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }
            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/documentTypeActe/new.html.twig', [
            'documentTypeActe' => $document,
            'form' => $form->createView(),
            'titre' => 'Documents',
            'type' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/documentTypeActe/{id}/edit", name="documentTypeActe_edit", methods={"GET","POST"})
     * @param Request $request
     * @param GestionTypeActe $document
     * @param EntityManagerInterface $em
     * @param TypeRepository $repository
     * @return Response
     */
    public function edit(Request $request, GestionTypeActe $document, EntityManagerInterface $em, TypeRepository $repository): Response
    {

        $form = $this->createForm(GestionTypeActeType::class, $document, [
            'method' => 'POST',
            'action' => $this->generateUrl('documentTypeActe_edit', [
                'id' => $document->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {
            $response = [];
            $redirect = $this->generateUrl('documentTypeActe');
            $datas = $form->get('documentTypeActe')->getData();

            $typeActe = $repository->find($request->get('type'));
            $total =0;

            if ($form->isValid()) {

                foreach ($datas as $data) {
                    $data->setTypeActe($typeActe);
                    $total = $total + $data->getNombreJours();
                }
                $document->setActive(1);
                $em->persist($document);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }
            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('_admin/documentTypeActe/edit.html.twig', [
            'documentTypeActe' => $document,
            'form' => $form->createView(),
            'type' => $repository->findAll(),
            'titre' => 'documentTypeActe',
        ]);
    }

    /**
     * @Route("/workflow/{id}/show", name="workflow_show", methods={"GET"})
     * @param GestionTypeActe $document
     * @return Response
     */
    public function show(GestionTypeActe $document, TypeRepository $repository): Response
    {
        $form = $this->createForm(GestionTypeActeType::class, $document, [
            'method' => 'POST',
            'action' => $this->generateUrl('documentTypeActe_show', [
                'id' => $document->getId(),
            ])
        ]);

        return $this->render('_admin/documentTypeActe/voir.html.twig', [
            'documentTypeActe' => $document,
            'titre' => 'documentTypeActe',
            'type' => $repository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/workflow/{id}/active", name="workflow_active", methods={"GET"})
     * @param $id
     * @param GestionTypeActe $document
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, GestionTypeActe $document, EntityManagerInterface $entityManager): Response
    {


        if ($document->getActive() == 1) {

            $document->setActive(0);

        } else {

            $document->setActive(1);

        }

        $entityManager->persist($document);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'active' => $document->getActive(),
        ], 200);


    }


    /**
     * @Route("/workflow/delete/{id}", name="workflow_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param GestionTypeActe $document
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em, GestionTypeActe $document): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'workflow_delete'
                    , [
                        'id' => $document->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($document);
            $em->flush();

            $redirect = $this->generateUrl('workflow');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut' => 1,
                'message' => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }


        }
        return $this->render('_admin/documentTypeActe/delete.html.twig', [
            'workflow' => $document,
            'form' => $form->createView(),
        ]);
    }

}
