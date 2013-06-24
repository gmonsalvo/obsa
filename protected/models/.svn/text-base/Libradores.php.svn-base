<?php

/**
 * This is the model class for table "libradores".
 *
 * The followings are the available columns in table 'libradores':
 * @property integer $id
 * @property string $documento
 * @property string $denominacion
 * @property string $direccion
 * @property integer $sucursalId
 * @property integer $actividadId
 * @property string $montoMaximo
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $localidadId
 * @property integer $provinciaId
 *
 * The followings are the available model relations:
 * @property Cheques[] $cheques
 * @property Localidades $localidad
 * @property Provincias $provincia
 * @property Actividades $actividad
 * @property Sucursales $sucursal
 * @property Socios[] $socios
 */
class Libradores extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Libradores the static model class
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
		return 'libradores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, denominacion, direccion, sucursalId, montoMaximo, userStamp, timeStamp, localidadId, provinciaId', 'required'),
			array('sucursalId, actividadId, localidadId, provinciaId', 'numerical', 'integerOnly'=>true),
			array('documento,denominacion','unique'),
			array('documento', 'length', 'max'=>11),
			array('denominacion, direccion', 'length', 'max'=>100),
			array('montoMaximo', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, documento, denominacion, direccion, sucursalId, actividadId, montoMaximo, localidadId, provinciaId', 'safe', 'on'=>'search'),
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
			'cheques' => array(self::HAS_MANY, 'Cheques', 'libradorId'),
			'localidad' => array(self::BELONGS_TO, 'Localidades', 'localidadId'),
			'provincia' => array(self::BELONGS_TO, 'Provincias', 'provinciaId'),
			'actividad' => array(self::BELONGS_TO, 'Actividades', 'actividadId'),
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
			'socios' => array(self::HAS_MANY, 'Socios', 'libradorId'),
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
			'sucursalId' => 'Sucursal',
			'actividadId' => 'Actividad',
			'montoMaximo' => 'Monto Maximo',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
			'localidadId' => 'Localidad',
			'provinciaId' => 'Provincia',
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
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('actividadId',$this->actividadId);
		$criteria->compare('montoMaximo',$this->montoMaximo,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('localidadId',$this->localidadId);
		$criteria->compare('provinciaId',$this->provinciaId);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}