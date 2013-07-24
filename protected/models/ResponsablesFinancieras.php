<?php

/**
 * This is the model class for table "responsablesFinancieras".
 *
 * The followings are the available columns in table 'responsablesFinancieras':
 * @property string $id
 * @property string $responsableId
 * @property string $financieraId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Financieras $financiera
 * @property Responsables $responsable
 */
class ResponsablesFinancieras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResponsablesFinancieras the static model class
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
		return 'responsablesFinancieras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('responsableId, financieraId, userStamp, timeStamp', 'required'),
			array('responsableId, financieraId', 'length', 'max'=>10),
			array('userStamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, responsableId, financieraId, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'financiera' => array(self::BELONGS_TO, 'Financieras', 'financieraId'),
			'responsable' => array(self::BELONGS_TO, 'Responsables', 'responsableId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'responsableId' => 'Responsable',
			'financieraId' => 'Financiera',
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
		$criteria->compare('responsableId',$this->responsableId,true);
		$criteria->compare('financieraId',$this->financieraId,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}