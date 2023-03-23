<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;

use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/api/book', name: 'app_api', methods:["GET"])]
    public function index(BookRepository $book, SerializerInterface $serializer)
    {
        $livre = $book->findAll();
        //$json=json_encode($livre);
        //dd($json);
       $json= $serializer->serialize($livre, "json", ['groups'=>'book:read']);
        //return $this->json($book->findAll(), 200, [], ['groups'=>'book:read']);
        //dd($json);
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
            //dd($jsonRecu);
            //$response = new JsonResponse($json, 200, [], true);
            //return $response;
            return $this->json($post, 201, ['groups' => 'post:read']);
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message'=>$e->getMessage()
            ], 400);
        }
    
    }
}
