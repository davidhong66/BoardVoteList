<?php
namespace ItemList\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ItemList\Form\ItemForm;
use ItemList\Model\Item;

class ItemController extends AbstractActionController{
    protected $itemTable;
    
    public function indexAction() {
        $paginator = $this->getItemTable()->fetchAll(true);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        $paginator->setitemCountPerPage(3);
        
        return new ViewModel(array(
            'paginator'=>$paginator
                ));
    }
    
    public function addAction(){
        $form = new ItemForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if($request->isPost()){
            $item = new Item();
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $item->exchangeArray($form->getData());
                $this->getItemTable()->saveItem($item);
            }
            //Redirect to list of items
            return $this->redirect()->toRoute('item');
        }
        return array('form'=>$form);
    }

    public function editAction(){
        $id = (int)$this->params()->fromRoute('id',0); //print '<h1>'.$id.'</h1>';die ('hh');
        $item = $this->getItemTable()->getItem($id);
        $form = new ItemForm();
        $form->bind($item);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getItemTable()->saveItem($item);return

                //Redirect to list of items
                $this->redirect()->toRoute('item');
            }
        }

        return array('id'=>$id,'form'=>$form);

    }

    public function deleteAction(){
        $id = (int)$this->params()->fromRoute('id',0);
        if (!$id) {
            return $this->redirect()->toRoute('item');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del','No');

            if ($del=='Yes') {
                $id = (int)$request->getPost('id');
                $this->getItemTable()->deleteItem($id);
            }

            //Redirect to list of items
            return $this->redirect()->toRoute('item');

        }

        return array('id'=>$id,'item'=> $this->getItemTable()->getItem($id));
    }
    public function getItemTable(){
        if (!$this->itemTable) {
            $sm = $this->getServiceLocator();
            $this->itemTable = $sm->get('ItemList\Model\ItemTable');
            //if not exist as sevice manager to have one at this location.
        }
        return $this->itemTable;
    }
}