<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ItemList\Controller\Item' => 'ItemList\Controller\ItemController',
            ),
    ),
    'router' => array(
        'routes' => array(
            'item' => array(
                'type'    => 'segment',
                    'options' => array(
                        'route' => '/item[/][:action][/:id]',
                        'constraints'=> array(
                            'action'=>'[a-zA-Z][a-zA-Z0-9]*',
                            'id' =>'[0-9]+',
                        ),
                    'defaults' => array(
                        'controller' => 'ItemList\Controller\Item',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack'=> array(
            'item'=>__DIR__.'/../view',
        ),
    ),

);

    // Controller namespace to template map
    // or whitelisting for controller FQCN to template mapping
            //'<module-namespace>\Controller\Index' =>
            //'<module-namespace>\Controller\IndexController',
            // Do similar for each other controller in your module
            // ... other configuration ...