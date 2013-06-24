<?php
 
/*
 * DateTimeConversor
 * Automatically converts date and datetime fields to I18N format
 * 
 * Author: Gabriel Monsalvo <gabriel@arlab.com.ar>
 * Version: 0.1
 * Requires: Yii 1.1.10 version 
 */
 
class DateTimeConversor extends CActiveRecordBehavior {
 
    public $dateMysqlFormat = 'Y-m-d';
    public $dateTimeMysqlFormat = 'Y-m-d H:i:s';
    public $dateShowFormat = 'd/m/Y';
    public $dateTimeShowFormat = 'd/m/Y H:i:s';
 
    public function beforeSave($event) {
        
        //Convertimos al formato de Mysql
        foreach($event->sender->tableSchema->columns as $columnName => $column){
           
            if ($column->dbType == 'date'){
                //primero sacamos las / por -
                $event->sender->$columnName = str_replace('/', '-', $event->sender->$columnName);
                $event->sender->$columnName = date($this->dateMysqlFormat,strtotime($event->sender->$columnName));
              
               
            }elseif ($column->dbType == 'datetime'){
                $event->sender->$columnName = str_replace('/', '-', $event->sender->$columnName);        
                $event->sender->$columnName = date($this->dateTimeMysqlFormat,strtotime($event->sender->$columnName));
               
            }       
 
        
        }
        return true;
    }
 
    public function afterFind($event) {
 
       //Convertimos al formato de Mostrado 
        foreach($event->sender->tableSchema->columns as $columnName => $column){
            if ($column->dbType == 'date'){
                $event->sender->$columnName = date($this->dateShowFormat,strtotime($event->sender->$columnName));
               
            }elseif ($column->dbType == 'datetime'){
                        
                $event->sender->$columnName = date($this->dateTimeShowFormat,strtotime($event->sender->$columnName));
                
            }       
 
       
        }
         return true;
   }
 }  