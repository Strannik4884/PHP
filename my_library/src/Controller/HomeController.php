<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        // get all Book objects
        $dql = "SELECT b FROM App\Entity\Book b";
        $query = $em->createQuery($dql);
        // set default sort and  direction properties
        $request->query->set('sort', 'b.dateRead');
        $request->query->set('direction', 'desc');
        // get page number
        $page_number = $request->query->getInt('page', 1);
        // set correct pager number
        if ($page_number < 1) {
            $page_number = 1;
        }
        // paginate
        $pagination = $paginator->paginate(
            $query,
            $page_number,
            4
        );
        // render view
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
            'pagination' => $pagination,
        ]);
    }
}
