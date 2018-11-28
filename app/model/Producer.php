<?php

namespace Models;


class Producer extends DBtable {

    public static $tableName = "producer";

    public function sortByTime() {
        return $this->getTable()->order('');
    }

}