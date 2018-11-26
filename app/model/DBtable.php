<?php

namespace Models;

use Nette\Database\Context;
/*use Nette\Database\Table\Selection;*/

abstract class DBtable {

    public $database;
    public static $tableName;

    public function __construct(Context $db)
    {
        $this->database = $db;
    }

    public function getTable() {
        return $this->database->table(static::$tableName);
    }

    public function getAll() {
        return $this->getTable();
    }

    public function getByID($id) {
        return $this->getTable()->get($id);
    }

    public function insert(array $array) {
        return $this->getTable()->insert($array);
    }

    public function count() {
        return $this->getTable()->count();
    }
}