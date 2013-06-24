<?php

/*
 * DateTimeI18NBehavior
 * Automatically converts date and datetime fields to I18N format
 * 
 * Author: Ricardo Grana <rickgrana@yahoo.com.br>, <ricardo.grana@pmm.am.gov.br>
 * Version: 1.1
 * Requires: Yii 1.0.9 version 
 */

class DateTimeI18NBehavior  extends CActiveRecordBehavior
{
    public $dateTimeOutcomeFormat = 'Y-m-d H:i:s';
	public $dateOutcomeFormat = 'Y-m-d';
    public $dateIncomeFormat = 'yyyy-MM-dd';
    public $dateTimeIncomeFormat = 'yyyy-MM-dd hh:mm:ss';
 
    public $inFormat = 'long|short|medium';
    public $outFormat = 'medium';
 
    public function beforeSave($event){
        $informat = explode('|', $this->inFormat);
 
        //search for date/datetime columns. Convert it to pure PHP date format
        foreach($event->sender->tableSchema->columns as $columnName => $column){
            Yii::log("Convert $columnName from format " . Yii::app()->locale->dateFormat . ' to ' .$this->dateOutcomeFormat, 'warning', 'ext.behaviors.DateTimeI18N');
 
            if (($column->dbType != 'date') and ($column->dbType != 'datetime')) continue;
            if (!is_string($event->sender->$columnName)) continue;
            }
 
            if (($column->dbType == 'date')) {
               $event->sender->$columnName = date($this->dateOutcomeFormat, CDateTimeParser::parse($event->sender->$columnName, Yii::app()->locale->dateFormat));
                /*foreach ($informat as $dateWidth) {
                    $timestamp = CDateTimeParser::parse($event->sender->$columnName, Yii::app()->locale->getDateFormat($dateWidth));
                    if ($timestamp) {
                        $event->sender->$columnName = date($this->dateOutcomeFormat, $timestamp);
                        break;
                    }
                }*/
 
            }else{
//-               $event->sender->$columnName = date($this->dateTimeOutcomeFormat,
//-                   CDateTimeParser::parse($event->sender->$columnName,
                foreach ($informat as $dateWidth) {
                    $timestamp = CDateTimeParser::parse($event->sender->$columnName,
                        strtr(Yii::app()->locale->dateTimeFormat,
//-                           array("{0}" => Yii::app()->locale->timeFormat,
//-                                 "{1}" => Yii::app()->locale->dateFormat))));
                            array("{0}" => Yii::app()->locale->getTimeFormat($dateWidth),
                                  "{1}" => Yii::app()->locale->getDateFormat($dateWidth))));
                    if ($timestamp) {
                        $event->sender->$columnName = date($this->dateTimeOutcomeFormat, $timestamp);
                        break;
                    }
                }
            }
 
        }
		
	public function afterFind($event){
					
		foreach($event->sender->tableSchema->columns as $columnName => $column){
						
			if (($column->dbType != 'date') and ($column->dbType != 'datetime')) continue;
			
			if (!strlen($event->sender->$columnName)){ 
				$event->sender->$columnName = null;
				continue;
			}
			
			if ($column->dbType == 'date'){				
				$event->sender->$columnName = Yii::app()->dateFormatter->formatDateTime(
								CDateTimeParser::parse($event->sender->$columnName, $this->dateIncomeFormat),'medium',null);
			}else{				
				$event->sender->$columnName = 
					Yii::app()->dateFormatter->formatDateTime(
							CDateTimeParser::parse($event->sender->$columnName,	$this->dateTimeIncomeFormat), 
							'medium', 'medium');
			}
		}
		return true;
	}
}