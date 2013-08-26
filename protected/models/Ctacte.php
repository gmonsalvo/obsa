<?php

/**
 * This is the model class for table "ctacte".
 *
 * The followings are the available columns in table 'ctacte':
 * @property integer $id
 * @property integer $tipoMov
 * @property string $productoCtaCteId
 * @property integer $conceptoId
 * @property string $descripcion
 * @property string $monto
 * @property string $saldoAcumulado
 * @property string $fecha
 * @property string $origen
 * @property string $identificadorOrigen
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property Productoctacte $productoCtaCte
 */
class Ctacte extends CActiveRecord
{
	////// Propiedades
	
    // Tipos de movimientos

    const TYPE_CREDITO = 0;
    const TYPE_DEBITO = 1;

    private $acum;
    private $saldo;
    public $total;
    public $fechaInicio;
    public $fechaFin;
		
	////// Métodos nuevos
	
    public function getSaldoAcumuladoActual(){
        if(isset($this->productoCtaCteId)){
            $criteria = new CDbCriteria();
            $criteria->condition = "id IN (SELECT MAX(id) FROM ctacte WHERE productoCtaCteId=".$this->productoCtaCteId.")";
            $model = $this->find($criteria);
            if(isset($model))
                return $model->saldoAcumulado;
            else
                return 0;
        } else return 0;
    }
		
    public function searchByFechaAndCliente($fechaIni, $fechaFin, $clienteId) {
        $criteria = new CDbCriteria;
        $criteria->condition = "(fecha BETWEEN :start_day AND :end_day) AND clienteId=:clienteId";
        $criteria->order = 'fecha ASC';
        $criteria->params = array(':start_day' => $fechaIni, ':end_day' => $fechaFin, ':clienteId' => $clienteId);

        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }
	
	////// Métodos generados
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ctacte the static model class
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
		return 'ctacte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipoMov, productoCtaCteId, conceptoId, monto, fecha, userStamp, timeStamp, sucursalId', 'required'),
			array('tipoMov, conceptoId, estado, sucursalId', 'numerical', 'integerOnly'=>true),
			array('productoCtaCteId, identificadorOrigen', 'length', 'max'=>20),
			array('descripcion', 'length', 'max'=>200),
			array('monto, saldoAcumulado', 'length', 'max'=>15),
			array('origen, userStamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipoMov, productoCtaCteId, conceptoId, descripcion, monto, saldoAcumulado, fecha, origen, identificadorOrigen, estado, userStamp, timeStamp, sucursalId', 'safe', 'on'=>'search'),
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
			'productoCtaCte' => array(self::BELONGS_TO, 'Productoctacte', 'productoCtaCteId'),
			'cliente' => array(self::HAS_MANY, 'Clientes', 'clienteId', 'through'=>'productosCliente', 'condition' => 'productosCliente.nombreModelo=\'Clientes\''),
            'concepto' => array(self::BELONGS_TO, 'Conceptos', 'conceptoId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipoMov' => 'Tipo Mov',
			'productoCtaCteId' => 'Producto Cta Cte',
			'producto' => 'Producto',
			'conceptoId' => 'Concepto',
			'descripcion' => 'Descripcion',
			'monto' => 'Monto',
			'saldoAcumulado' => 'Saldo Acumulado',
			'fecha' => 'Fecha',
			'origen' => 'Origen',
			'identificadorOrigen' => 'Identificador Origen',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->compare('productoCtaCteId',$this->productoCtaCteId,true);
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('saldoAcumulado',$this->saldoAcumulado,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('identificadorOrigen',$this->identificadorOrigen,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('sucursalId',$this->sucursalId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}