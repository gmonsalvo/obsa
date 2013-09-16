<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id
 * @property string $razonSocial
 * @property string $fijo
 * @property string $celular
 * @property string $direccion
 * @property integer $localidadId
 * @property integer $provinciaId
 * @property string $email
 * @property string $documento
 * @property string $tasaInversor
 * @property integer $tipoCliente
 * @property integer $operadorId
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property string $tasaTomador
 * @property string $montoMaximoTomador
 * @property string $montoPermitidoDescubierto
 * The followings are the available model relations:
 * @property Apoderados[] $apoderadoses
 * @property Beneficiarios[] $beneficiarioses
 * @property Operadores $operador
 * @property Sucursales $sucursal
 * @property OperacionesCheques[] $operacionesCheques
 */
class Clientes extends CustomCActiveRecord {

    ////// Propiedades
    
    const TYPE_TOMADOR=0;
    const TYPE_INVERSOR=1;
    const TYPE_TOMADOR_E_INVERSOR=2;

    private $saldo;
    private $saldoColocaciones;
    private $montoColocaciones;
    private $porcentajeInversion;
	public $productosBusqueda;
	public $productosId;

	////// Métodos nuevos

	public function behaviors()
	{
    	return array(
        	'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior',
            'activerecord-relation'=>array('class'=>'ext.yiiext.behaviors.activerecord-relation.EActiveRecordRelationBehavior',),
    	);
	}	
	
	public function beforeValidate()
	{
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
		
		return parent::beforeValidate();; 
	}
	
    public function searchInversoresParaColocacion($filtrarSaldoNegativo = false) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "(t.tipoCliente=" . self::TYPE_INVERSOR . " OR t.tipoCliente=" . self::TYPE_TOMADOR_E_INVERSOR . ")";
        $criteria->order = ' t.tasaInversor ASC';

