<?php

namespace Presenter\View\Helper;
use Zend\View\Helper\AbstractHelper;

class Truncate extends AbstractHelper
{
    protected $count = 0;

    public function __invoke($text, $chars = 255)
    {
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }

}