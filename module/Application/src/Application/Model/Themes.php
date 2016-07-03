<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Themes extends Base
{
    public $table = 'themes';

    public function getList(){

        $themes = [];
        $rows = $this->fetchAll("SELECT * FROM {$this->table}");

        foreach($rows as $row){
            $themes[$row['theme_id']] = $row['theme_title'];
        }
       return $themes;
    }

    public function getFilterThemes(){
        $themes_filter = $this->fetchAll("
                SELECT
                  t.theme_id,
                  t.theme_title,
                  count(*) as count
                FROM news as n
                  LEFT JOIN themes as t ON
                    t.theme_id = n.theme_id
                GROUP BY t.theme_id;
            ");

        return $themes_filter;
    }

}