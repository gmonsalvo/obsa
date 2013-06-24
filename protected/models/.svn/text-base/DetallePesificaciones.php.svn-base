<?php

/**
 * This is the model class for table "detallePesificaciones".
 *
 * The followings are the available columns in table 'detallePesificaciones':
 * @property integer $id
 * @property integer $pesificacionId
 * @property integer $chequeId
 * @property integer $estado
 * @property integer $tipoMov
 * @property integer $conceptoId
 * @property integer $eliminado
 *
 * The followings are the available model relations:
 * @property Cheques $cheque
 * @property Pesificaciones $pesificacion
 *
 * Propiedad agregada que calcula el gasto de pesificador por cada cheque
 * @property integer $gastosCheque
 */
class DetallePesificaciones extends CActiveRecord
{
    private $gastosCheque=0;
    private $montoNetoCheque=0;
    const ESTADO_PENDIENTE = 0;
    const ESTADO_ACREDITADO = 1;
    const TYPE_CREDITO = 0;
    const TYPE_DEBITO = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return DetallePesificaciones the static model class
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
		return 'detallePesificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesificacionId, monto, conceptoId', 'required'),
			array('pesificacionId, chequeId, conceptoId, estado, tipoMov, eliminado ', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pesificacionId, chequeId', 'safe', 'on'=>'search'),
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
			'cheque' => array(self::BELONGS_TO, 'Cheques', 'chequeId'),
			'pesificacion' => array(self::BELONGS_TO, 'Pesificaciones', 'pesificacionId'),
			'conceptoPesificaciones' => array(self::BELONGS_TO, 'ConceptosPesificaciones', 'conceptoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pesificacionId' => 'Pesificacion',
			'chequeId' => 'Cheque',
			'monto' => 'Monto',
			'conceptoId' => 'Concepto'
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
		$criteria->compare('pesificacionId',$this->pesificacionId);
		$criteria->compare('chequeId',$this->chequeId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public function getGastosCheque(){
        $this->gastosCheque=($this->cheque->montoOrigen*$this->pesificacion->pesificador->tasaDescuento)/100;
        return $this->gastosCheque;
    }
    public function getMontoNetoCheque(){
        $this->montoNetoCheque=($this->cheque->montoOrigen-$this->gastosCheque);
        return $this->montoNetoCheque;
    }
}