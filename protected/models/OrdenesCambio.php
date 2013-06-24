<?php

/**
 * This is the model class for table "ordenesCambio".
 *
 * The followings are the available columns in table 'ordenesCambio':
 * @property integer $id
 * @property integer $operacionCambioId
 * @property string $fecha
 * @property string $monto
 * @property string $descripcion
 * @property integer $estado
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property OperacionesCambio $operacionCambio
 */
class OrdenesCambio extends CustomCActiveRecord {
    const ESTADO_PENDIENTE=0;
    const ESTADO_PAGADA=1;
    const ESTADO_ANULADA=2;

    const ORIGEN_OPERACION_COMPRA=0;
    const ORIGEN_OPERACION_RETIRO_FONDOS=1;
    const ORIGEN_OPERACION_COMPRA_DOLARES=2;
    const ORIGEN_OPERACION_VENTA_DOLARES=3;

    /**
     * Returns the static model of the specified AR class.
     * @return OrdenesCambio the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ordenesCambio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operacionCambioId, fecha, monto, estado, sucursalId, userStamp, timeStamp', 'required'),
            array('operacionCambioId, estado, sucursalId', 'numerical', 'integerOnly' => true),
            array('monto', 'length', 'max' => 15),
            array('descripcion', 'length', 'max' => 100),
            array('userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, operacionCambioId, fecha, monto, descripcion, estado, sucursalId, userStamp, timeStamp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'operacionCambio' => array(self::BELONGS_TO, 'OperacionesCambio', 'operacionCambioId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'operacionCambioId' => 'Operacion Cambio',
            'fecha' => 'Fecha',
            'monto' => 'Monto',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
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
        $criteria->compare('operacionCambioId', $this->operacionCambioId);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('estado', $this->estado);
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

}