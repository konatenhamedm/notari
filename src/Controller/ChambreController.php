<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use App\Services\FileUploader;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class ChambreController extends AbstractController
{

    /**
     * @Route("/chambre", name="chambre")
     * @param ChambreRepository $repository
     * @return Response
     */
    public function index(ChambreRepository $repository): Response
    {

        $pagination = $repository->findBy(['active'=>1]);
        return $this->render('_admin/chambre/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'Image' => 'Image',
                'Libelle' => 'Libelle',
                'Pirx' => 'Pirx',


            ],
             'modal'=>'modal',
            'titre' => 'Liste des chambres',

        ]);
    }

    /**
     * @Route("/chambre/{id}/show", name="chambre_show", methods={"GET"})
     * @param Chambre $chambre
     * @return Response
     */
    public function show(Chambre $chambre): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre, [
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_show', [
                'id' => $chambre->getId(),
            ])
        ]);

        return $this->render('_admin/chambre/voir.html.twig', [
            'chambre' => $chambre,
            'titre' => 'Chambre',
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/modal/show", name="modal_show", methods={"GET","POST"})
     */
    public function modal(): Response
    {


        return $this->render('_admin/chambre/modal.html.twig');
    }

    /**
     * @Route("/chambre/new", name="chambre_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $chambre = new chambre();
        $form = $this->createForm(ChambreType::class, $chambre, [
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_new')
        ]);

        //$numero = 'RCM-' . $repository->getNombre();
        $statut=0;
        $statuts=0;
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {

            // dd($form->getData());
            $redirect = $this->generateUrl('chambre');


            /*$extension = strtolower(pathinfo($uploaderHelper->upload($uploadedFile), PATHINFO_EXTENSION));
            $valide = array('jpg', 'png', 'jpeg');
                $res ="";
            if(in_array($extension, $valide))
            {
                $res ="YES";
            }else{
                $res ="No";

             }*/
      //  dd($res);
            if ($form->isValid()) {

                $brochureFile = $form['image']->getData();
                if ($brochureFile) {
                    $brochureFileName = $fileUploader->upload($brochureFile);
                    $chambre->setImage($brochureFileName);
                }
               /*  }else{
                    return $this->redirect($this->generateUrl('modal_show'));
                }*/

             /*  $date = \DateTime::format(string $format);
                $chambre->setFaitLe($date);*/
                $chambre->setActive(1);
                $em->persist($chambre);
                $em->flush();
                $statut = 1;
                $statuts = 2;
                $message = 'Opération effectuée avec succès';

                $this->addFlash('success', $message);

        }

           // dd($isAjax);
            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirectToRoute('chambre');
                }

            }
        }

        return $this->render('_admin/chambre/new.html.twig', [
            'titre' => 'Chambre',
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/{id}/edit", name="chambre_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Chambre $chambre
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function edit(Request $request, Chambre $chambre, EntityManagerInterface $em, UploaderHelper $uploaderHelper): Response
    {

        $form = $this->createForm(ChambreType::class, $chambre, [
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_edit', [
                'id' => $chambre->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('chambre');

           // dd($uploadedFile);
            if ($form->isValid()) {

                $uploadedFile = $form['image']->getData();
                if ($uploadedFile) {

                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $chambre->setImage($newFilename);
                }
                $em->persist($chambre);
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

        return $this->render('_admin/chambre/edit.html.twig', [
            'titre' => 'Chambre',
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/delete/{id}", name="chambre_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Chambre $chambre
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em, Chambre $chambre): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'chambre_delete'
                    , [
                        'id' => $chambre->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()==false) {
            //dd($form->isSubmitted());
            $em->remove($chambre);
            $em->flush();

            $redirect = $this->generateUrl('chambre');

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
                return $this->redirectToRoute('chambre');
            }


        }
        return $this->render('_admin/chambre/delete.html.twig', [
            'chambre' => $chambre,
            'titre' => 'Chambre',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/{id}/active", name="chambre_active", methods={"GET"})
     * @param $id
     * @param Chambre $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, Chambre $parent, EntityManagerInterface $entityManager): Response
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
  