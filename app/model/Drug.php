<?php

namespace Models;


class Drug extends DBtable {

    public static $tableName = "Drug";

    public function sortByTimeNewest() {
        return $this->getAllActive()->order('Time_created DESC')->limit(4);
    }

}