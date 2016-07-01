<?php

namespace Application\Model;

class News extends Base
{
    public $table = 'news';

    public function getList(){
        return $this->fetchAll("SELECT *, t.theme_title FROM {$this->table} as n
                                LEFT JOIN themes as t
                                 ON n.theme_id = t.theme_id ");
    }
}