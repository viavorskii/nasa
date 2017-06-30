<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NasaController extends Controller
{
    /**
     * @Route("/neo/hazardous", name="hazardous")
     */
    public function hazardousAction(Request $request)
    {
        $data = $this->get("nasa.service")->getHazardous();
        return $this->json($data);
    }

    /**
     * @Route("/neo/fastest", name="fastest")
     */
    public function fastestAction(Request $request)
    {
        $hazardous = (bool)$request->get("hazardous");
        $hazardous = $hazardous == 'false' ? false : true;
        $data = $this->get("nasa.service")->getFastest($hazardous);
        return $this->json($data);
    }


    /**
     * @Route("/neo/best-year", name="best_year")
     */
    public function yearAction(Request $request)
    {
        $hazardous = $request->get("hazardous");
        $hazardous = $hazardous == 'false' ? false : true;
        $data = $this->get("nasa.service")->getBestYear($hazardous);
        return $this->json($data);
    }

    /**
     * @Route("/neo/best-month", name="best_month")
     */
    public function monthAction(Request $request)
    {
        $hazardous = (bool)$request->get("hazardous");
        $hazardous = $hazardous == 'false' ? false : true;
        $data = $this->get("nasa.service")->getBestMonth($hazardous);
        return $this->json($data);
    }
}
