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
use App\utils\CleanData;

class ProductController extends AbstractController
{
    /**
     *
     * Return product page filter by category or All categories
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllByAsc();
        $products = null;
        $id = $_GET['category'] ?? null;
        $search = $_GET['request'] ?? null;
        $sort = $_GET['sortBy'] ?? null;
        $productManager = new ProductManager();
        $products = $productManager->productsFiltered($id, $search, $sort);

        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products]);
    }
}
