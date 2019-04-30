<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class OurStoreController extends AbstractController
{

    public function index()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAllByAsc();

        $productManager = new ProductManager();
        $products= $productManager->showAhead();

        return $this->twig->render('OurStore/index.html.twig', ['categories' => $categories,
            'products' => $products]);
    }
}
