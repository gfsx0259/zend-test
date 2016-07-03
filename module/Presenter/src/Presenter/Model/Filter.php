<?php

namespace Presenter\Model;

class Filter
{
    public $available_filters = [
        'theme_id'
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

    public function getUrl($options){
        return http_build_query($options);
    }
}