<?php

namespace Application\Model;

class Base
{
    public function __construct($db_adapter){
        $this->db = $db_adapter;
    }

    public function query($sql){
        return $this->db->query($sql)->execute();
    }

    public function fetchAll($sql){
        return $this->query($sql)->getResource()->fetchAll();
    }

    public function getList(){
        return $this->fetchAll("SELECT * FROM {$this->table}");
    }
}