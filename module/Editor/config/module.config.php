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
            'editor' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/editor/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Editor\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                )
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Editor\Controller\Index' => 'Editor\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'editor' => __DIR__ . '/../view',
        ),
    ),
);
