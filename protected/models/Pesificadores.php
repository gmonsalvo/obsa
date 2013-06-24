<?php

/**
 * This is the model class for table "pesificadores".
 *
 * The followings are the available columns in table 'pesificadores':
 * @property integer $id
 * @property string $denominacion
 * @property string $tasaDescuento
 * @property string $direccion
 * @property string $personaContacto
 * @property string $telefono
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 */
class Pesificadores extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pesificadores the static model class
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
		return 'pesificadores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('denominacion, tasaDescuento, sucursalId, userStamp', 'required'),
			array('sucursalId', 'numerical', 'integerOnly'=>true),
			array('denominacion, telefono', 'length', 'max'=>45),
			array('tasaDescuento', 'length', 'max'=>5),
			array('direccion', 'length', 'max'=>100),
			array('personaContacto', 'length', 'max'=>255),
			array('userStamp', 'length', 'max'=>50),
			array('timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, denominacion, tasaDescuento, direccion, personaContacto, telefono, sucursalId, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'denominacion' => 'Denominacion',
			'tasaDescuento' => 'Tasa Descuento',
			'direccion' => 'Direccion',
			'personaContacto' => 'Persona Contacto',
			'telefono' => 'Telefono',
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
		$criteria->compare('denominacion',$this->denominacion,true);
		$criteria->compare('tasaDescuento',$this->tasaDescuento,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('personaContacto',$this->personaContacto,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}