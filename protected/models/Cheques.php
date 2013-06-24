<?php

/**
 * This is the model class for table "cheques".
 *
 * The followings are the available columns in table 'cheques':
 * @property integer $id
 * @property integer $operacionChequeId
 * @property string $tasaDescuento
 * @property integer $clearing
 * @property string $pesificacion
 * @property integer $numeroCheque
 * @property integer $libradorId
 * @property integer $bancoId
 * @property string $montoOrigen
 * @property string $fechaPago
 * @property integer $tipoCheque
 * @property string $endosante
 * @property string $montoNeto
 * @property integer $estado
 * @property integer $tieneNota
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 * @property integer $comisionado
 *
 * The followings are the available model relations:
 * @property Bancos $banco
 * @property Libradores $librador
 * @property OperacionesCheques $operacionCheque
 * @property Sucursales $sucursal
 */
class Cheques extends CustomCActiveRecord {
    //Tipo de cheque
    const TYPE_VENTANILLA=0;
    const TYPE_CRUZADO=1;
    const TYPE_NO_A_LA_ORDEN=2;
    const TYPE_A_LEVANTAR=3;

    //Estado del cheque
    const TYPE_EN_CARTERA_SIN_COLOCAR=0;
    const TYPE_RECHAZADO=1;
    const TYPE_EN_CLIENTE_INVERSOR=2;
    const TYPE_ACREDITADO=3;
    const TYPE_EN_CARTERA_COLOCADO=4;
    const TYPE_EN_PESIFICADOR=5;
    const TYPE_CORRIENTE=6;
    const TYPE_ANULADO = 7;


