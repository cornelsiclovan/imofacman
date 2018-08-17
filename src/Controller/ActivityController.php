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
    public function homepage()
    {
        return $this->render(
            'start/start.html.twig'
        );
    }

    /**
     * @Route("/activity/list/", name="user_activity_list")
     */
    public function showActivityList(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(ActivityLog::class);

        $activities = $repository->findLogsByUserId($this->getUser());

        return $this->render(
            'activity/homepage.html.twig',
            [
                'activities' => $activities
            ]
        );
    }


    /**
     * @Route("/activity/calendar", name="calendar_activity")
     */
    public function calendarActivity()
    {
        return $this->render(
            'activity/calendar.html.twig'
        );
    }

    /**
     * @Route("/activity/new", name="new_activity")
     */
    public function newActivity(Request $request)
    {
        $form = $this->createForm(ActivityForm::class);
        //only handles data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $activityLog = $form->getData();

            $activityLog->setStaff($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($activityLog);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate adaugata!, %s', $this->getUser()->getUserName())
            );
            return $this->redirectToRoute('user_activity_list');
        }
        return $this->render(
          'activity/new.html.twig',
            [
              'activityForm' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/activity/log/{id}/edit", name="edit_activity")
     */
    public function editActivity(Request $request, ActivityLog $activityLog)
    {
        $form = $this->createForm(ActivityForm::class, $activityLog);
        //only handles data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $activityLog = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($activityLog);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate modificata, %s!', $this->getUser())

            );

            return $this->redirectToRoute('user_activity_list');
        }
        return $this->render(
            'activity/edit.html.twig',
            [
                'activityForm' => $form->createView()
            ]
        );
    }
}