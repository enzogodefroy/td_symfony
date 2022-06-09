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
use App\Entity\Basket;
use App\Entity\BasketDetail;
use App\Entity\Timeslot;
use PDO;
use DateTime;


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

    #[Route('/command/{idCommand}', name: 'command')]
    public function getCommand(ManagerRegistry $doctrine, int $idCommand) : Response
    {
        // Get command and goes to commanddetails
        // $command = $doctrine->getRepository(Command::class)->find($idCommand);
        // $command = $command->getDetails();

        // Get only commanddetails for commandId
        $command = $doctrine->getRepository(CommandDetail::class)->findBy(['command' => $idCommand]);

        if (!$command) {
            throw $this->createNotFoundException(
                'No command found for id '.$idCommand
            );
        }

        return $this->render('command/show_command.html.twig', ['commands' => $command]);
    }

    #[Route('/validateCommandDetail', name: 'validateCommandDetail')]
    public function validateCommandDetail(ManagerRegistry $doctrine) : RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $product = $_POST['product'];
        $command = $_POST['command'];

        $commanddetail = $doctrine->getRepository(CommandDetail::class)->findOneBy(['command' => $command, 'product' => $product]);

        if (!$commanddetail) {
            throw $this->createNotFoundException(
                'No command found for id '.$command
            );
        }

        $commanddetail->setPrepared(true);
        $entityManager->persist($commanddetail);
        $entityManager->flush();

        return $this->redirectToRoute('command', ['idCommand' => $command]);
    }

    #[Route('/basketsByUser/{idUser}', name: 'basketsByUser')]
    public function getUserBaskets(ManagerRegistry $doctrine, Int $idUser) : Response
    {
        $baskets = $doctrine->getRepository(Basket::class)->findBy(['iduser' => $idUser]);

        if (!$baskets) 
        {
            throw $this->createNotFoundException(
                'No basket found for id '.$idUser
            );
        }

        return $this->render('baskets/show_baskets.html.twig', ['baskets' => $baskets]);
    }

    #[Route('/basketDetail/{idBasket}', name: 'basketDetail')]
    public function getBasketDetail(ManagerRegistry $doctrine, Int $idBasket) : Response
    {
        $basket = $doctrine->getRepository(BasketDetail::class)->findBy(['basket' => $idBasket]);

        if (!$basket) 
        {
            return $this->render('baskets/show_basket_detail.html.twig', ['basket' => Array()]);
        }

        return $this->render('baskets/show_basket_detail.html.twig', ['basket' => $basket]);
    }

    #[Route('/chooseTimeslot/{idBasket}', name: 'chooseTimeslot')]    
    public function chooseTimeslot(ManagerRegistry $doctrine, Int $idBasket) : Response
    {
        $timeslots = $doctrine->getRepository(Timeslot::class)->findBy(['full' => 0, 'expired' => 0]);

        return $this->render('timeslot/show_timeslots.html.twig', ['timeslots' => $timeslots, 'idBasket' =>$idBasket]);
    }

    #[Route('/basketValid', name: 'basketValid')]
    public function validBasket(ManagerRegistry $doctrine) : RedirectResponse
    {
        $idBasket = $_POST['idBasket'];
        $idTimeslot = $_POST['idTimeslot'];

        $basketDetails = $doctrine->getRepository(BasketDetail::class)->findBy(['basket' => $idBasket]);
        $timeslot = $doctrine->getRepository(Timeslot::class)->findOneBy(['id' => $idTimeslot]);

        if (!$basketDetails) 
        {
            throw $this->createNotFoundException(
                'No basket found for id '.$idBasket
            );
        }

        $entityManager = $doctrine->getManager();

        $command = new Command();
        $basket = $basketDetails[0]->getBasket();

        $command->setIduser($basket->getIduser());
        $command->setDatecreation(new DateTime('now'));
        $command->setStatus('preparation');
        $command->setAmount(0);
        $command->setTopay(0);
        $command->setItemsnumber(0);
        $command->setMissingnumber(0);
        $command->setIdtimeslot($timeslot);

        $entityManager->persist($command);
        $entityManager->flush();

        for ($i = 0; $i < count($basketDetails); $i++)
        {
            $product = $basketDetails [$i]->getProduct();
            $quantity = $basketDetails [$i]->getQuantity();

            $commanddetail = new CommandDetail();
            $commanddetail->setQuantity($quantity);
            $commanddetail->setPrepared(false);
            $commanddetail->setProduct($product);
            $commanddetail->setCommand($command);

            $entityManager->persist($commanddetail);
            $entityManager->remove($basketDetails [$i]);
        }

        $userId = $basket->getIduser()->getId();
        $entityManager->remove($basket);
        $entityManager->flush();

        return $this->redirectToRoute('basketsByUser', ['idUser' => $userId]);
    }
}