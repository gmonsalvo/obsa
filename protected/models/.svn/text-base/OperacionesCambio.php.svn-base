<?php

/**
 * This is the model class for table "operacionesCambio".
 *
 * The followings are the available columns in table 'operacionesCambio':
 * @property integer $id
 * @property integer $clienteId
 * @property integer $monedaId
 * @property string $monto
 * @property string $tasaCambio
 * @property integer $tipoOperacion
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property Clientes $cliente
 * @property Monedas $moneda
 */
class OperacionesCambio extends CustomCActiveRecord {
    //Tipo de cheque
    const TYPE_COMPRA=0;
    const TYPE_VENTA=1;

    /**
     * Returns the static model of the specified AR class.
     * @return OperacionesCambio the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'operacionesCambio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('clienteId,fecha,tasaCambio, monedaId, monto, tipoOperacion', 'required'),
            array('clienteId, monedaId, tipoOperacion, sucursalId', 'numerical', 'integerOnly' => true),
            array('tasaCambio', 'numerical'),
            array('monto', 'length', 'max' => 15),
            array('userStamp', 'length', 'max' => 45),
            array('timeStamp', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, clienteId,fecha,tasaCambio monedaId, monto, tipoOperacion, userStamp, timeStamp, sucursalId', 'safe', 'on' => 'search'),
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
            'moneda' => array(self::BELONGS_TO, 'Monedas', 'monedaId'),
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
            'monedaId' => 'Moneda',
            'monto' => 'Monto',
            'tipoOperacion' => 'Tipo Operacion',
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
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('fecha', $this->fecha);
        $criteria->compare('monedaId', $this->monedaId);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('tipoOperacion', $this->tipoOperacion);
        $criteria->compare('tasaCambio', $this->tasaCambio);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }


    public function getTypeOptions() {


        return array(
            self::TYPE_COMPRA => 'COMPRA',
            self::TYPE_VENTA => 'VENTA',
        );
    }

    public function behaviors() {
        return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'),
                     'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior');
    }
    
    public function getSaldoHoy()
    {
        		$fechaHoy = Date('Y-m-d');
		$creditoSQL = Yii::app()->db->createCommand(array(
			'select' => array('SUM(monto)'),
			'from' => 'operacionesCambio',
			'where' => 'tipoOperacion=:tipoOperacion AND sucursalId=:sucursalId AND fecha=:fechaHoy',
			'params' => array(
                                                        ':tipoOperacion'=>  self::TYPE_COMPRA,
							':sucursalId'=>Yii::app()->user->model->sucursalId, 
							':fechaHoy'=>$fechaHoy,
						),
		))->queryScalar();

		$debitoSQL = Yii::app()->db->createCommand(array(
			'select' => array('SUM(monto)'),
			'from' => 'operacionesCambio',
			'where' => 'tipoOperacion=:tipoOperacion AND sucursalId=:sucursalId AND fecha=:fechaHoy',
			'params' => array(
                                                        ':tipoOperacion'=>  self::TYPE_VENTA,
							':sucursalId'=>Yii::app()->user->model->sucursalId, 
							':fechaHoy'=>$fechaHoy,
			),
		))->queryScalar();
				
		return $saldo = $creditoSQL - $debitoSQL;
    }
    

}