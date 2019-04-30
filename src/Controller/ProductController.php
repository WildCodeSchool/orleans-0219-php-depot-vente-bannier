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

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['category'])) {
            $id = $_GET['category'];
            $productManager = new ProductManager();
            $products = $productManager->productsFilteredByCategories($id);
            $categorySelected = $categoryManager->selectOneById($id);
            return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
                'products' => $products,'category' => $categorySelected]);
        }

        $productManager = new ProductManager();
        $products = $productManager->showAllWithPictures();

        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products,]);
    }

    /**
     *
     * Return product page sorted by price or date
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sort($id)
    {
        $categories = null;
        $products = null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($_GET['price_asc']) {
                $categoryManager = new CategoryManager();
                $categories = $categoryManager->selectOneById($id);

                $productManager = new ProductManager();
                $products = $productManager->sortProductsAscPrice();
            }
        }
        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products,]);
    }
}
