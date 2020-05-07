<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\User;
use App\Entity\Userpost;
use Doctrine\ORM\EntityManagerInterface;

class PublicController extends AbstractController
{
    public function home()
    {
        $number = random_int(0, 100);

        return $this->render('home.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'site_title' => 'MaFaBlogXY',
            'site_page' => 'Présentation',
            'site_desc' => 'MaFaBlogXY est une plateforme pour créer des blogs sous forme d\'appartement !',
            'notifications' => false,
        ]);
    }

    public function contact()
    {
        $number = random_int(0, 100);

        return $this->render('home.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'site_title' => 'MaFaBlogXY',
            'site_page' => 'A propos',
            'notifications' => false,
        ]);
    }

    public function list()
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found'
            );
        }

        return $this->render('home.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'site_title' => 'MaFaBlogXY',
            'site_page' => 'Liste des MaFaBloggers',
            'notifications' => true,
            'users' => $user,
        ]);
    }

    public function profile($id, Request $request)
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);

        $userposts = $this->getDoctrine()
        ->getRepository(Userpost::class)
        ->findBy(
            ['id_user' => $id]
        );

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found'
            );
        }

        if (!$userposts) {
            $userposts = array();
        }

        // creates a user object and initializes some data for this example
        $userpost = new Userpost();

        $form1 = $this->createFormBuilder($userpost)
            ->add('message', TextType::class)
            ->add('id_user', HiddenType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Post'])
            ->getForm();

        $form1->get('id_user')->setData($id);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $userpost = $form1->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userpost);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute("profile", array('id'=>$id));
        }

        return $this->render('home.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'site_title' => 'MaFaBlogXY',
            'site_page' => 'MaFaBlogger',
            'notifications' => true,
            'user' => $user,
            'userposts' => $userposts,
            'form1' => $form1->createView(),
        ]);
    }

    public function new(Request $request)
    {
        // creates a user object and initializes some data for this example
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('user', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Account'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home.html.twig', [
            'form' => $form->createView(),
            'site_title' => 'MaFaBlogXY',
            'site_page' => 'Create Account',
            'notifications' => false,
        ]);
    }

}