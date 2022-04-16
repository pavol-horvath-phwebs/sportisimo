<?php

namespace App\Factories;

use App\Models\Brand;
use Nette\Database\Explorer;

/**
 * Factory for brands
 */
class BrandFactory
{
    /**
     * database connection
     *
     * @var Explorer
     * 
     */
    private Explorer $database;

    /**
     * @param Explorer $database
     * 
     */
    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    /**
     * Create new brand
     * 
     * @param string|null $name
     * 
     * @return Brand
     * 
     */
    public function create(?string $name = null): Brand
    {
        $brand = new Brand($this->database);
        $brand->name = $name;
        return $brand;
    }

    /**
     * Get list of brands by arguments
     *
     * @param int $page
     * @param int $limit
     * @param string $order
     * 
     * @return array
     * 
     */
    public function getList(int $page, int $limit, string $order): array
    {
        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'ASC';
        }
        $offset = ($page - 1) * $limit;
        $brands = [];
        $rows = $this->database->table(Brand::TABLE)->order("name {$order}")->limit($limit, $offset);
        foreach ($rows as $row) {
            $brand = new Brand($this->database);
            $brand->id = $row->id;
            $brand->name = $row->name;
            $brands[] = $brand;
        }
        return $brands;
    }

    /**
     * Get one brand by id
     *
     * @param int $id
     * 
     * @return Brand
     * 
     */
    public function get(int $id): Brand
    {
        $row = $this->database->table(Brand::TABLE)->get($id);
        $brand = new Brand($this->database);
        $brand->id = $row->id;
        $brand->name = $row->name;
        return $brand;
    }

    /**
     * Get count of pages in brandList by limit
     *
     * @param int $limit
     * 
     * @return int
     * 
     */
    public function getPagesCount(int $limit): int
    {
        $brandsCount = $this->database->table(Brand::TABLE)->count();
        $pagesCount = ceil($brandsCount / $limit);
        return $pagesCount;
    }
}