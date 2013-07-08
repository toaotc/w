<?php

namespace Toa\Bundle\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 *
 */
class DefaultController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Template()
     */
    public function defaultAction()
    {
        return array();
    }

    /**
     * @param string $name
     *
     * @return array
     *
     * @Route("/welcome/{name}")
     * @Template()
     */
    public function detailAction($name)
    {
        return array(
            'name' => $name
        );
    }
}
