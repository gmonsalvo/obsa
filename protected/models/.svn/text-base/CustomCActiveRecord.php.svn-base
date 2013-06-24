<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomCActiveRecord
 *
 * @author jj
 */
abstract class CustomCActiveRecord Extends CActiveRecord {

    //put your code here

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
        if($this->hasAttribute("sucursalId"))
            return array(
                'condition' => $alias . ".sucursalId=:sucursalId",
                'params' => array(
                    ':sucursalId' => Yii::app()->user->model->sucursalId,
                ),
            );
        else 
            return array();
    }

    protected function beforeValidate() {
        if($this->hasAttribute("sucursalId"))
            $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

//    public function save(){
//        $result=parent::save();
//        if(defined("YII_DEBUG")){
//            if(!$result)
//                throw new Exception($this->getErrors());
//        }
//        return $result;
//    }

}

?>