    /**
     * Returns the static model of the specified AR class.av
     * @return Cheques the static model class
     */
    //usadas para hacer filtros en las busquedas, no tienen persistencia
    public $fechaIni, $fechaFin;
    public $librador_denominacion;
    public $banco_nombre;
    private $porcentaje;
    //suma de los montos de cheques
    public $total;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cheques';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operacionChequeId, tasaDescuento, libradorId, bancoId, montoOrigen, fechaPago, estado, userStamp, timeStamp, sucursalId', 'required'),
            array('operacionChequeId, clearing, libradorId, bancoId, tipoCheque, estado, sucursalId, tieneNota', 'numerical', 'integerOnly' => true),
            array('tasaDescuento, pesificacion', 'length', 'max' => 7),
            array('numeroCheque', 'length', 'max' => 45),
            array('montoOrigen, montoNeto, montoGastos', 'length', 'max' => 15),
            array('endosante', 'length', 'max' => 100),
            array('userStamp', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, operacionChequeId, tasaDescuento, clearing, pesificacion, numeroCheque, libradorId, bancoId, montoOrigen, fechaPago, tipoCheque, endosante, montoNeto, estado, userStamp, timeStamp, sucursalId, fechaIni, fechaFin, librador_denominacion, tieneNota', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'banco' => array(self::BELONGS_TO, 'Bancos', 'bancoId'),
            'librador' => array(self::BELONGS_TO, 'Libradores', 'libradorId'),
            'operacionCheque' => array(self::BELONGS_TO, 'OperacionesCheques', 'operacionChequeId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'operacionChequeId' => 'Operacion Cheque',
            'tasaDescuento' => 'Tasa Descuento',
            'clearing' => 'Clearing',
            'pesificacion' => 'Pesificacion',
            'numeroCheque' => 'Numero Cheque',
            'libradorId' => 'Librador',
            'bancoId' => 'Banco',
            'montoOrigen' => 'Monto Origen',
            'fechaPago' => 'Fecha Pago',
            'tipoCheque' => 'Tipo Cheque',
            'endosante' => '2do Endoso',
            'montoNeto' => 'Monto Neto',
            'estado' => 'Estado',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'sucursalId' => 'Sucursal',
            'montoGastos' => 'Monto Gastos',
            'tieneNota' => 'Tiene Nota'
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
        $criteria->compare('operacionChequeId', $this->operacionChequeId);
        $criteria->compare('tasaDescuento', $this->tasaDescuento, true);
        $criteria->compare('clearing', $this->clearing);
        $criteria->compare('pesificacion', $this->pesificacion, true);
        $criteria->compare('numeroCheque', $this->numeroCheque, true);

        if ($this->librador_denominacion) {
            $criteria->together = true;
            $criteria->with = array('librador');
            $criteria->compare('librador.denominacion', $this->librador_denominacion, true);
        }
        //$criteria->compare('libradorId', $this->libradorId);
        $criteria->compare('bancoId', $this->bancoId);
        $criteria->compare('montoOrigen', $this->montoOrigen, true);
        $criteria->compare('fechaPago', $this->fechaPago, true);
        $criteria->compare('tipoCheque', $this->tipoCheque);
        $criteria->compare('endosante', $this->endosante, true);
        $criteria->compare('montoNeto', $this->montoNeto, true);
        $criteria->compare('estado', $this->estado);
        $criteria->addNotInCondition('estado',array('7'));
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

        $sort = new CSort;
        $sort->attributes = array(
            'librador' => array(
                'asc' => 'denominacion',
                'desc' => 'denominacion DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchToday() {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'banco',
            'librador',
        );
//        $criteria->select = 't.*';
        $criteria->join = 'JOIN bancos ON bancos.id = bancoId';
        $criteria->join = 'JOIN libradores ON libradores.id = libradorId';
        $criteria->join = 'JOIN operacionesCheques ON operacionesCheques.id = operacionChequeId';
        $criteria->condition = 'operacionChequeId = operacionesCheques.id AND operacionesCheques.fecha=:fechaHoy';
        $criteria->params = array(':fechaHoy' => date('Y-m-d'));
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));

        $dataProvider->setPagination(false);
        return $dataProvider;
    }

    public function searchByFecha2($fechaIni, $fechaFin) {
        $criteria = new CDbCriteria;
        $this->fechaIni = $fechaIni;
        $this->fechaIni = $fechaFin;
        $criteria->condition = "fechaPago BETWEEN :start_day AND :end_day";
        $criteria->order = 'fechaPago ASC';
        $criteria->params = array(':start_day' => $fechaIni, ':end_day' => $fechaFin);
        //if((isset($this->fechaIni) && trim($this->fechaIni) != "") && (isset($this->fechaFin) && trim($this->fechaFin) != ""))
        //  $criteria->addBetweenCondition('fechaPago', ''.$this->fechaFin.'', ''.$this->fechaFin.'');
        $count = Cheques::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        //$pages->createPageUrl(new ChequesController,$page);
        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        $dataProvider->setPagination($pages);
        return $dataProvider;
    }

    public function getTypeOptions($type) {
        switch ($type) {
            case 'tipoCheque':
                return array(
                    self::TYPE_VENTANILLA => 'Ventanilla',
                    self::TYPE_CRUZADO => 'Cruzado',
                    self::TYPE_NO_A_LA_ORDEN => 'No a la orden',
                    self::TYPE_A_LEVANTAR => 'A levantar',
                );
            case 'estado':
                return array(
                    self::TYPE_EN_CARTERA_SIN_COLOCAR => 'En cartera sin colocar',
                    self::TYPE_RECHAZADO => 'Rechazado',
                    self::TYPE_EN_CLIENTE_INVERSOR => 'En cliente inversor',
                    self::TYPE_ACREDITADO => 'Acreditado',
                    self::TYPE_EN_CARTERA_COLOCADO => 'En cartera colocado',
                    self::TYPE_EN_PESIFICADOR => 'En pesificador',
                    self::TYPE_CORRIENTE => 'Cheque corriente',
                    self::TYPE_ANULADO => 'Cheque Anulado',
                );
            default:
                return array();
        }
    }

    public function getTypeDescription($type) {
        $options = array();
        $options = $this->getTypeOptions($type);
        return $options[$this->$type];
    }

    public function listData($models, $valueField, $textFields, $groupField = '') {

        $listData = array();

        foreach ($models as $model) {
            $value = CHtml::value($model, $valueField);
            if (is_array($textFields)) {
                $text = array();
                foreach ($textFields as $attr) {
                    $text[] = CHtml::value($model, $attr);
                }
                $text = implode(' ', $text);
            }
            else
                $text = CHtml::value($model, $textFields);

            if ($groupField === '') {
                $listData[$value] = $text;
            } else {
                $group = CHtml::value($model, $groupField);
                $listData[$group][$value] = $text;
            }
        }
        return $listData;
    }

    public function getFechaIni() {
        return $this->fechaIni;
    }

    public function setFechaIni($value) {
        $this->fechaIni = $value;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setFechaFin($value) {
        $this->fechaFin = $value;
    }

    public function searchChequesByEstado($estado, $chequesId=array()) {
        $criteria = new CDbCriteria;
        //si es que hay una lista de ids que no deben estar incluido
        if(!empty($chequesId)){
            $criteria->addNotInCondition('id', $chequesId);
        } else
            $criteria->compare('id', $this->id);
        $criteria->compare('estado', $estado, "OR");
        $criteria->compare('numeroCheque', $this->numeroCheque);
//        $criteria->with=array('librador'=>array("denominacion"));
//        $criteria->compare('denominacion', $this->librador,TRUE);


        if ($this->librador_denominacion) {
            $criteria->together = true;
            $criteria->with = array('librador');
            $criteria->compare('librador.denominacion', $this->librador_denominacion, true);
        }
        if ($this->banco_nombre) {
            $criteria->together = true;
            $criteria->with = array('banco');
            $criteria->compare('banco.nombre', $this->banco_nombre, true);
        }


        $sort = new CSort;
        $sort->attributes = array(
            'librador' => array(
                'asc' => 'denominacion',
                'desc' => 'denominacion DESC',
            ),
            'banco' => array(
                'asc' => 'nombre',
                'desc' => 'nombre DESC',
            ),
            '*',
        );

        //$criteria->condition =$query;
        //$criteria->order = 'fechaPago ASC';

        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                ));

        //$lista=Cheques::model()->findAll($criteria);
        return $dataProvider;
    }

    public function searchChequesColocadosPorInversor($idCliente) {
        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        //$criteria->condition = "detalleColocaciones.clienteId='" . $idCliente . "' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND t.id=colocaciones.chequeId AND t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";

        $criteria->condition = "t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "' AND t.id IN (SELECT colocaciones.chequeId FROM colocaciones, detalleColocaciones WHERE colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND detalleColocaciones.clienteId='" . $idCliente . "')";
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }

    public function searchByFechaAndEstado($fechaIni, $fechaFin, $estado, $chequesId=array()) {
        $criteria = new CDbCriteria;
        $this->fechaIni = $fechaIni;
        $this->fechaIni = $fechaFin;
        //$estado=Cheques::TYPE_EN_CARTERA_SIN_COLOCAR;
        if (is_array($estado)) {
            $query = " AND (";
            for ($i = 0; $i < count($estado); $i++) {
                if ($i != count($estado) - 1)
                    $query.="t.estado='" . $estado[$i] . "' OR ";
                else
                    $query.="t.estado='" . $estado[$i] . "')";
            }
        }
        else {
            $query = "t.estado='" . $estado . "'";
        }
        if(!empty($chequesId)){
            $query.=" AND t.id NOT IN (";
            for($i=0;$i<count($chequesId);$i++)
            $query.="$chequesId[0],";
            $query= substr($query, 0,count($query)-2);
            $query.=") ";
        }
        //$criteria->compare('estado', $estado, "OR");

        $criteria->condition = "(t.fechaPago BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "')".$query;
        $criteria->order = 't.fechaPago ASC';
        //$criteria->params = array(':start_day' => $fechaIni, ':end_day' => $fechaFin);

        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }

    /**
     * @return activeRecords con los cheques colocados por sucursal
     */
    public function findChequesColocadosDelDia() {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'JOIN operacionesCheques ON operacionesCheques.id = t.operacionChequeId';
        $criteria->condition = 't.operacionChequeId = operacionesCheques.id AND operacionesCheques.fecha=:fechaHoy AND t.estado=:estado AND t.sucursalId=:sucursalId AND t.comisionado=0';

        $criteria->params = array(':fechaHoy' => date('Y-m-d'), ":estado" => self::TYPE_EN_CARTERA_COLOCADO, ":sucursalId" => Yii::app()->user->model->sucursalId);
        return $this->findAll($criteria);
    }

    /* public function behaviors()
      {
      return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'));
      } */

    public function getPorcentaje($idCliente){
        $this->porcentaje=$idCliente;
        return $this->porcentaje;
    }
}