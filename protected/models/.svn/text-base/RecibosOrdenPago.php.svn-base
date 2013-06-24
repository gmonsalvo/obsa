<?php

/**
 * This is the model class for table "recibosOrdenPago".
 *
 * The followings are the available columns in table 'recibosOrdenPago':
 * @property integer $id
 * @property integer $ordenPagoId
 * @property string $fecha
 * @property string $montoTotal
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property RecibosDetalle[] $recibosDetalles
 * @property OrdenesPago $ordenPago
 */
class RecibosOrdenPago extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RecibosOrdenPago the static model class
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
		return 'recibosOrdenPago';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ordenPagoId, fecha, montoTotal, userStamp, timeStamp', 'required'),
			array('ordenPagoId', 'numerical', 'integerOnly'=>true),
			array('montoTotal', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ordenPagoId, fecha, montoTotal, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'recibosDetalles' => array(self::HAS_MANY, 'RecibosDetalle', 'reciboId'),
			'ordenPago' => array(self::BELONGS_TO, 'OrdenesPago', 'ordenPagoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ordenPagoId' => 'Orden Pago',
			'fecha' => 'Fecha',
			'montoTotal' => 'Monto Total',
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
		$criteria->compare('ordenPagoId',$this->ordenPagoId);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('montoTotal',$this->montoTotal,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}