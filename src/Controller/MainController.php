<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;
use App\Entity\Command;

class MainController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function showProduct(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('product/show_product.html.twig', ['product' => $product]);
    }

    #[Route('/command/{id}', name: 'command_show')]
    public function showCommand(ManagerRegistry $doctrine, int $id): Response
    {
        $command = $doctrine->getRepository(Command::class)->find($id);

        if (!$command) {
            throw $this->createNotFoundException(
                'No command found for id '.$id
            );
        }

        return $this->render('command/show_command.html.twig', ['command' => $command]);
    }
}
