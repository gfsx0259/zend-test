<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'presenter' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/presenter/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Presenter\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                )
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Presenter\Controller\Index' => 'Presenter\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'presenter' => __DIR__ . '/../view',
        ),
    ),
);
