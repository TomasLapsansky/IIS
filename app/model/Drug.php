<?php

namespace Models;


class Drug extends DBtable {

    public static $tableName = "Drug";

    public function sortByTimeNewest() {
        return $this->getTable()->order('Time_created DESC')->limit(4);
    }

}