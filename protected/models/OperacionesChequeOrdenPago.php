<?php

/**
 * This is the model class for table "operacionesChequeOrdenPago".
 *
 * The followings are the available columns in table 'operacionesChequeOrdenPago':
 * @property integer $operacionChequeId
 * @property integer $ordenPagoId
 */
class OperacionesChequeOrdenPago extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OperacionesChequeOrdenPago the static model class
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
		return 'operacionesChequeOrdenPago';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operacionChequeId, ordenPagoId', 'required'),
			array('operacionChequeId, ordenPagoId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('operacionChequeId, ordenPagoId', 'safe', 'on'=>'search'),
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
		'operacionesCheques' => array(self::BELONGS_TO, 'OperacionesCheques', 'operacionChequeId'),
		'ordenesPago'=>array(self::BELONGS_TO, 'OrdenesPago','ordenPagoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'operacionChequeId' => 'Operacion Cheque',
			'ordenPagoId' => 'Orden Pago',
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

		$criteria->compare('operacionChequeId',$this->operacionChequeId);
		$criteria->compare('ordenPagoId',$this->ordenPagoId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}