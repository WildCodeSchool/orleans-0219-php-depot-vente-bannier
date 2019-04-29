<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class NotreBoutiqueController extends AbstractController
{

    public function index()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAllByAsc();

        $productManager = new ProductManager();
        $products= $productManager->showAhead();

        return $this->twig->render('NotreBoutique/index.html.twig', ['categories' => $categories,
            'products' => $products]);
    }
}
