<?php

/**
 * This is the model class for table "responsables".
 *
 * The followings are the available columns in table 'responsables':
 * @property string $id
 * @property string $nombre
 * @property string $email
 * @property string $celular
 * @property string $fijo
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property ResponsablesFinancieras[] $responsablesFinancierases
 */
class Responsables extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Responsables the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'responsables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, email, celular, userStamp, timeStamp', 'required'),
			array('nombre, email, celular, fijo, userStamp', 'length', 'max'=>45),
			array('email', 'email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, email, celular, fijo, userStamp, timeStamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'responsablesFinancierases' => array(self::HAS_MANY, 'ResponsablesFinancieras', 'responsableId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'email' => 'Email',
			'celular' => 'Celular',
			'fijo' => 'Fijo',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('fijo',$this->fijo,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors() 
	{
    	return array(
        	'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior',
    	);
	}	
	
	public function beforeValidate()
	{
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
		
		return parent::beforeValidate();
	}
	
	public function responsablesDisponibles($ids)
	{
		$criteria = new CDbCriteria;

		$criteria->addNotInCondition('id',$ids);
		
		return new CActiveDataProvider($this, array('criteria'=>$criteria,));
	}
}