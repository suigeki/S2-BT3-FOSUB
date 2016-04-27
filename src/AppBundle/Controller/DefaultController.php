<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    /*public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }*/
    
    /**
     * On remplace la déclaration Route("/", name="homepage") dans le controlleur 
     * par une déclaration au sein du fichier routing.yml
     * Il n'y a aucune condition d'accès à cette page
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('homepage.html.twig');
    }
    
    /**
     * //return \symfony\Component\HttpFoundation\Response
     * 
     * Route("/admin/", name="admin_page")
     * @Route("/admin/", name="admin_page")
     * Pointe sur la même route indiquée dans le fichier app/config/security.yml dans la rubrique access_control
     * - {path: ^/admin/, role: ROLE_ADMIN}
     * Cela signifie que pour avoir accès à une URL contenant admin, on doit avoir le rôle ROLE_ADMIN
     * 
     */
    public function adminPageAction()
    {
        // replace this example code with whatever you need
        /*return $this->render('auth/homepage.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
        return $this->render('admin.html.twig');
    }
    
    /**
     * @Route("/client/", name="client_page")
     * Il n'y a aucune condition d'accès à cette page
     */
    public function clientPageAction()
    {
        
        return $this->render('client.html.twig');
    }
    
    /**
     * @Route("/login_ok", name="login_ok")
     * 
     * On sécurise l'accès à la page /login_ok. On aurait pu utiliser le fichier security.yml pour cela
     * et rajouter une condition supplémentaire dans access_control: ou utiliser la ligne suivante
     * qui attribue un role 
     * @Security("has_role('ROLE_USER')")
     */
    public function showInfoUserAction(){
        return $this->render('login_success.html.twig');
    }
    
    /**
     * @Route("/user", name="user_info")
     * 
     * Pour accéder à la méthode, l'utilisateur doit être connecté peut importe son rôle
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showUserAction(){
        
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            //Si la personne est connectée avec le rôle ROLE_ADMIN, on retourne
            return $this->render('admin.html.twig');
        }elseif ($this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            //Si la personne est connectée avec le rôle ROLE_USER, on retourne
            return $this->render('client.html.twig');
        }else{
            //En cas d'autres profils de connexion
        }
    }
    
    /**
     * @Route("/who-is-user", name="user_question")
     * 
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function determineUser(){
        return $this->render('user.html.twig');
    }    
}
