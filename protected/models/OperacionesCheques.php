<?php

/**
 * This is the model class for table "operacionesCheques".
 *
 * The followings are the available columns in table 'operacionesCheques':
 * @property integer $id
 * @property integer $operadorId
 * @property integer $clienteId
 * @property string $montoNetoTotal
 * @property string $fecha
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Cheques[] $cheques
 * @property Clientes $cliente
 * @property Sucursales $sucursal
 * @property Operadores $operador
 */
class OperacionesCheques extends CustomCActiveRecord {

    const ESTADO_COMPRADO=0;
    const ESTADO_PRESUPUESTADO=1;
    const ESTADO_A_PAGAR=2;
    const ESTADO_ANULADO=3;

    private $montoPesificacion=0;
    private $montoIntereses=0;
    private $montoNominalTotal=0;
	
	public $productoId;
    public $pkModeloRelacionado;
    public $financiera;
    public $clienteId;
    public $financieraId;

    /**
     * Returns the static model of the specified AR class.
     * @return OperacionesCheques the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'operacionesCheques';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operadorId, clienteId, montoNetoTotal, fecha, userStamp, timeStamp, sucursalId', 'required'),
            array('operadorId, clienteId, sucursalId', 'numerical', 'integerOnly' => true),
            array('montoNetoTotal', 'length', 'max' => 15),
            array('userStamp', 'length', 'max' => 45),
            array('timeStamp', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, operadorId, clienteId, montoNetoTotal, fecha, userStamp, timeStamp, sucursalId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cheques' => array(self::HAS_MANY, 'Cheques', 'operacionChequeId'),
            'productoCtaCte' => array(self::BELONGS_TO, 'Productoctacte', 'productoCtaCteId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'operador' => array(self::BELONGS_TO, 'Operadores', 'operadorId'),
            'operacionesChequeOrdenPago'=>array(self::HAS_MANY, 'OperacionesChequeOrdenPago','operacionChequeId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'operadorId' => 'Operador',
            'clienteId' => 'Cliente',
            'financieraId' => 'Financiera',
            'productoId' => 'Producto',
            'montoNetoTotal' => 'Monto Neto Total',
            'fecha' => 'Fecha',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'sucursalId' => 'Sucursal',
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
        $criteria->compare('operadorId', $this->operadorId);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('montoNetoTotal', $this->montoNetoTotal, true);
        $criteria->compare('fecha', isset($this->fecha) ? Utilities::MysqlDateFormat($this->fecha) : $this->fecha, true);
        $criteria->compare('userStamp', Yii::app()->user->model->username, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

        //solo muestro estos dos estado en el admin
        $estados = array(self::ESTADO_COMPRADO,self::ESTADO_A_PAGAR);
        $criteria->compare('estado', $estados, "OR");
        $criteria->order="timeStamp DESC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function beforeValidate() {
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->operadorId = Yii::app()->user->model->operadores->id;
        return parent::beforeValidate();
    }

    public function behaviors() {
        return array('datetimeI18NBehavior' => array('class' => 'ext.DateTimeI18NBehavior'),
                     'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior'); // 'ext' is in Yii 1.0.8 version. For early versions, use 'application.extensions' instead.
    }

    public function init(){
        $command = Yii::app()->db->createCommand();
        $criteria = new CDbCriteria();
        $criteria->condition="DATE(timeStamp)=:fechahoy AND userStamp=:username AND presupuesto=0";
        $criteria->params=array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username);
        $tmpCheques=TmpCheques::model()->findAll($criteria);
        //$tmpCheques = $command->select('*')->from('tmpCheques')->where('DATE(timeStamp)=:fechahoy AND userStamp=:username AND presupuesto=0', array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username))->queryAll();
        $this->montoNetoTotal = 0;
        $this->montoNominalTotal = 0;
        $this->montoPesificacion = 0;
        $this->montoIntereses = 0;
        foreach ($tmpCheques as $tmpCheque) {
            $this->montoNetoTotal+=$tmpCheque->montoNeto;
            $this->montoNominalTotal+=$tmpCheque->montoOrigen;
            $this->montoPesificacion+=$tmpCheque->descuentoPesific;
            $this->montoIntereses+=$tmpCheque->descuentoTasa;
        }
    }

    public function getMontoPesificacion(){
        return $this->montoPesificacion;
    }
    public function getMontoIntereses(){
        return $this->montoIntereses;
    }
    public function getMontoNominalTotal(){
        return $this->montoNominalTotal;
    }

}