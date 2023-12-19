<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

class AuthorController extends AbstractController
{
   protected  $authors = array(
    array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
    array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
    array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
    );


    #[Route('/author/{name}', name: 'app_author')]
    public function index($name): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showAuthor/{name}', name: 'app_showa')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            "htmlname"=>$name,
        ]);
    }

    #[Route('/showAuthors', name: 'list_author')]
    public function list(): Response
    {
        
        return $this->render('author/list.html.twig', [
            "listauthor"=>$this->authors,
        ]);
    }

    #[Route('/showAuthors/{id}', name: 'author_details')]
    public function detail($id): Response
    {
        
            $authors=$this->authors;

           for ($i = 0; $i < count($authors); $i++) {
            if ($authors[$i]['id'] == $id) {
                $detail = $authors[$i];
            }
        }
        
        return $this->render('author/detail.html.twig', [
            "detail"=> $detail
        ]);
    }

    #[Route('/showAuthorsf', name: 'list_authorf')]
    public function list1(AuthorRepository $a): Response
    {
            
       $authors=$a->findAll();

        return $this->render('author/author.html.twig', [
            "listauthor"=>$authors,
        ]);
    }


    /*#[Route('/addAuthor', name: 'list_add')]
    public function add(EntityManagerInterface $entityManager, AuthorRepository $authorRepository): Response
    {
            
       // Create a new Author entity
    $newAuthor = new Author();
    $newAuthor->setUsername('jalel hamdi'); // Set any desired properties
    $newAuthor->setEmail('jalel.hamed@gmail.com');
    $newAuthor->setId('11');


    // Use the EntityManager to persist the entity to the database
    $entityManager->persist($newAuthor);
    $entityManager->flush();

        return  new Response('<center><font color="green"><h3>Author added</h3></font></center>');
    }*/

#[Route('/addAuthorf', name: 'list_addf')]
    public function addf(): Response
    {
            
       // Create a new Author entity

        return $this->render('author/authorType.html.twig',['controller_name' => 'AuthorController']) ;
    }






 #[Route('/addAuthorf', name: 'add_author')]
    public function addAuthor(EntityManagerInterface $entityManager, AuthorRepository $authorRepository,Request $res): Response
    {
       // Create a new Author entity
     
    $newAuthor = new Author();
    $newAuthor->setUsername($res->query->get('username')); // Set any desired properties
    $newAuthor->setEmail($res->query->get('email'));
    


    // Use the EntityManager to persist the entity to the database
    $entityManager->persist($newAuthor);
    $entityManager->flush();


$username=$res->query->get('username');
$subRequest = $this->forward('App\Controller\AuthorController::list1', []);
        
return $subRequest;
    }
  
#[Route('/deleteauth/{id}',name:'delete_Auth')]
public function delete(EntityManagerInterface $entityManager, AuthorRepository $authorRepository,$id)
{  $Author= $authorRepository->find($id);
     
    $entityManager->remove($Author);
    $entityManager->flush();


    $subRequest = $this->forward('App\Controller\AuthorController::list1', []);
        
    return $subRequest;

}

#[Route('/editauthor/{id}',name:'edit_Auth')]
public function edit(EntityManagerInterface $entityManager, AuthorRepository $authorRepository,$id)
{  
    $author=$authorRepository->find($id);


   return $this->render('author/edit.html.twig',['htmlauthor'=>$author]);
}

#[Route('/editauthor',name:'edit_Authq')]
public function edituser(EntityManagerInterface $entityManager, AuthorRepository $authorRepository,Request $req)
{    $id=$req->query->get('id');
    $newAuthor=$authorRepository->find($id);
    $newAuthor->setUsername($req->query->get('username')); // Set any desired properties
    $newAuthor->setEmail($req->query->get('email'));
    $entityManager->flush();



    $subRequest = $this->forward('App\Controller\AuthorController::list1', []);
        
        return $subRequest;

}
}