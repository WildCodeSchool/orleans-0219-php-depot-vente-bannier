<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\CategoryManager;
use App\utils\CleanData;

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

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanData = new CleanData();
            $category = implode($cleanData->dataCleaner($_POST));

            if (empty($category)) {
                $errors = 'Veuillez donner un nom à votre catégorie';
            }
            if (strlen($category) > 255) {
                $errors = 'Veuillez limiter le nom de votre catégorie à 255 charactère maximum';
            }
            if (!isset($errors)) {
                $categoryManager = new CategoryManager();
                $categoryManager->insert($category);
                header('location: /adminCategory/list');
            } else {
                $categoryManager = new CategoryManager();
                $categories = $categoryManager->selectAllByAsc();
                return $this->twig->render('Admin/categories.html.twig', ['categories' => $categories,
                    'errors' => $errors]);
            }
        }
    }
}
