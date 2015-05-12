<?php
namespace itemList\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class item implements InputFilterAwareInterface{
    public $contents;
    
    public $id;
    public $benificiary;
    public $pi_creationdate;
    public $purpose;
    public $pi_rationale;
    public $nature;

    protected $inputFilter;

    public function exchangeArray($data){
        /*
         * The exchangeArray populates business object with a give array
         */
        $this->contents = $data;
        $this->id = (!empty($data['id']))? $data['id']:null;
        $this->benificiary =(!empty($data['benificiary']))? $data['benificiary']:null;
        $this->pi_creationdate=(!empty($data['pi_creationdate']))? $data['pi_creationdate']:null;
        $this->purpose = (!empty($data['purpose']))? $data['purpose']:null;
        $this->pi_rationale = (!empty($data['pi_rationale']))? $data['pi_rationale']:null;
        $this->nature = (!empty($data['nature']))? $data['nature']:null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
        /* get_object_vars
         * return accessible and non-static properties of an object
         */
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'=>'id',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int'),
                )
            ));


            $inputFilter->add(array(
                'name'=>'purpose',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim'),
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>1,
                            'max'=>255,
                        ),
                    ),
                )
            ));


            $inputFilter->add(array(
                'name'=>'benificiary',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim'),
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>1,
                            'max'=>100,
                        ),
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

