<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 14:57
 */

namespace App\Controller;
use App\Entity\ActivityLog;
use App\Form\ActivityForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(ActivityLog::class);

        $activities = $repository->findAll();
        /** @var ActivityLog[] */
        return $this->render(
            'activity/homepage.html.twig',
            [
                'activities' => $activities
            ]
        );
    }

    /**
     * @Route("/new", name="new_activity")
     */
    public function newActivity(Request $request){
        $form = $this->createForm(ActivityForm::class);
        //only handles data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dump($form->getData()); die;
        }
        return $this->render(
          'activity/new.html.twig',
            [
              'activityForm' => $form->createView()
            ]
        );
    }
}