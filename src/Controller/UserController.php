<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/favorites', name: 'app_user_favorites', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function showFavorites(
        UserInterface $user,
        UserRepository $userRepository
    ): Response {
        $userFavorite = $userRepository->findOneBy(
            ['id' => $user]
        );

        $favorites = [];
        $favorites = $userFavorite->getFavorites();

        return $this->render('user/favorites.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
