<?php

namespace Toa\Bundle\MiscBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultController
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/myip")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return new Response($request->getClientIp());
    }
}
