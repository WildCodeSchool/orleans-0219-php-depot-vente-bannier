<?php


namespace App\Controller;

use App\Model\CardManager;

class CardController extends AbstractController
{

    /**
     * Display product
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {

        $cardManager = new CardManager();
        $products = $cardManager -> selectAll();
        return $this->twig->render('Item/_card.html.twig', ['products' => $products]);
    }
}
