<?php


namespace App\Model;

class CardManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'product';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllProduct()
    {
        $stmt = $this->pdo->query("SELECT *
                                            FROM bannier.product
                                            JOIN picture ON product.id = picture.product_id");
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}
