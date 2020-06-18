<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookEditType;
use App\Form\BookType;
use App\Repository\BookRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     * @param Request $request
     * @param Security $security
     * @return Response
     */
    public function new(Request $request, Security $security): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setCreatedBy($security->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Book $book
     * @param Security $security
     * @return Response
     */
    public function edit(Request $request, Book $book, Security $security): Response
    {
        // check current user
        if($book->getCreatedBy() !== $security->getUser()){
            return $this->redirect($this->generateUrl('home'));
        }

        $form = $this->createForm(BookEditType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/read", name="book_read", methods={"GET"})
     * @param Book $book
     * @return Response
     * @throws Exception
     */
    public function read(Book $book): Response
    {
        $book->setDateRead(new DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        $response = new BinaryFileResponse('../public/uploads/books/' . $book->getBookFileName());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }

    /**
     * @Route("/{id}/delete", name="book_delete", methods={"DELETE"})
     * @param Request $request
     * @param Book $book
     * @param Security $security
     * @return Response
     */
    public function delete(Request $request, Book $book, Security $security): Response
    {
        // check current user
        if($book->getCreatedBy() !== $security->getUser()){
            return $this->redirect($this->generateUrl('home'));
        }

        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
