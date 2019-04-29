<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class FaqController extends AbstractController
{

    public function faq()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAllByAsc();

        $productManager = new ProductManager();
        $products= $productManager->showAhead();

        return $this->twig->render('Faq/index.html.twig', ['categories' => $categories,
            'products' => $products]);
    }
}
