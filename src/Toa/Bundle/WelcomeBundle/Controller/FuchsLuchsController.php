<?php

namespace Toa\Bundle\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class FuchsLuchsController
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 *
 * @Cache(
 *     smaxage=3600
 * )
 */
class FuchsLuchsController extends Controller
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
     * @Route(
     *     "/welcome/{name}",
     *     requirements = {
     *         "name" = "jette|sunny|enrico"
     *     }
     * )
     * @Template()
     */
    public function detailAction($name)
    {
        return array(
            'name' => $name
        );
    }
}
