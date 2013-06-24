<?php

/**
 * This is the model class for table "ctacteProveedores".
 *
 * The followings are the available columns in table 'ctacteProveedores':
 * @property integer $id
 * @property integer $tipoMov
 * @property integer $proveedorId
 * @property integer $conceptoId
 * @property string $descripcion
 * @property string $monto
 * @property string $fecha
 * @property string $documentoRelacionado
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property Conceptos $concepto
 * @property Proveedores $proveedor
 * @property Sucursales $sucursal
 */
class CtacteProveedores extends CustomCActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return CtacteProveedores the static model class
     */
    // Tipos de movimientos
    const TYPE_CREDITO=0;
    const TYPE_DEBITO=1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ctacteProveedores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tipoMov, proveedorId, conceptoId, monto, fecha, sucursalId', 'required'),
            array('tipoMov, proveedorId, conceptoId, estado, sucursalId', 'numerical', 'integerOnly' => true),
            array('descripcion', 'length', 'max' => 255),
            array('monto', 'length', 'max' => 15),
            array('documentoRelacionado, userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, tipoMov, proveedorId, conceptoId, descripcion, monto, fecha, documentoRelacionado, estado, userStamp, timeStamp, sucursalId', 'safe', 'on' => 'search'),
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
            'proveedor' => array(self::BELONGS_TO, 'Proveedores', 'proveedorId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tipoMov' => 'Tipo Mov',
            'proveedorId' => 'Proveedor',
            'conceptoId' => 'Concepto',
            'descripcion' => 'Descripcion',
            'monto' => 'Monto',
            'fecha' => 'Fecha',
            'documentoRelacionado' => 'Documento Relacionado',
            'estado' => 'Estado',
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
        $criteria->compare('tipoMov', $this->tipoMov);
        $criteria->compare('proveedorId', $this->proveedorId);
        $criteria->compare('conceptoId', $this->conceptoId);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('documentoRelacionado', $this->documentoRelacionado, true);
        $criteria->compare('estado', $this->estado);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    protected function beforeValidate() {
        $this->conceptoId = 7; //corregir en la base.
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
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
        $creditoSQL = "SELECT SUM(monto) FROM ctacteProveedores WHERE proveedorId=" . $this->proveedorId .
                " AND tipoMov=0 AND sucursalId=" . Yii::app()->user->model->sucursalId;
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        $debitoSQL = "SELECT SUM(monto) FROM ctacteProveedores WHERE proveedorId=" . $this->proveedorId .
                " AND tipoMov=1 AND sucursalId=" . Yii::app()->user->model->sucursalId;
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        return $saldo = $creditoQRY - $debitoQRY;
    }

    public function behaviors() {
        return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'),
                     'LoggableBehavior' =>'application.modules.auditTrail.behaviors.LoggableBehavior');
    }

}