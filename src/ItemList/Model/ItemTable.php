<?php
namespace ItemList\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;

class ItemTable{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false){
        if ($paginated) {
            $select = new Select('item');
            $select->order("id DESC");
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Item());
            $paginatorAdaptor = new DbSelect(
                    $select,
                    $this->tableGateway->getAdapter(),
                    $resultSetPrototype
                    );
            $paginator = new \Zend\Paginator\Paginator($paginatorAdaptor);
            return $paginator;
        }

        $resultSet = $this->tableGateway->select();
		//var_dump($resultSet);
        return $resultSet;
    }
    public function getItem($id){
        $id = (int)$id;

        $rowset = $this->tableGateway->select(array('id'=>(int)$id));

        $row = $rowset->current();
        if (!$row) {

            throw new Exception("Could not find row $id");
        }
        return $row;
    }
    public function saveItem(Item $item){

        $data = array(
            'benificiary'=>$item->benificiary,
            'purpose'=>$item->purpose,
            'pi_rationale'=>$item->pi_rationale,
            'nature'=>$item->nature,
        );

        $id = (int)$item->id;
        if ($id==0) {
            $this->tableGateway->insert($data);
        } else{
            if ($this->getItem($id)) {
                $this->tableGateway->update($data, array('id'=>$id));
            } else {
                throw new Exception("Item Id does not exist");
            }
        }
    }
    public function deleteItem($id){
        $this->tableGateway->delete(array('id'=>(int)$id));
    }
}

