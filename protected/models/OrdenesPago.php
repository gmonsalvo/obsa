<?php

/**
 * This is the model class for table "ordenesPago".
 *
 * The followings are the available columns in table 'ordenesPago':
 * @property integer $id
 * @property integer $clienteId
 * @property string $fecha
 * @property string $monto
 * @property string $descripcion
 * @property integer $estado
 * @property string $porcentajePesificacion
 * @property string $origenOperacion
 * @property integer $sucursalId

 * @property string $tasaCambio
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property FormaPagoOrden[] $formaPagoOrdens
 * @property Clientes $cliente
 * @property Sucursales $sucursal
 */
class OrdenesPago extends CustomCActiveRecord {


    private $saldo;
    private $montoCheques;
    /**
     * Returns the static model of the specified AR class.
     * @return OrdenesPago the static model class

     */
    const ESTADO_PENDIENTE=0;
    const ESTADO_PAGADA=1;
    const ESTADO_ANULADA=2;

    const ORIGEN_OPERACION_COMPRA=0;
    const ORIGEN_OPERACION_RETIRO_FONDOS=1;
	const ORIGEN_OPERACION_COMPRA_DOLARES=2;
	const ORIGEN_OPERACION_VENTA_DOLARES=3;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ordenesPago';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('clienteId, fecha, monto, estado, sucursalId', 'required'),
            array('clienteId, estado, sucursalId', 'numerical', 'integerOnly' => true),
            array('porcentajePesificacion', 'length', 'max' => 7),
            array('monto', 'length', 'max' => 15),
            array('descripcion', 'length', 'max' => 100),
            array('userStamp', 'length', 'max' => 45),
            array('timeStamp', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, clienteId, fecha, monto, descripcion, estado, sucursalId, userStamp, timeStamp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'formaPagoOrdens' => array(self::HAS_MANY, 'FormaPagoOrden', 'ordenPagoId'),
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'operacionesChequeOrdenPago'=>array(self::HAS_ONE, 'OperacionesChequeOrdenPago','ordenPagoId'),
            'recibos' => array(self::HAS_MANY, 'RecibosOrdenPago', 'ordenPagoId'),
            'totalMontoRecibos' => array(self::STAT, 'RecibosOrdenPago', 'ordenPagoId','select'=> 'SUM(montoTotal)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'clienteId' => 'Cliente',
            'fecha' => 'Fecha',
            'monto' => 'Monto',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'porcentajePesificacion' => 'Porcentaje Pesificacion',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('estado', $this->estado);
        $criteria->compare('porcentajePesificacion', $this->porcentajePesificacion);
        $criteria->compare('sucursalId', $this->sucursalId);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchByEstado($estado) {
        $criteria = new CDbCriteria;
        $criteria->condition = "estado=:estado";
        $criteria->params = array(':estado' => $estado);
        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

//    protected function beforeValidate() {
//        $this->sucursalId = Yii::app()->user->model->sucursalId;
//        $this->userStamp = Yii::app()->user->model->username;
//        $this->timeStamp = Date("Y-m-d h:m:s");
//        return parent::beforeValidate();
//    }

    public function getTypeOptions() {
        return array(
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_PAGADA => 'Pagada',
            self::ESTADO_ANULADA => 'Anulada',
        );
    }

    public function getTypeDescription() {
        $options = array();
        $options = $this->getTypeOptions();
        return $options[$this->estado];
    }

    public function searchByFecha($fecha) {
        $criteria = new CDbCriteria;
        $criteria->condition = "fecha=:fecha";
        $criteria->params = array(':fecha' => $fecha);
        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getMontoCheques(){
        foreach ($this->formaPagoOrdens as $formaPago) {
            if ($formaPago->tipoFormaPago == FormaPagoOrden::TIPO_CHEQUES) 
                $this->montoCheques += $formaPago->monto;
        }
        return $this->montoCheques;
    }

    public function getSaldo(){ 
        if(empty($this->recibos))
            $this->saldo = $this->monto;
        else
            $this->saldo = $this->monto - $this->totalMontoRecibos;
        return $this->saldo;
    }

}