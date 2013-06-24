<?php

/**
 * This is the model class for table "ctacteClientes".
 *
 * The followings are the available columns in table 'ctacteClientes':
 * @property integer $id
 * @property integer $tipoMov
 * @property integer $conceptoId
 * @property integer $clienteId
 * @property string $descripcion
 * @property string $monto
 * @property string $fecha
 * @property string $origen
 * @property string $identificadorOrigen
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 * @property integer $productoId
 * @property string $saldoAcumulado
 *
 * The followings are the available model relations:
 * @property Clientes $cliente
 * @property Conceptos $concepto
 * @property Sucursales $sucursal
 */
class CtacteClientes extends CustomCActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return CtacteClientes the static model class
     */
    // Tipos de movimientos

    const TYPE_CREDITO = 0;
    const TYPE_DEBITO = 1;

    private $acum;
    private $saldo;
    public $total;
    public $fechaInicio;
    public $fechaFin;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ctacteClientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha, tipoMov, clienteId, productoId, monto, sucursalId, userStamp, timeStamp', 'required'),
            array('tipoMov, clienteId, estado, sucursalId, productoId, identificadorOrigen', 'numerical', 'integerOnly' => true),
            array('descripcion', 'length', 'max' => 200),
            array('monto', 'length', 'max' => 15),
            array('origen, userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, tipoMov, conceptoId, clienteId, descripcion, monto, fecha, origen, identificadorOrigen, sucursalId, productoId, saldoAcumulado,fechaInicio,fechaFin', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'concepto' => array(self::BELONGS_TO, 'Conceptos', 'conceptoId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'producto' => array(self::BELONGS_TO, 'Productos', 'productoId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tipoMov' => 'Tipo Mov',
            'conceptoId' => 'Concepto',
            'clienteId' => 'Cliente',
            'productoId' => 'Producto',
            'descripcion' => 'Descripcion',
            'monto' => 'Monto',
            'fecha' => 'Fecha',
            'origen' => 'Origen',
            'identificadorOrigen' => 'Identificador Origen',
            'estado' => 'Estado',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'sucursalId' => 'Sucursal',
            'saldoAcumulado' => 'Saldo Acumulado'
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
     
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('productoId', $this->productoId);
        $criteria->addBetweenCondition('fecha',$this->fechaInicio,$this->fechaFin);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function searchByFechaAndCliente($fechaIni, $fechaFin, $clienteId) {
        $criteria = new CDbCriteria;
        $criteria->condition = "(fecha BETWEEN :start_day AND :end_day) AND clienteId=:clienteId";
        $criteria->order = 'fecha ASC';
        $criteria->params = array(':start_day' => $fechaIni, ':end_day' => $fechaFin, ':clienteId' => $clienteId);

        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }

    public function getTypeOptions() {
        return array(
            self::TYPE_CREDITO => 'Credito',
            self::TYPE_DEBITO => 'Debito',
        );
    }

    public function getTypeDescription() {
        $options = array();
        $options = $this->getTypeOptions();
        return $options[$this->tipoMov];
    }

    public function getSaldo() {
        $creditoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'ctacteClientes',
                    'where' => 'clienteId=:clienteId AND tipoMov=0 AND productoId=:productoId AND sucursalId=:sucursalId',
                    'params' => array(
                        ':clienteId' => $this->clienteId,
                        ':productoId' => $this->productoId,
                        ':sucursalId' => Yii::app()->user->model->sucursalId),
                ))->queryScalar();

        $debitoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'ctacteClientes',
                    'where' => 'clienteId=:clienteId AND tipoMov=1 AND productoId=:productoId AND sucursalId=:sucursalId',
                    'params' => array(
                        ':clienteId' => $this->clienteId,
                        ':productoId' => $this->productoId,
                        ':sucursalId' => Yii::app()->user->model->sucursalId),
                ))->queryScalar();

        if ($creditoSQL != NULL and $debitoSQL != NULL) {
            return $saldo = $creditoSQL - $debitoSQL;
        }
    }

    //Esta función busca el id en la tabla conceptos basado en el nombre Ingreso de fondos
    //Se usa para poner el ID del concepto "Ingreso de Fondos" en la DB
    protected function getIdConcepto() {
        $sql = "SELECT id FROM conceptos WHERE nombre='Ingreso de Fondos'";
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }

    protected function beforeValidate() {
        //$this->conceptoId = $this->getIdConcepto();
        //$this->tipoMov = 0;
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }

    public function behaviors() {
        return array('dateTimeConversor' => array('class' => 'ext.DateTimeConversor'),
            'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior');
    }

    public function getTotalPorConcepto($clienteId, $conceptoId) {
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(monto) as total";
        $criteria->condition = "clienteId=:clienteId AND conceptoId=:conceptoId";
        $criteria->params = array(
            ':clienteId' => $clienteId,
            ':conceptoId' => $conceptoId);
        $ctacteClientes = CtacteClientes::model()->find($criteria);
        return $ctacteClientes->total;
    }

    public function getSaldoAcumuladoActual(){
        if(isset($this->clienteId)){
            $criteria = new CDbCriteria();
            $criteria->condition = "id IN (SELECT MAX(id) FROM ctacteClientes WHERE clienteId=".$this->clienteId.")";
            $model = $this->find($criteria);
            if(isset($model))
                return $model->saldoAcumulado;
            else
                return 0;
        } else return 0;
    }

}
