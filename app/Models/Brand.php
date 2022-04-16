<?php

namespace App\Models;

use Nette\Database\Explorer;
use Nette\PhpGenerator\Literal;

/**
 * Brand class
 */
class Brand
{
    /**
     * TABLE name in mySql database
     *
     * @var string
     */
    public const TABLE = 'brands';

    /**
     * Database connection
     *
     * @var Explorer
     */
    protected Explorer $database;

    /**
     * Brand id - Primary key
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Brand name - unique
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * __cnstruct for Brand
     *
     * @param Explorer $database
     * 
     */
    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    /**
     * Save Brand object to database
     *
     * @return void
     * 
     */
    public function save(): void
    {
        $table = $this->database->table(self::TABLE);
        if ($this->id === null) {
            $this->id = $table->insert(['name' => $this->name])->id;
        } else {
            $table->where('id', $this->id)->update(['name' => $this->name, 'update_at' => $this->database::literal('NOW()')]);
        }
    }

    /**
     * Delete Brand from database
     *
     * @return void
     * 
     */
    public function delete(): void
    {
        $this->database->table(self::TABLE)->where('id', $this->id)->delete();
    }

    /**
     * Validate brand name before save
     *
     * @return string|null
     * 
     */
    public function validate(): ?string
    {
        if (!$this->name) {
            return 'Značka musí být vyplněna.';
        }
        if ($this->database->table(self::TABLE)->where('id != ? AND name = ?', ($this->id ?: 0), $this->name)->count()) {
            return 'Zadaná značka už existuje.';
        }
        return null;
    }
}