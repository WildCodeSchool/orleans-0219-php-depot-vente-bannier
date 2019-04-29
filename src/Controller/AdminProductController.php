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
use App\Model\PictureManager;
use App\utils\CleanData;
use DateTime;

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
        $products = $productManager->showAllWithCategories();
        return $this->twig->render('Admin/products.html.twig', ['products' => $products]);
    }

    /**
     * return adding products page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllByAsc();
        $data = [];
        $errors = [];
        $filesToInsert = [];
        $maxPictures = 8;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validCategories = array_column($categories, 'id');
            $cleanData = new CleanData();
            $data = $cleanData->dataCleaner($_POST);


            if (!empty($_FILES['upload']['name'][0])) {
                if (count($_FILES['upload']['name']) <= $maxPictures) {
                    $files = $_FILES['upload'];
                    $pictureManager = new PictureManager();
                    $filesToInsert = $pictureManager->upload($files);
                } else {
                    $errors['picture'] = "$maxPictures photos maximum";
                }
            }
            if (empty($data['name'])) {
                $errors['name'] = 'Veuillez indiquer le nom du produit';
            }
            if (empty($data['categories_id']) || !in_array($data['categories_id'], $validCategories)) {
                $errors['categories_id'] = 'Veuillez choisir une categorie';
            }
            if (empty($data['description'])) {
                $errors['description'] = 'veuillez donner une description au produit';
            }
            if (empty($data['price']) || $data['price'] < 0) {
                $errors['price'] = 'veuillez donner un prix au produit';
            }
            if (empty($data['date_added'])) {
                $errors['date_added'] = 'veuillez choisir une date';
            } else {
                $date = DateTime::createFromFormat('Y-m-d', $data['date_added']);
                if ($date === false) {
                    $errors['date_added'] = 'Veuillez choisir une date';
                }
            }
            if (isset($data['ahead'])) {
                $data['ahead'] = 1;
            } else {
                $data['ahead'] = 0;
            }

            if (empty($errors)) {
                $productManager = new ProductManager();
                $idNewProduct = $productManager->insert($data);
                $pictureManager = new PictureManager();
                $pictureManager->insert($idNewProduct, $filesToInsert);
                header('location: /AdminProduct/confirmAdding');
            }
        }
        return $this->twig->render('Admin/add.html.twig', ['categories' => $categories,
            'data' => $data, 'errors' => $errors,]);
    }


    /**
     * confirm product as been added in BDD
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function confirmAdding()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllByAsc();
        return $this->twig->render('Admin/add.html.twig', ['categories' => $categories, 'post' => true]);
    }

    /**
     *
     * Delete product from bdd
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $pictureManager = new PictureManager();
            $pictureManager->delete($id);
            $productManager = new ProductManager();
            $productManager->delete($id);
            header('location: /adminProduct/list');
        }
    }
}
