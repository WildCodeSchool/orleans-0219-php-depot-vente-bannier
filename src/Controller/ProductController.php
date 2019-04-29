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

        $productManager = new ProductManager();
        $products = $productManager->showAllWithPictures();

        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products,]);
    }

    /**
     * Display ocurrences by name
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function search()
    {
        $name = null;
        $products = [];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cleanData = new CleanData();
            $data = $cleanData->dataCleaner($_GET);

            $name = $_POST['search_box'];

            $productManager = new ProductManager();
            $products = $productManager->selectAllByOcurrence($name);
        }
        return $this->twig->render('Products/index.html.twig', ['products' => $products]);
    }
}
