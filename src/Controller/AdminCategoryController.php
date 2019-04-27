<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoryManager;

class AdminCategoryController extends AbstractController
{
    /**
     * Display categories administration page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager -> selectAllByAsc();
        return $this->twig->render('Admin/categories.html.twig', ['categories' => $categories]);
    }
}
