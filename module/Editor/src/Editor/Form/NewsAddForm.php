<?php

namespace Editor\Form;

use Zend\Form\Form;


class NewsAddForm extends Form
{
    public function __construct($name = null, $options = null)
    {
        parent::__construct('newsAddFrom');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'news_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',

            'options' => array(
                'label' => 'Заголовок',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true
            )
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'DateTime',
            'options' => array(
                'label' => 'Дата',
                'format' => 'Y-m-d',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'id' => 'date'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'theme_id',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Категория',
                'empty_option'    => 'Категория не выбрана',
                'value_options' => $options['category_values']
            )
        ));

        $this->add(array(
            'name' => 'text',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Текст'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'rows' => 5
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Add',
                'class' => 'btn btn-primary',
                'id' => 'submitbutton',
            ),
        ));
    }
}