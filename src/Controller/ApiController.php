<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Borrow;
use App\Entity\Box;
use App\Entity\User;
use App\Repository\BookRepository;

use App\Repository\BoxRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
   
    #[Route('/api/book/{search}', name: 'api_search', methods:["GET"])]
    public function pie(BookRepository $book, SerializerInterface $serializer, Request $request, $search): Response
    {
        $livre = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findOneBy(["title" => $search]);

        $json= $serializer->serialize($livre, "json", ['groups'=>'book:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
    #[Route('/api/book', name: 'api', methods:["GET"])]
    public function pipi(BookRepository $book, SerializerInterface $serializer)
    {
        $livre = $book->findAll();

        $json= $serializer->serialize($livre, "json", ['groups'=>'book:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
    
    #[Route('/api/book', name: 'app_api', methods:["POST"])]
    public function creat(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {

        $jsonRecu= $request->getContent();
        try{
            
            $post = $serializer->deserialize($jsonRecu, Book::class, 'json');
            //$book->setCreatedAt(new \DateTime());

            $errors=$validator->validate($post);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $em->persist($post);
            $em->flush();

            return $this->json($post, 201, ['groups' => 'post:read']);
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message'=>$e->getMessage()
            ], 400);
        }
    
    }
    // box
    #[Route('/api/box', name: 'api', methods:["GET"])]
    public function pi(BoxRepository $box, SerializerInterface $serializer)
    {
        $boite = $box->findAll();

        $json= $serializer->serialize($boite, "json", ['groups'=>'book:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
    #[Route('/api/box/{idBox}', name: 'getBoxId', methods:["GET"])]
    public function pip(BoxRepository $box, Request $request, SerializerInterface $serializer, $idBox)
    {
        $carte = $this->getDoctrine()
                ->getRepository(Box::class)
                ->findOneBy(["id" => $idBox]);

        $json= $serializer->serialize($carte, "json", ['groups'=>'book:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
    
    #[Route('/api/box/{id}', name: 'app_api_id', methods:["GET"])]
    public function crea($id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {

        try {
            $box = $this->getDoctrine()
                ->getRepository(Box::class)
                ->findOneBy(["id" => $id]);
                if (!$box) {
                    return $this->json(["error" => " Utilisateur inexistant"], 201);
                } 
                $json = $serializer->serialize($box, 'json', ['groups' => 'book:read']);
                $response = new Response($json, 200, ["Content-Type" => "application/json"]);
                return $response;
            } catch (NotEncodableValueException $e) {
                    return $this->json([
                        'staut' => 400,
                        'message' => $e->getMessage()
                    ], 400);
                }
    }
    // 
    #[Route('/api/v1/user/login', name: 'app_api', methods:["POST"])]
    public function retourn(SerializerInterface $serializer, Request $request): Response
    {

        $uuid = $request->get("uuid");
        try {
            $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(["uuid" => $uuid]);
            if (!$users) {
                return $this->json(["error" => " Utilisateur inexistant"], 201);
            }

            $json = $serializer->serialize($users, 'json', ['groups' => 'user:read']);
            $response = new Response($json, 200, ["Content-Type" => "application/json"]);
            return $response;
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'staut' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/api/v1/books/{id_book}/borrowBook', name: 'post_books_borrow', methods: ["POST"])]
    public function gdg($id_book, SerializerInterface $serializer, Request $request, BookRepository $bookRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
     
        $book = $bookRepository->find($id_book);
        $userId = $request->get("id");
        $user = $userRepository->find($userId);
        $borrow = new Borrow();
        $date = new DateTime();
        
        if ($book->isAvailable) {
            $borrow->addBook($book);
            $borrow->setIdUser($user);
            $borrow->setDateBorrow($date);
            $book->setIsAvailable(false);
            $em->persist($borrow);
            $em->flush();
            return $this->json(["Message" => "Book ajouter!"]);
        }
        $borrow->setDateReturn($date);
        $book->setIsAvailable(true);
        $em->persist($borrow);
        $em->flush();
        return $this->json(["Message" => "Book returned!"]);
    
}

    /*  #[Route('/qrcode', name: 'app_qrcode')]
    public function qrcode(BuilderInterface $customQrCodeBuilder)
{
    $result = $customQrCodeBuilder
        ->size(400)
        ->margin(20)
        ->build();
    $response = new QrCodeResponse($result);
    dd($response);
}*/
  
}
