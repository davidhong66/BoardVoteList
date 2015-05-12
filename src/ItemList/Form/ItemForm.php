<?php
namespace ItemList\Form;

use Zend\Form\Form;



class ItemForm extends Form
{
    public function __construct($name = null)
    {
        // We want to ignore the name passed
        parent::__construct('item');

        $this->add(array(
            'name'=>'id',
            'type'=>'Hidden',
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'nature',
            'options' => array(
                'label' => 'Nature',
                'value_options' => array(
                    'select' => '--Select--',
                    'Grant' => 'Grant',
                    'Charitable Expense' => 'Charitable Expense'
                ),
            ),

        ));

        $this->add(array(
            'name'=>'benificiary',
            'type'=>'Text',
            'options'=>array(
                'label'=>'Benificiary',
            ),
        ));
        $this->add(array(
            'name'=>'purpose',
            'type'=>'textarea',
            'options'=>array(
                'label'=>'Purpose',
            ),
        ));
        $this->add(array(
            'name'=>'pi_rationale',
            'type'=>'textarea',
            'options'=>array(
                'label'=>'Rationale',
            ),
        ));
        $this->add(array(
            'name'=>'submit',
            'type'=>'Submit',
            'attributes'=>array(
                'value'=>'Go',
                'id'=>'submitbutton',
            ),
        ));
    }
}
