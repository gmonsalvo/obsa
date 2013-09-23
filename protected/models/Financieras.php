<?php

/**
 * This is the model class for table "financieras".
 *
 * The followings are the available columns in table 'financieras':
 * @property string $id
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $tasaPromedio
 * @property integer $diasClearing
 * @property string $tasaPesificacion
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property ResponsablesFinancieras[] $responsablesFinancierases
 */
class Financieras extends CActiveRecord
{
	////// Propiedades
	
	public $responsablesBusqueda;
	public $productosBusqueda;
	public $productosId;

	private $saldo;
    private $saldoColocaciones;
    private $montoColocaciones;
	
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
	
	public function validarResponsables($attribute, $params)
	{
    	if (count($this->responsables) <= 1)
			$this->addError($attribute, $params['message']);
	}
	
	public function validarProductos($attribute, $params)
	{
		$productos = $_POST['Financieras']['productosId'];
		
    	if (count($productos) < 1)
			$this->addError($attribute, $params['message']);
	}
	
	////// Métodos generados
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Financieras the static model class
	 */
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'financieras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, direccion, userStamp, timeStamp', 'required'),
			array('diasClearing', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			array('direccion, telefono, userStamp', 'length', 'max'=>45),
			array('tasaPromedio, tasaPesificacion', 'length', 'max'=>5),
			array('tasaPromedio, tasaPesificacion', 'numerical', 'integerOnly'=>false),
			array('tasaPromedio, tasaPesificacion', 'numerical', 'integerOnly'=>false),
			array('responsables', 'validarResponsables', 'message'=>'Debe especificar al menos dos responsables para la financiera'),
			array('productos', 'validarProductos', 'message'=>'Debe seleccionar al menos un producto para la financiera'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, direccion, telefono, tasaPromedio, diasClearing, tasaPesificacion, responsablesBusqueda, productosBusqueda, userStamp, timeStamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'responsables' => array(self::MANY_MANY, 'Responsables', 'responsablesFinancieras(financieraId,responsableId)'),
			'productosFinanciera' => array(self::HAS_MANY, 'Productoctacte', 'pkModeloRelacionado'),
			'productos' => array(self::HAS_MANY, 'Productos', 'productoId', 'through'=>'productosFinanciera', 'condition' => 'productosFinanciera.nombreModelo=\'Financieras\''),
			//'productos' => array(self::MANY_MANY, 'Productos', 'productoctacte(pkModeloRelacionado,productoId)', 'condition' => 'productos_productos.nombreModelo=:modelo', 'together'=>'yes', 'params'=>array(':modelo'=>'Financieras'),),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'tasaPromedio' => 'Tasa Promedio',
			'diasClearing' => 'Dias Clearing',
			'tasaPesificacion' => 'Tasa Pesificacion',
			'financieras' => 'Financieras',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('tasaPromedio',$this->tasaPromedio,true);
		$criteria->compare('diasClearing',$this->diasClearing);
		$criteria->compare('tasaPesificacion',$this->tasaPesificacion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->with = array('responsables', 'productos');
		$criteria->compare('CONCAT(responsables.nombre, responsables.celular, responsables.email)',$this->responsablesBusqueda,true);
		$criteria->compare('CONCAT(productos.nombre, productos.descripcion)',$this->productosBusqueda,true);
		$criteria->together = true;
		/*
		$criteria->with = array('productos');
		$criteria->compare('CONCAT(productos.nombre, productos.descripcion)',$this->productosBusqueda,true);
		$criteria->together = true;
		*/
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('attributes'=>array('responsablesBusqueda'=>array('asc'=>'responsables.nombre', 'desc'=>'responsables.nombre', ), '*', ), ),
			'sort'=>array('attributes'=>array('productosBusqueda'=>array('asc'=>'productos.nombre', 'desc'=>'productos.nombre', ), '*', ), ),
		));
	}

	public function getSaldo() {

			$productoCliente = Productoctacte::model()->find("pkModeloRelacionado=:financieraId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
								array(":financieraId" => $this->id, ":productoId" => $this->productosId, ":nombreModelo" => "Financieras"));
			
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

        $sql = "SELECT detalleColocaciones.*,cheques.fechaPago, cheques.clearing 
        		FROM detalleColocaciones, colocaciones, cheques 
        		WHERE detalleColocaciones.clienteId='" . $this->id . 
        		"' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . 
        		"' AND colocaciones.id=detalleColocaciones.colocacionId " . 
        		" AND cheques.id=colocaciones.chequeId AND cheques.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";
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

}