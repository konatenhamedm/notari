<?php

namespace App\Controller;


use App\Entity\Dossier;
use App\Entity\DossierWorkflow;
use App\Entity\Identification;
use App\Form\DossierType;
use App\Repository\DocumentSigneRepository;
use App\Repository\DossierRepository;
use App\Repository\CourierArriveRepository;
use App\Repository\DossierWorkflowRepository;
use App\Repository\IdentificationRepository;
use App\Repository\PieceRepository;
use App\Repository\TypeRepository;
use App\Repository\WorkflowRepository;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class DossierController extends AbstractController
{
    /**
     * @Route("/dossier/acteVente", name="dossierActeVente")
     * @param DossierRepository $repository
     * @return Response
     */
    public function index(DossierRepository $repository): Response
    {

        //dd($code);
        $pagination = $repository->getListe(0,'Acte de vente');
        //dd($pagination);
        $finalise = $repository->getListe(1,'Acte de vente');
        //dd($pagination);
        return $this->render('_admin/dossier/index.html.twig', [
            'pagination' => $pagination,
            'finalise' => $finalise,
            'tableau' => [
                'numero_ouverture' => 'numero_ouverture',
                'Date_creation' => 'Date_creation',
                'Objet' => 'Objet',
                'Etape' => 'Etape',

            ],

            'modal' => 'modal',
            'titre' => 'Liste des actes de vente',

        ]);
    }

    /**
     * @Route("/dossier/{id}/show", name="dossierActeVente_show", methods={"GET"})
     * @param dossier $dossier
     * @param $id
     * @param DossierRepository $repository
     * @return Response
     */
    public function show(dossier $dossier,$id,DossierRepository $repository,DossierWorkflowRepository $dossierWorkflowRepository): Response
    {
      /*  $type = $dossier->getType();*/

        $form = $this->createForm(DossierType::class, $dossier, [

            'method' => 'POST',
            'action' => $this->generateUrl('dossierActeVente_show', [
                'id' => $dossier->getId(),
            ])
        ]);
/*
        $identifie = new Identification();

        $dossier->addIdentification($identifie);*/

//dd($dossierWorkflowRepository->getListe($dossier->getId()));
        return $this->render('_admin/dossier/voir.html.twig', [
            'titre'=>'Acte de vente',
             'workflow'=>$dossierWorkflowRepository->getListe($dossier->getId()),
           /* 'data'=>$repository->getFichier($id),*/
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dossierActeVente/{id}/details", name="dossierActeVente_details", methods={"GET","POST"})
     * @param DossierWorkflowRepository $dossierWorkflowRepository
     * @param PieceRepository $pieceRepository
     * @param DocumentSigneRepository $documentSigneRepository
     * @param IdentificationRepository $identificationRepository
     * @param Request $request
     * @param Dossier $dossier
     * @param EntityManagerInterface $em
     * @param $id
     * @param DossierRepository $repository
     * @return Response
     */
    public function details(DossierRepository $repository,DossierWorkflowRepository $dossierWorkflowRepository,PieceRepository $pieceRepository,DocumentSigneRepository $documentSigneRepository, IdentificationRepository $identificationRepository,Request $request,Dossier $dossier, EntityManagerInterface $em,$id): Response
    {

        $form = $this->createForm(DossierType::class, $dossier, [
            'method' => 'POST',
            'action' => $this->generateUrl('dossierActeVente_details', [
                'id' => $dossier->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {
            //dd($isAjax);
            $redirect = $this->generateUrl('dossierActeVente');
            $brochureFile = $form->get('documentSignes')->getData();
            $brochureFile2 = $form->get('pieces')->getData();
            $brochureFile3 = $form->get('enregistrements')->getData();

            if ($form->isValid()) {

                foreach ($brochureFile as $image) {
                    if (str_contains($image->getPath(),'.tmp')){
                        $file = new File($image->getPath());
                        $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                        // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('images_directory'), $newFilename);
                        $image->setPath($newFilename);
                    }
                }

                foreach ($brochureFile3 as $image) {
                    if (str_contains($image->getPath(),'.tmp')){
                        $file = new File($image->getPath());
                        $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                        // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('images_directory'), $newFilename);
                        $image->setPath($newFilename);
                    }
                }

                foreach ($brochureFile2 as $image) {
                    if (str_contains($image->getPath(),'.tmp')){
                        $file = new File($image->getPath());
                        $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                        // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('images_directory'), $newFilename);
                        $image->setPath($newFilename);

                    }
                }


                $em->persist($dossier);
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

        return $this->render('_admin/dossier/details.html.twig', [
            'titre'=>'Acte de vente',
            'workflow'=>$dossierWorkflowRepository->getListe($dossier->getId()),
            'dossier' => $dossier,
            'form' => $form->createView(),
            'identification_nombre' =>$identificationRepository->getLength($dossier->getId()),
            'piece_nombre' =>$pieceRepository->getLength($dossier->getId()),
            'document_nombre' =>$documentSigneRepository->getLength($dossier->getId()),
        ]);
    }

    /**
     * @Route("/dossier/new", name="dossierActeVente_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param DossierRepository $repository
     * @return Response
     */
    public function new(Request $request,WorkflowRepository $workflowRepository, EntityManagerInterface $em,DossierRepository $repository,TypeRepository $typeRepository): Response
    {
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class, $dossier, [
            'method' => 'POST',
            'action' => $this->generateUrl('dossierActeVente_new')
        ]);



        $form->handleRequest($request);



        $isAjax = $request->isXmlHttpRequest();
      /* $type = $form->getData()->getType();*/
        if ($form->isSubmitted()) {
            $statut = 1;
            $acteVente = $typeRepository->findOneBy(['titre'=>'acte de vente']);
            $workflows = $workflowRepository->getFichier($acteVente->getId());
          //  dd($workflows);
            $redirect = $this->generateUrl('dossierActeVente');
            $date = (new \DateTime('now'))->format('Y-m-d');

           //dd(  date('Y-m-d', strtotime($date. ' + 5 days')));

            if ($form->isValid()) {

               foreach ($workflows as $workflow){
                   //dd($workflow)
                    $dossier_workflow = new DossierWorkflow();
                    $nbre = $workflow->getNombreJours();
                    $dossier_workflow->setDossier($dossier)
                                     ->setWorkflow($workflow)
                                     ->setEtat("Non entamé")
                                     ->setDateDebut(new \DateTime('now'))
                                     ->setDateFin(date("Y-m-d", strtotime($date. ' +'.$nbre.'days'))) ;

                   $dossier->addDossierWorkflow($dossier_workflow);

                }

                $dossier->setActive(1);
                 $dossier->setEtat('0');
                 $dossier->setTypeActe($acteVente);
                 $dossier->setEtape('Identification du client');
               //$dossier->setDateCreation(new \DateTime('now'));
                $em->persist($dossier);
                $em->flush();

                $message = 'Opération effectuée avec succès';

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

        return $this->render('_admin/dossier/new.html.twig', [
            'titre'=>'Acte de vente',
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dossier/{id}/edit", name="dossierActeVente_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Dossier $dossier
     * @param EntityManagerInterface $em
     * @param $id
     * @param DossierRepository $repository
     * @return Response
     */
    public function edit(Request $request,Dossier $dossier, EntityManagerInterface $em,$id,DossierRepository $repository): Response
    {

        $form = $this->createForm(DossierType::class, $dossier, [
            'method' => 'POST',
            'action' => $this->generateUrl('dossierActeVente_edit', [
                'id' => $dossier->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
       // $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('dossierActeVente');


            if ($form->isValid()) {


                $em->persist($dossier);
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

        return $this->render('_admin/dossier/edit.html.twig', [
            'titre'=>'Acte de vente',
          /*  'data'=>$repository->getFichier($id),*/
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dossier/delete/{id}", name="dossierActeVente_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param dossier $dossier
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,dossier $dossier): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'dossierActeVente_delete'
                    , [
                        'id' => $dossier->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($dossier);
            $em->flush();

            $redirect = $this->generateUrl('dossierActeVente');

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
        return $this->render('_admin/dossier/delete.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dossier/valider", name="valider", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param DossierRepository $repository
     * @return Response
     */
    public function valider(Request $request,EntityManagerInterface $entityManager,DossierRepository $repository): Response
    {
        $response = new Response();
     //  dd(($request->get('vendeur')));
        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = substr($request->getContent(), -1);
             // dd();
            if ($id) {
                //dd($id);
                //dd("==================",$id);
               // $ensembles = $repository->listeDepartement($id);
               $dossier = $repository->find($id);
                $dossier->setEtape("Recueil des pièces");
               $entityManager->persist($dossier);
               $entityManager->flush();
                $arrayCollection = array();
                    $arrayCollection[] = array(
                        'id' => "je",
                        'libelle' => "Suis free",
                        // ... Same for each property you want
                    );

                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;
    }

    /**
     * @Route("/dossier/valider2", name="valider2", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function valider2(EntityManagerInterface $entityManager,DossierRepository $repository,Request $request): Response
    {
        $response = new Response();
        //dd("RES0");
        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = substr($request->getContent(), -1);
            // dd();
            if ($id) {
                //dd($id);
                //dd("==================",$id);
                // $ensembles = $repository->listeDepartement($id);
                $dossier = $repository->find($id);
                $dossier->setEtape("Signature");
                $entityManager->persist($dossier);
                $entityManager->flush();
                $arrayCollection = array();
                $arrayCollection[] = array(
                    'id' => "je",
                    'libelle' => "Suis free",
                    // ... Same for each property you want
                );

                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;

    }

    /**
     * @Route("/dossier/valider3", name="valider3", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function valider3(EntityManagerInterface $entityManager,DossierRepository $repository,Request $request): Response
    {
        $response = new Response();

        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = substr($request->getContent(), -1);
            // dd();
            if ($id) {
                //dd($id);
                //dd("==================",$id);
                // $ensembles = $repository->listeDepartement($id);
                $dossier = $repository->find($id);
                $dossier->setEtape("Enregistrement");
                $entityManager->persist($dossier);
                $entityManager->flush();
                $arrayCollection = array();
                $arrayCollection[] = array(
                    'id' => "je",
                    'libelle' => "Suis free",
                    // ... Same for each property you want
                );

                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;

    }

    /**
     * @Route("/dossier/valider4", name="valider4", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function valider4(EntityManagerInterface $entityManager,DossierRepository $repository,Request $request): Response
    {
        $response = new Response();
        //dd("RES0");
        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = substr($request->getContent(), -1);
            // dd();
            if ($id) {
                //dd($id);
                //dd("==================",$id);
                // $ensembles = $repository->listeDepartement($id);
                $dossier = $repository->find($id);
                $dossier->setEtape("Retrait titre de propriété ");
                $entityManager->persist($dossier);
                $entityManager->flush();
                $arrayCollection = array();
                $arrayCollection[] = array(
                    'id' => "je",
                    'libelle' => "Suis free",
                    // ... Same for each property you want
                );

                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;

    }

    /**
     * @Route("/dossier/{id}/active", name="dossierActeVente_active", methods={"GET"})
     * @param $id
     * @param Dossier $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Dossier $parent, EntityManagerInterface $entityManager): Response
    {

        if ($parent->getActive() == 1) {

            $parent->setActive(0);

        } else {

            $parent->setActive(1);

        }

        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'active' => $parent->getActive(),
        ], 200);

    }

}
  