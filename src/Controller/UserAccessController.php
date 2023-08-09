<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user_access')]
    public function index(ProductRepository $productRepo): Response
    {
        // $user = $this->getUser();

        return $this->render('user_access/index.html.twig', [
            'products' => $productRepo->findAll()
        ]);
    }

    #[Route('user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('show.html.twig', [
            'product' => $product,
        ]);
    }

    // #[Route('/profile', name: 'app_user_profile', methods: ['GET'])]
    // public function profile(Product $product): Response
    // {
    //     $user = $this->getUser();

    //     return $this->render('profile/profile.html.twig', [
    //         'product' => $product,
    //         'user' => $user,
    //     ]);
    // }

    /**
     * @Route("/edit-profile", name="edit_profile")
     */

    #[Route('/profile', name: 'profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, ManagerRegistry $doctrine): Response

    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_user_access');
        }

        return $this->render('profile/profile.html.twig', [
            'editForm' => $form->createView(),
        ]);
    }
}
