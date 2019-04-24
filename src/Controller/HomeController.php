<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAll();

        $productManager = new ProductManager();
        $products= $productManager->showAllWithPictures();

        return $this->twig->render('Home/index.html.twig', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
