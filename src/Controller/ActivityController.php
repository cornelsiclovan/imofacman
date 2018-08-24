<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 14:57
 */

namespace App\Controller;
use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Entity\Property;
use App\Form\ActivityForm;
use App\Form\TestForm;
use App\Repository\ActivityLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
        if($this->getUser() == null)
            return $this->redirectToRoute('security_login');
        else
            return $this->redirectToRoute('calendar_activity');
    }

    /**
     * @Route("/activity/list/", name="user_activity_list")
     */
    public function showActivityList(ActivityLogRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');

        $queryBuilder = $repository->getWithQueryBuilder($q, $this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('activity/homepage.html.twig',
            [
                'pagination' => $pagination
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

    /**
     * @Route("/test/forms", name="test_forms")
     */
    public function testForm(Request $request)
    {
        $form = $this->createForm(TestForm::class);


        return $this->render(
            'test/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}