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
class ProductManager extends AbstractManager
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

    /**
     * Get all row from all the tables with join.
     *
     * @return array
     */
    public function showAllWithCategories(): array
    {
        $query = "SELECT product.id, 
                    product.name, 
                    product.price, 
                    product.date_added, 
                    product.date_saled, 
                    ahead, 
                    category.name as categories 
                    FROM $this->table 
                    inner join bannier.category 
                    on product.categories_id = category.id 
                    order by category.name ASC, product.name ASC;";
        return $this->pdo->query($query)->fetchAll();
    }
}
