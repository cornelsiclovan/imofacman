<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2018
 * Time: 14:57
 */

namespace App\Controller;
use App\Entity\ActivityLog;
use App\Entity\ActivityLogProperty;
use App\Form\ActivityForm;
use App\Form\ActivityFormMentainanceBoss;
use App\Form\ActivityFormMultiple;
use App\Form\ActivityOwnerForm;
use App\Form\ActivityOwnerFormMultiple;
use App\Repository\ActivityLogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Proxies\__CG__\App\Entity\Property;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $roles = $this->getUser()->getRoles();
        $q = $request->query->get('q');
        if(in_array('ROLE_MENTAINANCE_BOSS', $roles)){
            $queryBuilder = $repository->getForMantainanceBossQueryBuilder($q, $this->getUser());
        }else if($this->getUser()->getStaffType()->getAddDataFor() != 'Proprietar')
            $queryBuilder = $repository->getWithQueryBuilder($q, $this->getUser());
        else
            $queryBuilder = $repository->getForOwnerWithQueryBuilder($q, $this->getUser());

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('activity/homepage.html.twig',
            [
                'pagination' => $pagination,
                'user_is_owner' => ($this->getUser()->getStaffType()->getAddDataFor() == 'Proprietar')
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
        $bool = false;
        $bool_mentainance_boss = false;

        $roles = $this->getUser()->getRoles();
        if(in_array('ROLE_MENTAINANCE_BOSS', $roles)){
            $form = $this->createForm(ActivityFormMentainanceBoss::class);
            $form->remove('lunchBreak');
            $bool_mentainance_boss = true;
        }else if($this->getUser()->getStaffType()->getAddDataFor() == 'Proprietar') {
            $form = $this->createForm(ActivityOwnerForm::class);
            $form->remove('lunchBreak');
            $bool = true;
        }else{
            $form = $this->createForm(ActivityForm::class);
            $form->remove('lunchBreak');
        }

        //only handles data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $activityLog = $form->getData();

            //dump($activityLog);die();

            if(!$bool_mentainance_boss){
                $activityLog->setStaff($this->getUser());
            }

            $properties = $activityLog->getProperty();
            foreach($properties as $property) {
                $activityLog->addOwner($property->getOwner());
            }

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
                'user_is_owner' => $bool,
                'user_is_mentainance_boss' => $bool_mentainance_boss
            ]
        );
    }


    /**
     * @Route("/activity/new/multiple", name="new_activity_multiple")
     */
    public function newMultipleActivity(Request $request)
    {
        $bool = false;
        if($this->getUser()->getStaffType()->getAddDataFor() == 'Proprietar') {
            $form = $this->createForm(ActivityOwnerFormMultiple::class);
            $bool = true;
        }else{
            $form = $this->createForm(ActivityFormMultiple::class);
        }


        //only handles data on POST

        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            $activityLog = $form->getData();

            $activityLog->setStaff($this->getUser());

            $properties = $activityLog->getProperty();
            foreach($properties as $property) {
                $activityLog->addOwner($property->getOwner());
            }

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
            'activity/newMultiple.html.twig',
            [
                'activityForm' => $form->createView(),
                'user_is_owner' => $bool
            ]
        );
    }

    /**
     * @Route("/activity/log/{id}/edit", name="edit_activity")
     */
    public function editActivity(Request $request, ActivityLog $activityLog)
    {
        $bool = false;
        $bool_mentainance_boss = false;
        $roles = $this->getUser()->getRoles();
        if(in_array('ROLE_MENTAINANCE_BOSS', $roles)){
            $form = $this->createForm(ActivityFormMentainanceBoss::class, $activityLog);
            $form->remove('lunchBreak');
            $bool_mentainance_boss = true;
        }else if($this->getUser()->getStaffType()->getAddDataFor() == 'Proprietar') {
            $form = $this->createForm(ActivityOwnerForm::class, $activityLog);
            $form->remove('lunchBreak');
            $bool = true;
        }else{
            $form = $this->createForm(ActivityForm::class, $activityLog);
        }

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $activityLog = $form->getData();

            $properties = $activityLog->getProperty();

            foreach($properties as $property) {
                dump($property->getOwner());
                $activityLog->addOwner($property->getOwner());
            }



            $em = $this->getDoctrine()->getManager();

            $em->persist($activityLog);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate modificata, %s!', $this->getUser())

            );

            return $this->redirectToRoute('user_activity_list');
        }


        return $this->render('activity/edit.html.twig', [
            'activityForm' => $form->createView(),
            'user_is_owner' => $bool,
            'user_is_mentainance_boss' => $bool_mentainance_boss
        ]);

    }

    /**
 * @Route("/activity/{activityLogId}/owner/{ownerId}", name="owner_activity_remove")
 * @Method("DELETE")
 */
    public function removeOwnerFromLogAction($activityLogId, $ownerId)
    {
        $em = $this->getDoctrine()->getManager();
        $activityLog = $em->getRepository('App:ActivityLog')
            ->find($activityLogId);
        if(!$activityLog){
            throw $this->createNotFoundException('Acest log nu a fost gasit');
        }
        $owner = $em->getRepository('App:Owner')
            ->find($ownerId);
        if(!$owner){
            throw $this->createNotFoundException('Acest proprietar nu a fost gasit');
        }

        $activityLog->removeOwner($owner);
        $em->persist($activityLog);
        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/activity/{activityLogId}/property/{propertyId}", name="property_activity_remove")
     * @Method("DELETE")
     */
    public function removePropertyFromLogAction($activityLogId, $propertyId)
    {
        $em = $this->getDoctrine()->getManager();
        $activityLog = $em->getRepository('App:ActivityLog')
            ->find($activityLogId);


        if (!$activityLog) {
            throw $this->createNotFoundException('Acest log nu a fost gasit');

        }

        $property = $em->getRepository('App:Property')
            ->find($propertyId);

        $owner = $property->getOwner();

        if (!$property) {
            throw $this->createNotFoundException('Acest proprietar nu a fost gasit');
        }

        $activityLog->removeProperty($property);

        $bool = true;

        $remainingProperties = $activityLog->getProperty();
        foreach ($remainingProperties as $remainingProperty) {
            if ($remainingProperty->getOwner() === $property->getOwner()) {
                $bool = false;
            }
        }
        if ($bool){
            $activityLog->removeOwner($owner);
        }
        $em->persist($activityLog);
        $em->flush();

        return new Response(null, 204);
    }
}