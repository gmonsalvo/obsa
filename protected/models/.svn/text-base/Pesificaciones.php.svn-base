<?php

/**
 * This is the model class for table "pesificaciones".
 *
 * The followings are the available columns in table 'pesificaciones':
 * @property integer $id
 * @property string $fecha
 * @property integer $pesificadorId
 * @property string $montoAcreditar
 * @property string $montoGastos
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $estado
 * The followings are the available model relations:
 * @property DetallePesificaciones[] $detallePesificaciones
 * @property Pesificadores $pesificador
 * @property Sucursales $sucursal
 */
class Pesificaciones extends CustomCActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pesificaciones the static model class
	 */
        const ESTADO_ABIERTO=0;
	const ESTADO_CERRADO=1;
	private $saldo;

         private $montototal;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pesificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesificadorId, sucursalId, estado', 'numerical', 'integerOnly'=>true),
			array('userStamp', 'length', 'max'=>45),
                        array('montoAcreditar, montoGastos', 'length', 'max'=>15),
			array('fecha, timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, pesificadorId, sucursalId, userStamp, timeStamp, estado', 'safe', 'on'=>'search'),
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
			'detallePesificaciones' => array(self::HAS_MANY, 'DetallePesificaciones', 'pesificacionId','condition'=>'eliminado=0 and conceptoId=1'),
			'pesificador' => array(self::BELONGS_TO, 'Pesificadores', 'pesificadorId'),
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
			'fecha' => 'Fecha',
			'pesificadorId' => 'Pesificador',
                        'montoAcreditar' => 'Monto a Acreditar',
                        'montoGastos' => 'Gastos',
			'sucursalId' => 'Sucursal',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
                        'estado' => 'Estado',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('pesificadorId',$this->pesificadorId);
                $criteria->compare('montoAcreditar',$this->montoAcreditar);
                $criteria->compare('montoGastos',$this->montoGastos);
		$criteria->compare('sucursalId',$this->sucursalId);
                $criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getDetalleCheques()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('pesificadorId',$this->pesificadorId);
        $criteria->compare('montoAcreditar',$this->montoAcreditar);
        $criteria->compare('montoGastos',$this->montoGastos);
		$criteria->compare('sucursalId',$this->sucursalId);
        $criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchById()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition= "pesificacionId=:id AND eliminado=:eliminado";
		$criteria->params = array(':id'=>$this->id, 'eliminado'=>false);
		$dataProvider = new CActiveDataProvider(new DetallePesificaciones, array(
			'criteria'=>$criteria,
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}


	public function searchPesificacionesSinCompletar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition= "estado=:estado";
		$criteria->params = array(':estado'=>  Pesificaciones::ESTADO_ABIERTO);

		//$criteria->condition= "(t.montoAcreditar+t.montoGastos) NOT IN (SELECT SUM(cheques.montoOrigen) FROM cheques, detallePesificaciones WHERE detallePesificaciones.chequeId=cheques.id AND detallePesificaciones.pesificacionId=t.id)";
		return new CActiveDataProvider(new Pesificaciones, array(
			'criteria'=>$criteria,
		));
	}

        public function getMontototal()
        {
            $sql="SELECT SUM(cheques.montoOrigen) FROM cheques, detallePesificaciones, pesificaciones WHERE detallePesificaciones.chequeId=cheques.id AND detallePesificaciones.pesificacionId=pesificaciones.id AND pesificaciones.id='".$this->id."'";
            $this->montototal=Yii::app()->db->createCommand($sql)->queryScalar();
            return Yii::app()->db->createCommand($sql)->queryScalar();
        }


    	public function getTypeOptions()
	{
		return array(
			self::ESTADO_ABIERTO=>'Abierto',
			self::ESTADO_CERRADO=>'Cerrado',
		);
	}

	public function getTypeDescription()
	{
		$options = array();
		$options = $this->getTypeOptions();
		return $options[$this->estado];

	}

        public function pesificarCheques($chequesId)
        {
            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {

                    $pesificacionId = $this->id;
                    $sql = "INSERT INTO detallePesificaciones (pesificacionId, chequeId) VALUES(:pesificacionId, :chequeId)";
                    $command = $connection->createCommand($sql);
                    //$listaDetallePesificaciones = explode(';', $_POST['detallesPesificaciones']);
                    for ($i = 0; $i < count($chequesId); $i++) {
                        $command->bindValue(":pesificacionId", $pesificacionId, PDO::PARAM_STR);
                        $command->bindValue(":chequeId", $chequesId[$i], PDO::PARAM_STR);
                        $command->execute();
                        $cheques = Cheques::model()->findByPk($chequesId[$i]);
                        $cheques->estado = Cheques::TYPE_EN_PESIFICADOR;
                        $cheques->save();
                    }
                    return true;

            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                return false;
            }
        }

        public function getSaldo(){
        	 $creditoSQL = "SELECT SUM(monto) FROM detallePesificaciones WHERE pesificacionId='" . $this->id . "' AND tipoMov=".DetallePesificaciones::TYPE_CREDITO." AND eliminado=0" ;
	        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
	        $debitoSQL = "SELECT SUM(monto) FROM detallePesificaciones WHERE pesificacionId='" . $this->id . "' AND tipoMov=".DetallePesificaciones::TYPE_DEBITO." AND eliminado=0";
	        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
	        $this->saldo = $creditoQRY - $debitoQRY;
	        return $this->saldo;
        }

        public function AcreditarCheque($chequeId, $tasaDescuento){

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
	        	$cheque = Cheques::model()->findByPk($chequeId);
	        	$operadorCompra = $cheque->operacionCheque->operador;
	    		$tasaDiferencial = $cheque->pesificacion - $tasaDescuento;
	            $operadorClienteId = $operadorCompra->clienteId;
	            $montoTotalComision = abs($tasaDiferencial) * $cheque->montoOrigen / 100;
	            if ($tasaDiferencial != 0) {
	                $comisionOperador = $operadorCompra->comision;
	                $montoComision = $montoTotalComision * $comisionOperador / 100;
	                $conceptoId = '18'; //diferencia pesificaciones
	                if ($tasaDiferencial < 0) {
	                    $tipoMov = CtacteClientes::TYPE_DEBITO; //debito
	                    $descripcion = "Perdida por pesificacion de cheque numero " . $cheque->numeroCheque;
	                    $flujoFondosMov = FlujoFondos::TYPE_DEBITO;
	                    $descripcionFlujoFondos = 'Perdidas por pesificacion de cheque numero ' . $cheque->numeroCheque;
	                } else {
	                    $tipoMov = CtacteClientes::TYPE_CREDITO;
	                    $descripcion = "Acreditacion de comision por pesificacion de cheque numero " . $cheque->numeroCheque;
	                    $flujoFondosMov = FlujoFondos::TYPE_CREDITO;
	                    $descripcionFlujoFondos = 'Ganancias por pesificacion de cheque numero ' . $cheque->numeroCheque;
	                }

                	// $ctacteClientes = new CtacteClientes();
                 //    $ctacteClientes->tipoMov = $tipoMov;
                 //    $ctacteClientes->conceptoId = $conceptoId;
                 //    $ctacteClientes->clienteId = $operadorClienteId;
                 //    $ctacteClientes->productoId = 1;
                 //    $ctacteClientes->descripcion = $descripcionFlujoFondos;
                 //    $ctacteClientes->monto = $montoComision;

                 //    $ctacteClientes->saldoAcumulado=$ctacteClientes->getSaldoAcumuladoActual()+$ctacteClientes->monto;
                 //    $ctacteClientes->fecha = Date("d/m/Y");;
                 //    $ctacteClientes->origen = "Cheques";
                 //    $ctacteClientes->identificadorOrigen = $cheque->id;
                 //    if(!$ctacteClientes->save())
                 //    	throw new Exception($ctacteClientes->getErrors());
	                // $this->actionAcreditarCtacteCliente($tipoMov, $conceptoId, $operadorClienteId, $descripcion, "Pesificaciones",$model->id, $montoComision);

	                $flujoFondos = new FlujoFondos;
	                $flujoFondos->cuentaId = '8'; // corresponde fondo fijo
	                $flujoFondos->conceptoId = $conceptoId; // concepto para Compra de Cheques
	                $flujoFondos->descripcion = $descripcionFlujoFondos;
	                $flujoFondos->tipoFlujoFondos = $flujoFondosMov;
	                $flujoFondos->monto = $montoTotalComision;

	                if($flujoFondosMov==FlujoFondos::TYPE_CREDITO)
	                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
	                else
	                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;

	                $flujoFondos->fecha = Date("d/m/Y");
	                $flujoFondos->origen = 'Cheques';
	                $flujoFondos->identificadorOrigen = $cheque->id;
	                // $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
	                // $flujoFondos->userStamp = Yii::app()->user->model->username;
	                // $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
	                if(!$flujoFondos->save())
	                	throw new Exception($flujoFondos->getErrors());
	             }

	            $tipoMov = CtacteClientes::TYPE_CREDITO;
	            $conceptoId = '19'; //Acreditacion cheques

	            $productoId = 1; //compra de cheques
	            $descripcion = "Acreditacion cheque numero " . $cheque->numeroCheque;
	            $fecha = date("d/m/Y");
	            $origen = "Cheques";
	            $identificadorOrigen = $cheque->id;

	            $colocaciones = Colocaciones::model()->find('chequeId=:chequeId AND estado=:estado', array(':chequeId' => $cheque->id, ':estado' => Colocaciones::ESTADO_ACTIVA));

	            if ($colocaciones != null) {
	            	foreach($colocaciones->detalleColocaciones as $detalleColocaciones){
		                $ctacteClientes = new CtacteClientes();
	                    $ctacteClientes->tipoMov = $tipoMov;
	                    $ctacteClientes->conceptoId = $conceptoId;
	                    $ctacteClientes->clienteId = $detalleColocaciones->clienteId;
	                    $ctacteClientes->productoId = $productoId;
	                    $ctacteClientes->descripcion = $descripcion;
	                    $ctacteClientes->monto = $detalleColocaciones->monto;

	                    $ctacteClientes->saldoAcumulado=$ctacteClientes->getSaldoAcumuladoActual()+$ctacteClientes->monto;
	                    $ctacteClientes->fecha = $fecha;
	                    $ctacteClientes->origen = $origen;
	                    $ctacteClientes->identificadorOrigen = $identificadorOrigen;
	                    if(!$ctacteClientes->save())
	                    	throw new Exception($ctacteClientes->getErrors());
	                }
	            }
	            $cheque->estado = Cheques::TYPE_ACREDITADO;
	            $cheque->save();
	            $transaction->commit();
	            Yii::app()->user->setFlash('success', 'Acreditacion realizada con exito');
	            return true;
        	} catch (Exception $e){
        		$transaction->rollBack();
                Yii::app()->user->setFlash('error', $e->getMessage());
                return false;
        	}
        }
}