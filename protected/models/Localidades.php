<?php

/**
 * This is the model class for table "localidades".
 *
 * The followings are the available columns in table 'localidades':
 * @property integer $id
 * @property string $descripcion
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 * @property Proveedores[] $proveedores
 */
class Localidades extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Localidades the static model class
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
		return 'localidades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, sucursalId, userStamp, timeStamp', 'required'),
			array('sucursalId', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>100),
			array('userStamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, descripcion, sucursalId, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
			'proveedores' => array(self::HAS_MANY, 'Proveedores', 'localidadId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descripcion' => 'Descripcion',
			'sucursalId' => 'Sucursal',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}