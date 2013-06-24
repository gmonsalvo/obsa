<?php

/**
 * This is the model class for table "presupuestoOperacionesCheques".
 *
 * The followings are the available columns in table 'presupuestoOperacionesCheques':
 * @property integer $id
 * @property integer $operadorId
 * @property integer $clienteId
 * @property string $montoNetoTotal
 * @property integer $estado
 * @property string $fecha
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 */
class PresupuestoOperacionesCheques extends CActiveRecord {
    const ESTADO_COMPRADO=0;
    const ESTADO_PRESUPUESTADO=1;

    private $montoPesificacion=0;
    private $montoIntereses=0;
    private $montoNominalTotal=0;

    /**
     * Returns the static model of the specified AR class.
     * @return PresupuestoOperacionesCheques the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'presupuestoOperacionesCheques';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operadorId, clienteId, montoNetoTotal, fecha, userStamp, timeStamp, sucursalId', 'required'),
            array('operadorId, clienteId, estado, sucursalId', 'numerical', 'integerOnly' => true),
            array('montoNetoTotal', 'length', 'max' => 15),
            array('userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, operadorId, clienteId, montoNetoTotal, estado, fecha, userStamp, timeStamp, sucursalId', 'safe', 'on' => 'search'),
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
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'operador' => array(self::BELONGS_TO, 'Operadores', 'operadorId'),
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
            'montoNetoTotal' => 'Monto Neto Total',
            'estado' => 'Estado',
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
        $criteria->compare('estado', $this->estado);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

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

    public function searchById() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "operacionChequeId=:id";
        $criteria->params = array(':id' => $this->id);
        return new CActiveDataProvider(new PresupuestosCheques, array(
                    'criteria' => $criteria,
                ));
    }

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public function init(){
        $command = Yii::app()->db->createCommand();
        $criteria = new CDbCriteria();
        $criteria->condition="DATE(timeStamp)=:fechahoy AND userStamp=:username";
        $criteria->params=array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username);
        $presupuestoCheques=PresupuestosCheques::model()->findAll($criteria);
        //$tmpCheques = $command->select('*')->from('tmpCheques')->where('DATE(timeStamp)=:fechahoy AND userStamp=:username AND presupuesto=0', array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username))->queryAll();
        $this->montoNetoTotal = 0;
        $this->montoPesificacion = 0;
        $this->montoNominalTotal = 0;
        $this->montoIntereses = 0;
        foreach ($presupuestoCheques as $presupuestoCheque) {
            $this->montoNetoTotal+=$presupuestoCheque->montoNeto;
            $this->montoPesificacion+=$presupuestoCheque->descuentoPesific;
            $this->montoNominalTotal+=$presupuestoCheque->montoOrigen;
            $this->montoIntereses+=$presupuestoCheque->descuentoTasa;
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