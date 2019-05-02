<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\Connection;
use App\utils\CleanData;
use App\Model\CategoryManager;
use App\Model\ProductManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     * Validate Contact form
     * Send Message to owners'email
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAllByAsc();


        $productManager = new ProductManager();
        $products = $productManager->showAhead();

        $data = [];
        $messageSent = false;
        $errors = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanData = new CleanData();
            $data = $cleanData->dataCleaner($_POST);

            $userEmail = $data['email'];

            $subject = $data['select_form'];

            if (empty($data['name'])) {
                $errors['name'] = '* Le champs nom est obligatoire';
            } else {
                $authorizedLengthName = 25;
                if (strlen($data['name']) > $authorizedLengthName) {
                    $errors['name'] = '* Le champs nom ne doit pas être supérieur à ' . $authorizedLengthName;
                }
            }

            if (empty($data['message'])) {
                $errors['message'] = '* Le champs message est obligatoire';
            } else {
                $authorizedLengthMessage = 800;
                if (strlen($data['message']) > $authorizedLengthMessage) {
                    $errors['message'] = '* Le champs message ne doit pas être supérieur à ' . $authorizedLengthMessage;
                }
            }

            if (empty($data['telephone'])) {
                $errors['telephone'] = '* Le champs téléphone est obligatoire';
            } else {
                if (!is_numeric($data['telephone'])) {
                    $errors['telephone'] = "* Le champs téléphone accepte seulement des chiffres";
                }
            }

            (empty($data['email'])) ? $errors['email'] = 'Le champs email est obligatoire'
                : filter_var(filter_var($data['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);

            if (empty($data['civility'])) {
                $errors['civility'] = '* Le champs civilité est obligatoire';
            }

            if (empty($data['select_form'])) {
                $errors['select_form'] = '* Le champs objet est obligatoire';
            }

            $transport = (new \Swift_SmtpTransport(
                APP_SWIFTMAILER_HOST,
                APP_SWIFTMAILER_PORT,
                APP_SWIFTMAILER_ENCRYPTION
            )
            )
                ->setUsername(APP_SWIFTMAILER_USERNAME)
                ->setPassword(APP_SWIFTMAILER_PASSWORD);

            if (empty($errors)) {
                $mailer = new \Swift_Mailer($transport);
                $message = (new \Swift_Message($subject))
                    ->setFrom($userEmail)
                    ->setTo([APP_SWIFTMAILER_USERNAME])
                    ->setBody($this->twig->render('Item/emailBody.html.twig', [
                        'data' => $data
                    ]), 'text/html');
                if ($mailer->send($message)) {
                    $messageSent = true;
                    $data = [];
                }
            }
        }
        return $this->twig->render('Home/index.html.twig', ['errors' => $errors, 'categories' => $categories,
            'products' => $products, 'messageSent' => $messageSent, 'data' => $data]);
    }
}
