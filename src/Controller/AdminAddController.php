<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\AdminAddController;

use App\Controller\AbstractController;
use App\Model\ProductManager;
use App\Model\CategoryManager;

class AdminAddController extends AbstractController
{
    /**
     * Display categories administration page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAll();
        return $this->twig->render('Admin/categories.html.twig', ['categories' => $categories]);
    }
}