        //filtro para no tomar los inversores cuyo saldo sea negativo
        $inversores = $this->findAll($criteria);
        $inversoresIds = array();
        foreach ($inversores as $inversor) {
            $saldo = $inversor->getSaldo();
            if($saldo != 0) {
                if(!$filtrarSaldoNegativo)
                    $inversoresIds[] = $inversor->id;
                else {
                    if($saldo > 0)
                        $inversoresIds[] = $inversor->id;
                }
            }
        }
        $criteria = new CDbCriteria();
        $criteria->compare('id', $inversoresIds, "OR");
        $criteria->compare('razonSocial', $this->razonSocial, true);
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria
                ));

        return $dataProvider;
    }

    public function searchInversoresParaColocacion2() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "(t.tipoCliente=" . self::TYPE_INVERSOR . " OR t.tipoCliente=" . self::TYPE_TOMADOR_E_INVERSOR . ")";
        $criteria->order = ' t.tasaInversor ASC';

        //filtro para no tomar los inversores cuyo saldo sea negativo
        $inversores = $this->findAll($criteria);
        $inversoresIds = array();
        foreach ($inversores as $inversor) {
            if ($inversor->getSaldo() > 0)
                $inversoresIds[] = $inversor->id;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('id', $inversoresIds, "OR");
        $criteria->compare('razonSocial', $this->razonSocial, true);
        $clientes=Clientes::model()->findAll($criteria);

        $rawData = array();
        $i = 1;
        foreach ($clientes as $cliente) {
            $rawData[] = array('id' => $cliente->id, 'razonSocial' => $cliente->razonSocial, 'saldo' => $cliente->getSaldo(), 'porcentaje' => $cliente->getPorcentajeInversion() , 'tasaInversor' => $cliente->tasaInversor, 'operador'=>$cliente->operador->apynom);
            $i++;
        }

        $arrayDataProvider = new CArrayDataProvider($rawData, array(
                    'id' => 'id',
                    'sort' => array(
                        'defaultOrder' => 'porcentaje DESC',
                        'attributes' => array(
                            'porcentaje'
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));

        return $arrayDataProvider;
    }

    public function getTypeOptions() {
        return array(
            self::TYPE_TOMADOR_E_INVERSOR => 'Tomador e Inversor',
            self::TYPE_TOMADOR => 'Tomador',
            self::TYPE_INVERSOR => 'Inversor',

        );
    }

    public function getTypeDescription() {
        $options = array();
        $options = $this->getTypeOptions();
        return $options[$this->tipoCliente];
    }

	public function getSaldo() {

			$productoCliente = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", array(":clienteId" => $this->id, ":productoId" => $this->productosId, ":nombreModelo" => "Clientes"));
			
			if (!$productoCliente)
				return false;

           $ctaCte=new Ctacte();
		   $ctaCte->productoCtaCteId=$productoCliente->id;
           //$ctaCte->clienteId=$this->id;
		   //$ctaCte->productoId=0;
           $this->saldo=$ctaCte->getSaldoAcumuladoActual();
		   
        // $creditoSQL = "SELECT SUM(monto) FROM ctacteClientes WHERE clienteId='" . $this->id . "' AND tipoMov=0 AND productoId=1 AND sucursalId=" . Yii::app()->user->model->sucursalId;
        // $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        // $debitoSQL = "SELECT SUM(monto) FROM ctacteClientes WHERE clienteId='" . $this->id . "' AND tipoMov=1 AND productoId=1 AND sucursalId=" . Yii::app()->user->model->sucursalId;
        // $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        // $this->saldo = $creditoQRY - $debitoQRY;
        return $this->saldo;
    }

    public function setSaldo($saldo){
        $this->saldo=$saldo;
    }

    public function getSaldoColocaciones() {

        $sql = "SELECT detalleColocaciones.*,cheques.fechaPago, cheques.clearing FROM detalleColocaciones, colocaciones, cheques WHERE detalleColocaciones.clienteId='" . $this->id . "' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND cheques.id=colocaciones.chequeId AND cheques.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";
        $detalleColocaciones = Yii::app()->db->createCommand($sql)->queryAll($sql);
        if (count($detalleColocaciones) > 0) {
            $this->saldoColocaciones = 0;
            for ($i = 0; $i < count($detalleColocaciones); $i++){
                $colocacion = Colocaciones::model()->findByPk($detalleColocaciones[$i]["colocacionId"]);

                $this->saldoColocaciones+=$colocacion->calculoValorActual($detalleColocaciones[$i]['monto'], Utilities::ViewDateFormat($colocacion->cheque->fechaPago), $detalleColocaciones[$i]['tasa'], $colocacion->getClearing());
            }
        }

        return $this->saldoColocaciones;
    }

    public function setSaldoColocaciones($saldoColocaciones){
        $this->saldoColocaciones=$saldoColocaciones;
    }

    public function getClientesColocacion($idColocacion) {
        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        //$criteria->condition = "detalleColocaciones.clienteId='" . $idCliente . "' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND t.id=colocaciones.chequeId AND t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";

        $criteria->condition = "t.id IN (SELECT detalleColocaciones.clienteId from detalleColocaciones where detalleColocaciones.colocacionId='" . $idColocacion . "')";
        $clientes = $this->findAll($criteria);
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));

        $html = "<table id='colocaciones' class='ui-widget ui-widget-content'>
                <thead>
                    <tr class='ui-widget-header'>
                    <th>Id Inversor</th>
                    <th>Razon social</th>
                    <th>Monto colocado</th>
                    <th>Tasa</th>
                    <th>Eliminar</th>
                    </tr>
                </thead>
            <tbody>";
        foreach ($clientes as $cliente) {
            $html.="<tr><td>" . $cliente->id . "</td>";
            $html.="<td>" . $cliente->razonSocial . "</td>";
        }
        $html.="
            </tbody>
        </table>";
        return $clientes;
    }

    public function findClientesPorTipo($tipo) {
        $criteria = new CDbCriteria();
        $criteria->compare('tipoCliente', $tipo, "OR");
        return $this->findAll($criteria);
    }

    /**
     * Obtiene cual es el porcentaje de tenencia de un inversor sobre un cheque colocado. Vale para la colocacion activa
     * @return float Porcentaje en numero
     */
    
    public function getPorcentajeTenencia($chequeId=null, $clienteId, $colocacionId=null) {
        if (isset($clienteId)) {
            if (!isset($colocacionId)) {
                $criteria = new CDbCriteria();
                $criteria->condition = "chequeId=:chequeId AND estado=:estado";
                $criteria->params = array(":chequeId" => $chequeId, ":estado" => Colocaciones::ESTADO_ACTIVA);
                $colocacion = Colocaciones::model()->find($criteria);
            } else {
                $colocacion = Colocaciones::model()->findByPk($colocacionId);
            }
            $montoColocadoCliente = 0;
            foreach ($colocacion->detalleColocaciones as $detalleColocaciones) {
                if ($detalleColocaciones->clienteId == $clienteId) {
                    $montoColocadoCliente = $detalleColocaciones->monto;
                    break;
                }
            }
            $montoCheque = $colocacion->cheque->montoOrigen;
            return Utilities::truncateFloat(($montoColocadoCliente / $montoCheque) * 100, 2);
        }else
            return 0;
    }

    public function getInversoresDeCheque($chequeId) {
        $criteria = new CDbCriteria();
        $criteria->condition = "chequeId=:chequeId AND estado=:estado";
        $criteria->params = array(":chequeId" => $chequeId, ":estado" => Colocaciones::ESTADO_ACTIVA);
        $colocacion = Colocaciones::model()->find($criteria);

        $inversoresIds = array();
        foreach ($colocacion->detalleColocaciones as $detalleColocaciones) {
            $inversoresIds[] = $detalleColocaciones->clienteId;
        }
        $criteriaClientes = new CDbCriteria();
        $criteriaClientes->compare('id', $inversoresIds, "OR");
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteriaClientes,
                ));
        return $dataProvider;
    }

    public function getMontoColocaciones() {
        $criteriaColocaciones = new CDbCriteria();
        $criteriaColocaciones->select = "SUM(detalleColocaciones.monto) as total";

        $criteriaColocaciones->condition = "detalleColocaciones.clienteId=:clienteId AND t.estado=:estado";
        $criteriaColocaciones->join = "JOIN detalleColocaciones ON detalleColocaciones.colocacionId = t.id";
        $criteriaColocaciones->params = array(
            ':clienteId' => $this->id,
            ':estado' => Colocaciones::ESTADO_ACTIVA);
        $colocaciones = Colocaciones::model()->find($criteriaColocaciones);
        $this->montoColocaciones = $colocaciones->total;
        return $this->montoColocaciones;
    }

    public function afterFind() {
          $this->razonSocial =ucwords(strtolower($this->razonSocial));

       return parent::afterFind();
    }

    public function getPorcentajeInversion(){
        $total=$this->saldo + $this->getSaldoColocaciones();
        if($total!=0)
             $this->porcentajeInversion = Utilities::truncateFloat(($this->saldo / $total)*100,2);
         else
            $this->porcentajeInversion = $this->saldoColocaciones;
        return $this->porcentajeInversion;
    }
	
	////// Métodos generados	

    /**
     * Returns the static model of the specified AR class.
     * @return Clientes the static model class
     */
	
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'clientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('razonSocial, documento, tipoCliente, tasaTomador,tasaInversor,operadorId, sucursalId, userStamp, timeStamp,direccion,fijo,celular', 'required'),
            array('localidadId, provinciaId, tipoCliente, operadorId, sucursalId', 'numerical', 'integerOnly' => true),
            array('razonSocial, fijo, celular, direccion, email', 'length', 'max' => 45),
            array('documento', 'length', 'max' => 11),
            array('tasaInversor, tasaTomador', 'length', 'max' => 5),
            array('userStamp', 'length', 'max' => 50),
            array('montoMaximoTomador, montoPermitidoDescubierto', 'length', 'max' => 15),
            array('tasaInversor', 'validateTasas'),
            array('documento','unique'),
            array('razonSocial','unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, razonSocial, fijo, celular, direccion, localidadId, provinciaId, email, documento, tasaInversor, tipoCliente, operadorId, sucursalId, userStamp, timeStamp, tasaTomador, montoMaximoTomador, productosBusqueda', 'safe', 'on' => 'search'),
        );
    }

    public function validateTasas($attribute, $params) {
        switch ($this->tipoCliente) {
            case self::TYPE_TOMADOR:
                if ($this->tasaTomador == '')
                    $this->addError($this->tasaTomador, 'Debe ingresar una tasa para el cliente tomador');
                break;
            case self::TYPE_INVERSOR:
                if ($this->tasaInversor == '')
                    $this->addError($this->tasaInversor, 'Debe ingresar una tasa para el cliente inversor');
                break;
            case self::TYPE_TOMADOR_E_INVERSOR:
                if ($this->tasaTomador == '')
                    $this->addError($this->tasaTomador, 'Debe ingresar una tasa para el cliente tomador');
                if ($this->tasaInversor == '')
                    $this->addError($this->tasaInversor, 'Debe ingresar una tasa para el cliente inversor');
                break;
            default;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'apoderados' => array(self::HAS_MANY, 'Apoderados', 'clienteId'),
            'beneficiarios' => array(self::HAS_MANY, 'Beneficiarios', 'clienteId'),
            'operador' => array(self::BELONGS_TO, 'Operadores', 'operadorId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'operacionesCheques' => array(self::HAS_MANY, 'OperacionesCheques', 'clienteId'),
            'localidad' => array(self::BELONGS_TO, 'Localidades', 'localidadId'),
            'provincia' => array(self::BELONGS_TO, 'Provincias', 'provinciaId'),
			'productosCliente' => array(self::HAS_MANY, 'Productoctacte', 'pkModeloRelacionado'),
			'productos' => array(self::HAS_MANY, 'Productos', 'productoId', 'through'=>'productosCliente', 'condition' => 'productosCliente.nombreModelo=\'Clientes\''),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'razonSocial' => 'Razon Social',
            'fijo' => 'Fijo',
            'celular' => 'Celular',
            'direccion' => 'Direccion',
            'localidadId' => 'Localidad',
            'provinciaId' => 'Provincia',
            'email' => 'Email',
            'documento' => 'DU/CUIT/CUIL',
            'tasaInversor' => 'Tasa Inversor',
            'tipoCliente' => 'Tipo Cliente',
            'operadorId' => 'Operador',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'tasaTomador' => 'Tasa Tomador',
            'montoMaximoTomador' => 'Monto Maximo Tomador',
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
        $criteria->compare('razonSocial', $this->razonSocial, true);
        $criteria->compare('fijo', $this->fijo, true);
        $criteria->compare('celular', $this->celular, true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('localidadId', $this->localidadId);
        $criteria->compare('provinciaId', $this->provinciaId);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('documento', $this->documento, true);
        $criteria->compare('tasaInversor', $this->tasaInversor, true);
        $criteria->compare('tipoCliente', $this->tipoCliente);
        $criteria->compare('operadorId', $this->operadorId);
        $criteria->compare('sucursalId', $this->sucursalId);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('tasaTomador', $this->tasaTomador, true);
        $criteria->compare('montoMaximoTomador', $this->montoMaximoTomador, true);
		$criteria->with = array('productos');
		$criteria->compare('CONCAT(productos.nombre, productos.descripcion)',$this->productosBusqueda,true);
		$criteria->together = true;
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort'=>array('attributes'=>array('productosBusqueda'=>array('asc'=>'productos.nombre', 'desc'=>'productos.nombre', ), '*', ), ),
                ));
    }
}