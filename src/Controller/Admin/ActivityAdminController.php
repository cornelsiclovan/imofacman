<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.08.2018
 * Time: 10:23
 */

namespace App\Controller\Admin;
use App\Entity\ActivityLog;
use App\Entity\Owner;
use App\Entity\Property;
use App\Form\OwnerForm;
use App\Form\PropertyForm;
use App\Repository\ActivityLogRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    
    /**
     * @Route("/property/list", name="admin_property_list")
     */
    public function listProperty(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Property::class);
        $properties = $repository->findAll();
        return $this->render(
            'admin/property/list.html.twig',[
                'properties' => $properties,
            ]
        );
    }

    /**
     * @Route("/property/new", name="admin_property_new")
     */
    public function newProperty(Request $request)
    {
        $form = $this->createForm(PropertyForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $property = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Proprietate adaugata!, %s', $this->getUser()->getUserName())
            );
            return $this->redirectToRoute('admin_property_list');
        }

        return $this->render(
          'admin/property/new.html.twig',[
          'propertyForm' => $form->createView()
          ]
        );
    }

    /**
     * @Route("/property/{id}/edit", name="admin_property_edit")
     */
    public function editProperty(Request $request, Property $property)
    {
        $form = $this->createForm(PropertyForm::class, $property);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $property = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Proprietate modificata, %s!', $this->getUser())

            );

            return $this->redirectToRoute('admin_property_list');
        }

        return $this->render(
            'admin/property/edit.html.twig',[
                'propertyForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/owner/list", name="admin_owner_list")
     */
    public function listOwner(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Owner::class);
        $owners = $repository->findAll();
        return $this->render(
            'admin/owner/list.html.twig',[
                'owners' => $owners,
            ]
        );
    }

    /**
     * @Route("/owner/new", name="admin_owner_new")
     */
    public function newOwner(Request $request)
    {
        $form = $this->createForm(OwnerForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $owner = $form->getData();

            $owner->setSlug($owner->getName().'-'.rand(1,100000));
            $em = $this->getDoctrine()->getManager();
            $em->persist($owner);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Proprietar adaugat!, %s', $this->getUser()->getUserName())
            );
            return $this->redirectToRoute('admin_owner_list');
        }

        return $this->render(
            'admin/owner/new.html.twig',[
                'ownerForm' => $form->createView()
            ]
        );
    }
    /**
     * @Route("/owner/{id}/edit", name="admin_owner_edit")
     */
    public function editOwner(Request $request, Owner $owner)
    {
        $form = $this->createForm(OwnerForm::class, $owner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $owner = $form->getData();

            $owner->setSlug($owner->getName().'-'.rand(1,100000));
            $em = $this->getDoctrine()->getManager();
            $em->persist($owner);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Proprietar modificat!, %s', $this->getUser()->getUserName())
            );
            return $this->redirectToRoute('admin_owner_list');
        }

        return $this->render(
            'admin/owner/edit.html.twig',[
                'ownerForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/statistics/{id}", name="admin_activity_per_owner_list")
     */
    public function listOwnerActivity(EntityManagerInterface $em, Owner $owner, OwnerRepository $repository)
    {
        $owner = $repository->findOneBy(['id' => $owner]);

        $properties = $owner->getProperties();

        return $this->render(
            'admin/statistics/list.html.twig', [
                'owner' => $owner,
                'properties' => $properties
            ]
        );
    }
}