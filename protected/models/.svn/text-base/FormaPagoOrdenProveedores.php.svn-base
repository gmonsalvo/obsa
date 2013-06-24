<?php

/**
 * This is the model class for table "formaPagoOrdenProveedores".
 *
 * The followings are the available columns in table 'formaPagoOrdenProveedores':
 * @property integer $id
 * @property integer $ordenPagoId
 * @property string $monto
 * @property integer $tipoFormaPago
 * @property integer $formaPagoId
 *
 * The followings are the available model relations:
 * @property OrdenesPagoProveedores $ordenesPagoProveedores
 */
class FormaPagoOrdenProveedores extends CActiveRecord {
    const TIPO_EFECTIVO=0;
    const TIPO_CHEQUES=1;

    /**
     * Returns the static model of the specified AR class.
     * @return FormaPagoOrdenProveedores the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'formaPagoOrdenProveedores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ordenPagoId, monto, tipoFormaPago, formaPagoId', 'required'),
            array('ordenPagoId, tipoFormaPago, formaPagoId', 'numerical', 'integerOnly' => true),
            array('monto', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ordenPagoId, monto, tipoFormaPago, formaPagoId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ordenesPagoProveedores' => array(self::HAS_ONE, 'OrdenesPagoProveedores', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ordenPagoId' => 'Orden Pago',
            'monto' => 'Monto',
            'tipoFormaPago' => 'Tipo Forma Pago',
            'formaPagoId' => 'Forma Pago',
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
        $criteria->compare('ordenPagoId', $this->ordenPagoId);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('tipoFormaPago', $this->tipoFormaPago);
        $criteria->compare('formaPagoId', $this->formaPagoId);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
     public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

}