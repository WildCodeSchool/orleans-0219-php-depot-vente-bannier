<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProductManager;

class AdminProductController extends AbstractController
{

    /**
     * Display products administration page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list()
    {
        $productManager = new ProductManager();
        $products = $productManager -> showAllWithCategories();
        return $this->twig->render('Admin/products.html.twig', ['products' => $products]);
    }
}
