<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.08.2018
 * Time: 14:27
 */

namespace App\Controller;
use App\Form\UserRegistrationForm;
use App\Service\HashPasswordListener;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    private $listener;

    public function __construct(HashPasswordListener $listener)
    {
        $this->listener = $listener;
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);




        if($form->isSubmitted()) {
            if ($form->isValid()) {
                /**@var \App\Entity\Staff $staff */
                $user = $form->getData();
                $this->listener->encodePassword($user);
                $user->setRoles(['ROLE_ADMIN']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Welcome ' . $user->getEmail());
                return $this->redirectToRoute('admin_home');
            }
        }

        return $this->render('user/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}