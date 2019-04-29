<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;


/**
 *
 */
class PictureManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'picture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM $this->table WHERE `product_id`=$id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    /**
     * Upload product's pictures in DIR
     * @param array $files
     * @return array
     */
    public function upload(array $files): array
    {
        $uploadDir = 'assets/products/pictures';
        $allowed = ['png', 'jpg', 'gif'];
        $sizeMax = 10000000;
        $filesToInsert = [];

        foreach ($files['name'] as $position => $file_name) {
            $fileSize = $files['size'][$position];
            $fileExt = explode('.', $file_name);
            $fileExt = strtolower(end($fileExt));
            $fileTmp = $files['tmp_name'][$position];
            $fileNameNew = uniqid() . '.' . $fileExt;
            $fileDestination = $uploadDir . $fileNameNew;
            if (in_array($fileExt, $allowed)) {
                if ($fileSize <= $sizeMax) {
                    (move_uploaded_file($fileTmp, $fileDestination));
                }
            }
            array_push($filesToInsert, $fileDestination);
        }
        return $filesToInsert;
    }

    /**
     * Insert pictures path for new products in BDD
     *
     * @param int $id
     * @param array $filesToInsert
     */
    public function insert(int $id, array $filesToInsert)
    {
        $query = "INSERT INTO $this->table (`name`, `product_id`)
                      VALUES (:name, :product_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('product_id', $id);
        foreach ($filesToInsert as $key => $file) {
            $statement->bindValue('name', $file);
            $statement->execute();
        }
    }
}
