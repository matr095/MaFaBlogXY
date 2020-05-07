<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
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

}