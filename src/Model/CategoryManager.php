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
class CategoryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'category';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param string $category
     * @return int
     */
    public function insert(string $category): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`) VALUES (:name)");
        $statement->bindValue('name', $category, \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
