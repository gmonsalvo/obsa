<?php

/**
 * This is the model class for table "flujoFondos".
 *
 * The followings are the available columns in table 'flujoFondos':
 * @property integer $id
 * @property integer $cuentaId
 * @property integer $conceptoId
 * @property string $descripcion
 * @property integer $tipoFlujoFondos
 * @property   string $monto
 * @property string $fecha
 * @property string $origen
 * @property string $identificadorOrigen
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
* @property string $saldoAcumulado
 *
 * The followings are the available model relations:
 * @property Conceptos $concepto
 * @property Cuentas $cuenta
 */
class FlujoFondos extends CustomCActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return FlujoFondos the static model class
     */
    const TYPE_CREDITO=0;
    const TYPE_DEBITO=1;
    public $fechaDesde, $fechaHasta, $saldo;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'flujoFondos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cuentaId, conceptoId, descripcion, tipoFlujoFondos, monto, fecha, sucursalId, userStamp, timeStamp', 'required'),
            array('cuentaId, conceptoId, tipoFlujoFondos, sucursalId', 'numerical', 'integerOnly' => true),
            array('descripcion', 'length', 'max' => 100),
            array('monto', 'length', 'max' => 15),
            array('origen, userStamp', 'length', 'max' => 45),
            array('identificadorOrigen', 'length', 'max' => 20),
            array('timeStamp', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cuentaId, conceptoId, descripcion, tipoFlujoFondos, monto, fecha, origen, identificadorOrigen,fechaDesde, fechaHasta, saldoAcumulado',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'concepto' => array(self::BELONGS_TO, 'Conceptos', 'conceptoId'),
            'cuenta' => array(self::BELONGS_TO, 'Cuentas', 'cuentaId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cuentaId' => 'Cuenta',
            'conceptoId' => 'Concepto',
            'descripcion' => 'Descripcion',
            'tipoFlujoFondos' => 'Tipo Flujo Fondos',
            'monto' => 'Monto',
            'fecha' => 'Fecha',
            'origen' => 'Origen',
            'identificadorOrigen' => 'Identificador Origen',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
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

       
        $criteria->compare('cuentaId', $this->cuentaId);
        $criteria->addBetweenCondition('fecha',$this->fechaDesde,$this->fechaHasta);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function searchByDate($fechaDesde, $fechaHasta) {
        $criteria = new CDbCriteria;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
        $criteria->condition = "fecha BETWEEN :start_day AND :end_day";
        $criteria->order = 'fecha ASC';
        $criteria->params = array(':start_day' => $fechaDesde, ':end_day' => $fechaHasta);
        $count = FlujoFondos::model()->count($criteria);

        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));

        $dataProvider->setPagination(false);
        return $dataProvider;
    }

    public function searchByDateAndCuenta($fechaDesde, $fechaHasta, $cuentaId=null) {
        $criteria = new CDbCriteria;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
        if (isset($cuentaId)) {
            $criteria->condition = "(fecha BETWEEN :start_day AND :end_day) AND cuentaId=:cuentaId";
            $criteria->params = array(
                ':start_day' => $fechaDesde,
                ':end_day' => $fechaHasta,
                ':cuentaId' => $cuentaId
            );
        } else {
            $criteria->condition = "(fecha BETWEEN :start_day AND :end_day)";
            $criteria->params = array(
                ':start_day' => $fechaDesde,
                ':end_day' => $fechaHasta,
            );
        }
        $criteria->order = 'fecha ASC';

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
        return $options[$this->tipoFlujoFondos];
    }

    public function getFechaDesde() {
        return $this->fechaDesde;
    }

    public function setFechaDesde($value) {
        $this->fechaDesde = $value;
    }

    public function getFechaHasta() {
        return $this->fechaHasta;
    }

    public function setFechaHasta($value) {
        $this->fechaHasta = $value;
    }

    public function getSaldoByDate($fechaDesde, $fechaHasta) {
        $creditoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'flujoFondos',
                    'where' => 'tipoFlujoFondos=0 AND sucursalId=:sucursalId AND fecha BETWEEN :fechaDesde AND :fechaHasta',
                    'params' => array(
                        ':sucursalId' => Yii::app()->user->model->sucursalId,
                        ':fechaDesde' => $this->fechaDesde,
                        ':fechaHasta' => $this->fechaHasta,
                    ),
                ))->queryScalar();

        $debitoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'flujoFondos',
                    'where' => 'tipoFlujoFondos=1 AND sucursalId=:sucursalId AND fecha BETWEEN :fechaDesde AND :fechaHasta',
                    'params' => array(
                        ':sucursalId' => Yii::app()->user->model->sucursalId,
                        ':fechaDesde' => $this->fechaDesde,
                        ':fechaHasta' => $this->fechaHasta,
                    ),
                ))->queryScalar();

        return $saldo = $creditoSQL - $debitoSQL;
    }

    public function getSaldo($cuentaId) {
        $creditoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'flujoFondos',
                    'where' => 'tipoFlujoFondos=0 AND sucursalId=:sucursalId AND cuentaId=:cuentaId',
                    'params' => array(
                        ':sucursalId' => Yii::app()->user->model->sucursalId,
                        ':cuentaId' => $cuentaId,
                    ),
                ))->queryScalar();

        $debitoSQL = Yii::app()->db->createCommand(array(
                    'select' => array('SUM(monto)'),
                    'from' => 'flujoFondos',
                    'where' => 'tipoFlujoFondos=1 AND sucursalId=:sucursalId AND cuentaId=:cuentaId',
                    'params' => array(
                        ':sucursalId' => Yii::app()->user->model->sucursalId,
                        ':cuentaId' => $cuentaId,
                    ),
                ))->queryScalar();

        return $saldo = $creditoSQL - $debitoSQL;
    }

    public function calcularDiferencia($total, $cuentaId) {
        $diferencia = $total - $this->getSaldo($cuentaId);
        return Yii::app()->numberFormatter->format("#,##0.00", $diferencia);
    }

   public function behaviors() {
        return array('DateTimeConversor' => array('class' => 'ext.DateTimeConversor'),
                     'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior');
    }

    public function getSaldoAcumuladoActual(){
        if(isset($this->cuentaId)){
            $criteria = new CDbCriteria();
            $criteria->condition = "id IN (SELECT MAX(id) FROM flujoFondos WHERE cuentaId=".$this->cuentaId.")";
            $model = $this->find($criteria);
            if(isset($model))
                return $model->saldoAcumulado;
            else
                return 0;
        } else return 0;
    }

}
