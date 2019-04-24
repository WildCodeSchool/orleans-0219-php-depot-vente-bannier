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

class ProductsController extends AbstractController
{
    /**
     * Display home page
     * Validate Contact form
     * Send Message to owners'email
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


        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products,]);
    }
}
