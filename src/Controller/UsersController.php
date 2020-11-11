<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;
    
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password')
            ))
            ->add('save', SubmitType::class, ['label' => 'Click Here'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $password = $encoder->encodePassword($user, $user->getPassword());
           // $user->setPassword($password);
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
                $this->addFlash('success', 'User Added Successfully!');
            return $this->redirectToRoute('users');
           // dd($data);
        }
        
        // return $this->render('users/index.html.twig', [
        //     'form' => $form->createView()
        // ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profileData(Request $request){
        echo 'Hello '.$this->getUser()->getUsername().' Welcome !!' ; 
        die;
        return $this->render('users/index.html.twig', [
            'profile' => $this->getUser()->getUsername()
        ]);
    }

}
