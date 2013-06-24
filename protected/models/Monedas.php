<?php

/**
 * This is the model class for table "monedas".
 *
 * The followings are the available columns in table 'monedas':
 * @property integer $id
 * @property string $denominacion
 * @property string $tasaCambioPesos
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 * @property OperacionesCambio[] $operacionesCambios
 * @property Productos[] $productoses
 */
class Monedas extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Monedas the static model class
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
		return 'monedas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('denominacion, tasaCambioCompra,tasaCambioVenta, userStamp, timeStamp, sucursalId', 'required'),
			array('sucursalId', 'numerical', 'integerOnly'=>true),
			array('denominacion, userStamp', 'length', 'max'=>45),
			array('denominacion', 'unique'),
			array('tasaCambioCompra,tasaCambioVenta', 'length', 'max'=>15),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, denominacion, tasaCambioCompra,tasaCambioVenta, userStamp, timeStamp, sucursalId', 'safe', 'on'=>'search'),
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
			'operacionesCambios' => array(self::HAS_MANY, 'OperacionesCambio', 'monedaId'),
			'productoses' => array(self::HAS_MANY, 'Productos', 'monedaId'),
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
			'tasaCambioCompra' => 'Tasa Cambio Compra',
			'tasaCambioVenta' => 'Tasa Cambio Venta',
			'userStamp' => 'Creada Por',
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
		$criteria->compare('denominacion',$this->denominacion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('sucursalId',$this->sucursalId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}