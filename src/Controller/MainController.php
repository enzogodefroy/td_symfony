<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;
use App\Entity\Command;
use App\Entity\CommandDetail;


class MainController extends AbstractController
{
    #[Route('/product/{id}', name: 'product')]
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

    #[Route('/command/{id}', name: 'command')]
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

    #[Route('/command_byId/{idCommand}', name: 'command_byId')]
    public function getCommand(ManagerRegistry $doctrine, int $idCommand) : Response
    {
        $command = $doctrine->getRepository(CommandDetail::class)->findBy(['command' => $idCommand]);

        if (!$command) {
            throw $this->createNotFoundException(
                'No command found for id '.$idCommand
            );
        }

        return $this->render('command/show_command_test.html.twig', ['commands' => $command]);
    }

    #[Route('/validateCommandDetail', name: 'validateCommandDetail')]
    public function setCommandDetail(ManagerRegistry $doctrine) : RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $product = $_POST['product'];
        $command = $_POST['command'];

        $commanddetail = $doctrine->getRepository(CommandDetail::class)->findOneBy(['command' => $command, 'product' => $product]);
        $commanddetail->setPrepared(true);

        if (!$commanddetail || !$product) {
            throw $this->createNotFoundException(
                'No command found for id '.$command
            );
        }

        $entityManager->persist($commanddetail);
        $entityManager->flush();

        return $this->redirectToRoute('command_byId', ['idCommand' => $command]);
    }
}