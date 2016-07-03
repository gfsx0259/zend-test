<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class News extends Base implements InputFilterAwareInterface
{
    public $table = 'news';

    public $news_id;
    public $date;
    public $title;
    public $text;
    public $theme_id;

    public function exchangeArray($data)
    {
        $this->news_id = (isset($data['news_id'])) ? $data['news_id']     : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
        $this->title  = (isset($data['title']))  ? $data['title']  : null;
        $this->text  = (isset($data['text']))  ? $data['text']  : null;
        $this->theme_id  = (isset($data['theme_id']))  ? $data['theme_id']  : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function getList($options = null){

        $condition = '';
        if(count($options) > 0){
            $condition = 'WHERE ';
            if(isset($options['theme_id'])){
                $condition.= 'n.theme_id = \''.$options['theme_id'].'\'';
            }
        }

        return $this->fetchAll("
            SELECT *, t.theme_title
            FROM {$this->table} as n
            LEFT JOIN themes as t
            ON n.theme_id = t.theme_id
            $condition
            ORDER BY news_id DESC
            ");
    }

    public function getFilterDates(){
        $dates_filter = $this->fetchAll("
            SELECT
                YEAR(date) as year,
                MONTH(date) as month,
                count(*) as count
            FROM news
            GROUP BY year, month;
            ");

        $dates_filter_by_year = [];
        foreach($dates_filter as $row){
            $dates_filter_by_year[$row['year']][] = $row;
        }

        return $dates_filter_by_year;
    }


    public function add($data){
        return $this->query("
            INSERT INTO news (date, text, title, theme_id)
            VALUES ('{$data->date}', '{$data->text}', '{$data->title}', '{$data->theme_id}')
        ");
    }

    public function update($data){
        return $this->query("
            UPDATE news
            SET
            date = '{$data->date}',
            text = '{$data->text}',
            title = '{$data->title}',
            theme_id = '{$data->theme_id}'
            WHERE news_id = '{$data->news_id}'
        ");
    }

    public function getById($id){
        return $this->fetchRow("
            SELECT *, t.theme_title
            FROM {$this->table} as n
            LEFT JOIN themes as t
            ON n.theme_id = t.theme_id WHERE news_id = $id ");
    }


    public function delete($id){
        return $this->query("DELETE FROM {$this->table} WHERE news_id= {$id}");
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'news_id',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'text',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                            'messages' => array(
                                'stringLengthTooShort' => 'Длинна текста должна быть больше 3 символов',
                                'stringLengthTooLong' => 'Длинна текста должна быть меньше 100 символов'
                            ),
                        ),

                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                            'messages' => array(
                                'stringLengthTooShort' => 'Длинна Заголовка должна быть больше 3 символов',
                                'stringLengthTooLong' => 'Длинна Заголовка должна быть меньше 100 символов'
                            ),
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}