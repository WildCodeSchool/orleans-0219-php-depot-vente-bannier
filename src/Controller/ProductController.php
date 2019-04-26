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
     * Return product page filter by category or All categories
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showCategory(int $id = 0)
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        if ($id === 0) {
            $productManager = new ProductManager();
            $products = $productManager->showAllWithPictures();
        } else {
            $productManager = new ProductManager();
            $products = $productManager->productsFilteredByCategories($id);
        }
        return $this->twig->render('Products/index.html.twig', ['categories' => $categories,
            'products' => $products,]);
    }
}
