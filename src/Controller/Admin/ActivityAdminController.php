<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.08.2018
 * Time: 10:23
 */

namespace App\Controller\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Security("is_granted('ROLE_MANAGE_LOGS')")
 * @Route("/admin")
 */
class ActivityAdminController extends AbstractController
{
    /**
     * @Route("/home", name="admin_home")
     */
    public function indexAction()
    {
        return $this->render(
            'admin/homepage.html.twig'
        );
    }
}