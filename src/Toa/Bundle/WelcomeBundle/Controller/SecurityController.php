<?php

namespace Toa\Bundle\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SecurityController
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 *
 */
class SecurityController extends Controller
{
    /**
     * @return array
     *
     * @Route("/logout")
     */
    public function logoutAction()
    {
        return array();
    }
}
