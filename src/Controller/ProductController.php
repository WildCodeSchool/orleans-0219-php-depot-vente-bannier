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
        $categorySelected = $categoryManager->selectOneById($id);

        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products, 'category' => $categorySelected]);
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
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllByAsc();

        $name = null;
        $products = null;
        $data = null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cleanData = new CleanData();
            $data = $cleanData->dataCleaner($_GET);

            $name = $data['search_box'];

            $productManager = new ProductManager();
            $products = $productManager->selectAllByOcurrence($name);
        }
        return $this->twig->render('Products/index.html.twig', ['products' => $products,
            'categories' => $categories,'data' => $data]);
    }
}
