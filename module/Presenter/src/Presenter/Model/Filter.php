<?php

namespace Presenter\Model;

class Filter
{
    public $available_filters = [
        'theme_id',
        'year',
        'month'
    ];

    public function getOptions($request){

        $options = [];
        foreach($this->available_filters as $filter){
            if($request->getQuery($filter)){
                $options[$filter] = $request->getQuery($filter);
            }
        }

        return $options;
    }

}