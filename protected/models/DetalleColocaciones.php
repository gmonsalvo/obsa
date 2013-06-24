<?php

/**
 * This is the model class for table "detalleColocaciones".
 *
 * The followings are the available columns in table 'detalleColocaciones':
 * @property integer $id
 * @property integer $colocacionId
 * @property integer $clienteId
 * @property string $monto
 * @property string $tasa
 *
 * The followings are the available model relations:
 * @property Colocaciones $colocacion
 * @property Clientes $cliente
 */
class DetalleColocaciones extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return DetalleColocaciones the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'detalleColocaciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('colocacionId, clienteId, monto, tasa', 'required'),
            array('colocacionId, clienteId', 'numerical', 'integerOnly' => true),
            array('monto', 'length', 'max' => 15),
            array('tasa', 'length', 'max' => 5),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, colocacionId, clienteId, monto, tasa', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'colocacion' => array(self::BELONGS_TO, 'Colocaciones', 'colocacionId'),
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'comisionOperador' => array(self::HAS_ONE, 'ComisionesOperadores', 'detalleColocacionId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'colocacionId' => 'Colocacion',
            'clienteId' => 'Cliente',
            'monto' => 'Monto',
            'tasa' => 'Tasa',
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
        $criteria->compare('colocacionId', $this->colocacionId);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('monto', $this->monto, true);
        $criteria->compare('tasa', $this->tasa, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getDetalleColocaciones($idColocacion, $idCliente) {

        $colocacion = Colocaciones::model()->findByPk($idColocacion);
        //$clearing = $colocacion->cheque->clearing;
        $fechaFin = Utilities::ViewDateFormat($colocacion->cheque->fechaPago);

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        //$criteria->condition = "detalleColocaciones.clienteId='" . $idCliente . "' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND t.id=colocaciones.chequeId AND t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";

        $criteria->condition = "t.colocacionId='" . $idColocacion . "'";
        $detalleColocaciones = $this->findAll($criteria);

        $html = "<table id='colocaciones' class='ui-widget ui-widget-content'>
                <thead>
                    <tr class='ui-widget-header'>
                    <th>Id Inversor</th>
                    <th>Razon social</th>
                    <th>Monto colocado</th>
                    <th>Monto valor actual</th>
                    <th>Tasa</th>
                    <th>Eliminar</th>
                    </tr>
                </thead>
            <tbody>";
        foreach ($detalleColocaciones as $detalleColocacion) {
            $html.="<tr><td>" . $detalleColocacion->cliente->id . "</td>";
            $html.="<td>" . $detalleColocacion->cliente->razonSocial . "</td>";
            $html.="<td>" . Utilities::MoneyFormat($detalleColocacion->monto) . "</td>";

            $valorActual = $colocacion->calculoValorActual($detalleColocacion->monto, $fechaFin, $detalleColocacion->tasa, $colocacion->getClearing());
            $html.="<td>" . Utilities::MoneyFormat($valorActual) . "</td>";
            $html.="<td>" . $detalleColocacion->tasa . "</td>";
            //si el id cliente es 0 todos los clientes se pueden recolocar
//            if ($idCliente == $detalleColocacion->clienteId || $idCliente == 0)
                $html.="<td onclick='Eliminar(this)'><span class='link'>borrar</span></td></tr>";
//            else
//                $html.="<td>--</td></tr>";
        }
        $html.="
            </tbody>
        </table>";
        return $html;
    }

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

}