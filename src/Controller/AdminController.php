<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoriesManager;

class AdminController extends AbstractController
{

    /**
     * Display categories administration page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function categories()
    {
        $categoriesManager = new CategoriesManager();
        $categories = $categoriesManager -> selectAll();
        return $this->twig->render('Admin/categories.html.twig', ['categories' => $categories]);
    }
}
