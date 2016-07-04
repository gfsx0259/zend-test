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
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Presenter\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'paginator' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'list[/page/:page]',
                            'defaults' => array(
                                'page' => 1,
                            ),
                        ),
                    ),
                    'view' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'view[/:id]',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Presenter\Controller',
                                'controller' => 'Index',
                                'action' => 'view',
                            ),
                        ),
                    ),
                ),
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
