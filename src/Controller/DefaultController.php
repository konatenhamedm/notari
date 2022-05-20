<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\CalendarRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("admin/agenda",name="agenda")
     * @param CalendarRepository $repository
     * @return Response
     */
    public function calendar(CalendarRepository $repository,NormalizerInterface $normalizer)
    {
      $ligne = $repository->findAll();
      $rdvs = [];

      foreach ($ligne as $data){
          $rdvs [] = [
              'id'=>$data->getId(),
              'start'=>$data->getStart()->format('Y-m-d H:i:s'),
              'end'=>$data->getEnd()->format('Y-m-d H:i:s'),
              'description'=>$data->getDescription(),
              'title'=>$data->getTitle(),
              'allDay'=>$data->getAllDay(),
              'backgroundColor'=>$data->getBackgroundColor(),
              'borderColor'=>$data->getBorderColor(),
              'textColor'=>$data->getTextColor(),
          ];
      }

      $data =  json_encode($rdvs);
      //dd($data);

        return $this->render("calendar/calendar.html.twig",compact('data'));
    }

    /**
     * @Route("/admin/dashboard", name="dashboard", methods={"GET", "POST"})
     * @return Response
     */
    public function dashboard()
    {
        return $this->render('_admin/dashboard/index.html.twig');
    }

    /**
     * @Route("/admin/frais", name="frais", methods={"GET", "POST"})
     * @return Response
     */
    public function frais()
    {
        return $this->render('_admin/frais/index.html.twig');
    }




}