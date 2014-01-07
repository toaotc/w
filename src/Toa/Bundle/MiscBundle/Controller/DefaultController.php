<?php

namespace Toa\Bundle\MiscBundle\Controller;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ipAction(Request $request)
    {
        return new Response($request->getClientIp());
    }
}
