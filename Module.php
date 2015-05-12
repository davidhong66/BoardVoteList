<?php
namespace ItemList;
//use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
//use Zend\ModuleManager\Feature\ConfigProviderInterface;

use ItemList\Model\Item;
use ItemList\Model\ItemTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );

    }

    public function getConfig(){
        return include __DIR__.'/config/module.config.php';

    }

    public function getServiceConfig(){
        return array(
            'factories'=>array(
                'ItemList\Model\ItemTable'=> function ($sm){
                    $tableGateway=$sm->get('ItemTableGateway');
                    $table = new ItemTable($tableGateway);
                    return $table;
                },
            'ItemTableGateway'=>function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Item());
                    return new TableGateway('item',$dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
