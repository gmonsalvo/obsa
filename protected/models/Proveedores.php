<?php

/**
 * This is the model class for table "proveedores".
 *
 * The followings are the available columns in table 'proveedores':
 * @property integer $id
 * @property string $documento
 * @property string $denominacion
 * @property string $direccion
 * @property integer $localidadId
 * @property integer $provinciaId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property CtacteProveedores[] $ctacteProveedores
 * @property Localidades $localidad
 * @property Provincias $provincia
 * @property Sucursales $sucursal
 */
class Proveedores extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Proveedores the static model class
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
		return 'proveedores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userStamp, timeStamp, sucursalId', 'required'),
			array('localidadId, provinciaId, sucursalId', 'numerical', 'integerOnly'=>true),
			array('documento', 'length', 'max'=>11),
			array('denominacion, direccion', 'length', 'max'=>100),
			array('userStamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, documento, denominacion, direccion, localidadId, provinciaId, userStamp, timeStamp, sucursalId', 'safe', 'on'=>'search'),
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
			'ctacteProveedores' => array(self::HAS_MANY, 'CtacteProveedores', 'proveedorId'),
			'localidad' => array(self::BELONGS_TO, 'Localidades', 'localidadId'),
			'provincia' => array(self::BELONGS_TO, 'Provincias', 'provinciaId'),
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
			'documento' => 'Documento',
			'denominacion' => 'Denominacion',
			'direccion' => 'Direccion',
			'localidadId' => 'Localidad',
			'provinciaId' => 'Provincia',
			'userStamp' => 'Creado Por',
			'timeStamp' => 'Fecha Creacion',
			'sucursalId' => 'Sucursal',
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
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('denominacion',$this->denominacion,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('localidadId',$this->localidadId);
		$criteria->compare('provinciaId',$this->provinciaId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('sucursalId',$this->sucursalId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}