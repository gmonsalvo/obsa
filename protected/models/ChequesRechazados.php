<?php

/**
 * This is the model class for table "chequesRechazados".
 *
 * The followings are the available columns in table 'chequesRechazados':
 * @property integer $id
 * @property integer $pesificacionesId
 * @property integer $chequeId
 * @property string $gastosRechazo
 *
 * The followings are the available model relations:
 * @property Pesificaciones $pesificaciones
 * @property Cheques $cheque
 */
class ChequesRechazados extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ChequesRechazados the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'chequesRechazados';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pesificacionesId, chequeId', 'required'),
            array('pesificacionesId, chequeId', 'numerical', 'integerOnly' => true),
            array('gastosRechazo', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, pesificacionesId, chequeId, gastosRechazo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pesificaciones' => array(self::BELONGS_TO, 'Pesificaciones', 'pesificacionesId'),
            'cheque' => array(self::BELONGS_TO, 'Cheques', 'chequeId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'pesificacionesId' => 'Pesificaciones',
            'chequeId' => 'Cheque',
            'gastosRechazo' => 'Gastos Rechazo',
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
        $criteria->compare('pesificacionesId', $this->pesificacionesId);
        $criteria->compare('chequeId', $this->chequeId);
        $criteria->compare('gastosRechazo', $this->gastosRechazo, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getChequesRechazadosHtml($pesificacionesId) {
        $chequesRechazados = $this->findAll("pesificacionesId=:pesificacionesId", array(":pesificacionesId" => $pesificacionesId));
        $html="";
        if (count($chequesRechazados) > 0) {

            $html = "<table id='gridChequesRechazados' class='ui-widget ui-widget-content'>
                    <thead>
                        <tr class='ui-widget-header'>
                            <th>Id Cheque</th>
                            <th>Numero Cheque</th>
                            <th>Fecha Venc.</th>
                            <th>Librador</th>
                            <th>Valor Nominal</th>
                            <th>Gastos de rechazo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>";
            $html.="<tbody>";
            $totalChequesRechazados=0;
            foreach ($chequesRechazados as $chequeRechazado) {
                $cheque = $chequeRechazado->cheque;
                $html.="<tr>";
                $html.="<td>" . $cheque->id . "</td>";
                $html.="<td>" . $cheque->numeroCheque . "</td>";
                $html.="<td>" . Utilities::ViewDateFormat($cheque->fechaPago) . "</td>";
                $html.="<td>" . $cheque->librador->denominacion . "</td>";
                $html.="<td>" . $cheque->montoOrigen . "</td>";
                $html.="<td>" . $chequeRechazado->gastosRechazo . "</td>";
                $html.="<td onclick='Eliminar(this)'><span class='link'>borrar</span></td>";
                $html.="</tr>";
                $totalChequesRechazados+=$chequeRechazado->gastosRechazo;
            }
            $html.="</tbody></table>";
        }
        return $html;
    }
    
    public function getMontoTotalCheques($pesificacionesId){
        $chequesRechazados = $this->findAll("pesificacionesId=:pesificacionesId", array(":pesificacionesId" => $pesificacionesId));
        $totalChequesRechazados=0;
        if (count($chequesRechazados) > 0) {
            foreach ($chequesRechazados as $chequeRechazado) {
                $totalChequesRechazados+=$chequeRechazado->gastosRechazo;
            }
        }
        return $totalChequesRechazados;
    }
    
    public function borrarCheques($pesificacionesId){
        return $this->deleteAll("pesificacionesId=:pesificacionesId", array(":pesificacionesId" => $pesificacionesId));
    }

}