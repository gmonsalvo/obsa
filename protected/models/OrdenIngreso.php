<?php

/**
 * This is the model class for table "ordenIngreso".
 *
 * The followings are the available columns in table 'ordenIngreso':
 * @property integer $id
 * @property integer $productoCtaCteId
 * @property string $fecha
 * @property string $monto
 * @property string $descripcion
 * @property integer $estado
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $tipo
 * @property integer $identificadorOrigen
 * @property string $origen
 */
class OrdenIngreso extends CustomCActiveRecord {
    const ESTADO_PENDIENTE=0;
    const ESTADO_PAGADA=1;
    const ESTADO_ANULADA=2;

    const TIPO_DEPOSITO = 0;
    const TIPO_PESIFICACION_INDIVIDUAL = 1;

	public $nombreCliente;
    public $cliente;
    public $pkModeloRelacionado;
    public $productoId;

    /**
     * Returns the static model of the specified AR class.
     * @return OrdenIngreso the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ordenIngreso';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha, monto, sucursalId, userStamp, timeStamp', 'required'),
            array('productoCtaCteId, estado, sucursalId, tipo, identificadorOrigen', 'numerical', 'integerOnly' => true),
            array('monto', 'length', 'max' => 15),
            array('descripcion', 'length', 'max' => 100),
            array('productoId, userStamp, origen', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, productoCtaCteId, fecha, monto, descripcion, estado, sucursalId, userStamp, timeStamp, tipo, identificadorOrigen, origen', 'safe', 'on' => 'search'),
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
            'productoCtaCte' => array(self::BELONGS_TO, 'Productoctacte', 'productoCtaCteId',),
            'productoCtaCte2' => array(self::BELONGS_TO, 'Productoctacte', 'pkModeloRelacionado',),
            //'productosCliente' => array(self::HAS_MANY, 'Productoctacte', 'pkModeloRelacionado'),
            'clientes' => array(self::HAS_MANY, 'Clientes', 'clienteId', 
                            'through'=>'productoCtaCte', 
                            'condition' => 'productoCtaCte.nombreModelo=\'Clientes\' and productoCtaCte.pkModeloRelacionado=t.clienteId'),

            'producto' => array(self::HAS_ONE, 'Productos','productoId',
                            'through'=>'productoCtaCte2', 
                            'condition' => 'productoCtaCte2.productoId=producto.id',
                            ),
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fecha' => 'Fecha',
            'cliente' => 'Cliente',
            'monto' => 'Monto',
            'descripcion' => 'Descripcion',
            'productoId' => 'Producto',
            'estado' => 'Estado',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'tipo' => 'Tipo',
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
        //$criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        //$criteria->compare('productoId', $this->productoId, true);
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


    public function behaviors() {
        return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'),
                     'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior');
    }

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
        $criteria->condition = "fecha=:fecha AND sucursalId=:sucursalId";
        $criteria->params = array(':fecha' => $fecha,':sucursalId' => Yii::app()->user->model->sucursalId);
        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function afterFind() {

        if (isset($his->Productoctacte)) {
            $this->pkModeloRelacionado = $this->Productoctacte->pkmodeloRelacionadoId;    
            $this->productoId = $this->Productoctacte->productoId;
        } else {
            $this->pkModeloRelacionado = 0;
        }        


        return parent::afterFind();
    }


}