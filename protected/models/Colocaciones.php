<?php

/**
 * This is the model class for table "colocaciones".
 *
 * The followings are the available columns in table 'colocaciones':
 * @property integer $id
 * @property string $fecha
 * @property integer $chequeId
 * @property string $montoTotal
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $estado
 * @property integer $colocacionAnteriorId
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 * @property Cheques $cheque
 * @property DetalleColocaciones[] $detalleColocaciones
 * @property integer $diasColocados
 */
class Colocaciones extends CustomCActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return Colocaciones the static model class
     */
    const ESTADO_INACTIVA = 0;
    const ESTADO_ACTIVA = 1;

    public $totalTasas;
    public $totalRegistros;
    public $total;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'colocaciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha, chequeId, montoTotal, sucursalId, userStamp, timeStamp, diasColocados', 'required'),
            array('chequeId, sucursalId, estado, colocacionAnteriorId, diasColocados', 'numerical', 'integerOnly' => true),
            array('montoTotal', 'length', 'max' => 15),
            array('userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, fecha, chequeId, montoTotal, sucursalId, userStamp, timeStamp, estado, colocacionAnteriorId, diasColocados', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'cheque' => array(self::BELONGS_TO, 'Cheques', 'chequeId'),
            'detalleColocaciones' => array(self::HAS_MANY, 'DetalleColocaciones', 'colocacionId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fecha' => 'Fecha',
            'chequeId' => 'Cheque',
            'montoTotal' => 'Monto Total',
            'estado' => 'Estado',
            'colocacionAnteriorId' => 'Colocacion anterior',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'diasColocados' => 'Dias Colocados',
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
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('chequeId', $this->chequeId);
        $criteria->compare('montoTotal', $this->montoTotal, true);
        $criteria->compare('sucursalId', $this->sucursalId);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function calculoValorActual($montoOrigen, $fechaFin, $tasa, $clearing) {

        $fechaInicio = !empty($this->fecha) ? Utilities::ViewDateFormat($this->fecha) : Date("d-m-Y");
        $fecFin = new DateTime(Utilities::MysqlDateFormat($fechaFin));
        #si la fecha de fin es mayor que la fecha de hoy. La fecha de fin pasa a ser la fecha de hoy 
        $hoy = new DateTime();
        if($fecFin<$hoy)
            $fechaFin = Date("d-m-Y");

        $dias = Utilities::RestarFechas($fechaInicio, $fechaFin);
        $C = $montoOrigen;
        $n = $dias + $clearing;
        $i = $tasa / 100;

        $divisor = 1 + (($i * $n) / 365);
        $resultado = Utilities::truncateFloat(($C / $divisor), 2);

        return $resultado;
    }

    public function getTypeOptions() {
        return array(
            self::ESTADO_INACTIVA => 'Inactiva',
            self::ESTADO_ACTIVA => 'Activa',
        );
    }

    public function getTypeDescription() {
        $options = array();
        $options = $this->getTypeOptions();
        return $options[$this->tipoCliente];
    }

    public function getColocacionActiva($chequeId) {
        $criteria = new CDbCriteria();
        $criteria->condition = "estado=:estado AND chequeId=:chequeId";
        $criteria->params = array(":estado" => self::ESTADO_ACTIVA, ":chequeId" => $chequeId);
        return $this->find($criteria);
    }

    public function getTasaAnualPromedio($clienteId) {
        $criteriaColocaciones = new CDbCriteria();
        $criteriaColocaciones->select = "SUM(detalleColocaciones.tasa) as totalTasas, COUNT(*) as totalRegistros";

        $criteriaColocaciones->condition = "detalleColocaciones.clienteId=:clienteId AND t.estado=:estado";
        $criteriaColocaciones->join = "JOIN detalleColocaciones ON detalleColocaciones.colocacionId = t.id";
        $criteriaColocaciones->params = array(
            ':clienteId' => $clienteId,
            ':estado' => Colocaciones::ESTADO_ACTIVA);
        $colocaciones = Colocaciones::model()->find($criteriaColocaciones);
        if ($colocaciones->totalRegistros != 0) {
            $tasaPromedio = $colocaciones->totalTasas / $colocaciones->totalRegistros;
            return Utilities::truncateFloat($tasaPromedio, 2);
        }else
            return 0;
    }

    public function getColocacionesCliente($clienteId) {
        $criteriaColocaciones = new CDbCriteria();
        $criteriaColocaciones->condition = "detalleColocaciones.clienteId=:clienteId AND t.estado=:estado";
        $criteriaColocaciones->join = "JOIN detalleColocaciones ON detalleColocaciones.colocacionId = t.id";
        $criteriaColocaciones->params = array(
            ':clienteId' => $clienteId,
            ':estado' => Colocaciones::ESTADO_ACTIVA);
        $colocaciones = Colocaciones::model()->findAll($criteriaColocaciones);
        return $colocaciones;
    }

    public function getClearing(){
        // ya viene en formato dd-mm-YY
        $fechaInicio=$this->cheque->operacionCheque->fecha;
        $fechaFin=Utilities::ViewDateFormat($this->cheque->fechaPago);
        $clearing=$this->diasColocados - Utilities::RestarFechas3($fechaInicio,$fechaFin);
        return $clearing;
    }

}
