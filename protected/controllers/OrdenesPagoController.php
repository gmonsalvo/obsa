<?php

class OrdenesPagoController extends Controller {

	///// Propiedades
	
	///// Métodos nuevos
	
	public function actionCargarProductosCliente() {
		
		$cliente = Clientes::model()->findByPk($_POST['OrdenesPago']['clienteId']); //buscarProductosCliente($_POST['OrdenIngreso']['clienteId']);
		
		foreach($cliente->productos as $producto)
			echo CHtml::tag('option', array('value'=>$producto->id),CHtml::encode($producto->nombre),true);
		
		echo '<script> MostrarInformacion(); </script>';
	}

    public function actionCargarProductosFinanciera() {
        
        $financiera = Financieras::model()->findByPk($_POST['OrdenesPago']['financieraId']); //buscarProductosCliente($_POST['OrdenIngreso']['clienteId']);
        
        foreach($financiera->productos as $producto)
            echo CHtml::tag('option', array('value'=>$producto->id),CHtml::encode($producto->nombre),true);
        
        echo '<script> MostrarInformacion(); </script>';
    }
	
	///// Métodos Generados

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'getDetalles', 'updateOrden', 
                                'reciboPDF', 'retirarFondos', 'final', 'cargarProductosCliente', 
                                'retirarFondosFinanciera', 'cargarProductosFinanciera'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new OrdenesPago;
        $formaPagoOrden = new FormaPagoOrden();
        $cheques = new Cheques();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $operacionChequeId = isset($_GET['operacionChequeId']) ? $_GET['operacionChequeId'] : 0;
        if(isset(Yii::app()->session["ejecutar"])){
            echo Yii::app()->session["ejecutar"];
            unset(Yii::app()->session['ejecutar']);
        }

        if (isset($_POST['OrdenesPago'])) {
            $model->attributes = $_POST['OrdenesPago'];
            $model->monto = $_POST["montoEfectivo"] + $_POST["montoCheques"];
            $model->estado = OrdenesPago::ESTADO_PENDIENTE;
            $model->origenOperacion = OrdenesPago::ORIGEN_OPERACION_COMPRA;
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);

            $productoCtaCte = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
                    array(":clienteId" => $_POST['OrdenesPago']['clienteId'], 
                    ":productoId" => $_POST['OrdenesPago']['productoId'], ":nombreModelo" => "Clientes"));
            if (!isset($productoCtaCte))
                return false;

            $model->productoCtaCteId = $productoCtaCte->id;

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {

                    OperacionesCheques::model()->updateByPk($_POST["operacionChequeId"], array('estado'=>OperacionesCheques::ESTADO_COMPRADO));
                    $operacionesChequesOrdenPago = new OperacionesChequeOrdenPago;
                    $operacionesChequesOrdenPago->operacionChequeId = $_POST["operacionChequeId"];
                    $operacionesChequesOrdenPago->ordenPagoId = $model->id;
                    if(!$operacionesChequesOrdenPago->save()){
                        throw new Exception(var_dump($operacionesChequesOrdenPago->getErrors()), 1);
                    }
                    $idOrdenesPago = $model->id;
                    $montoEfectivo = $_POST["montoEfectivo"];
                    $valor = $montoEfectivo;
                    $montoCheques = $_POST["montoCheques"];
                    if ($_POST["chequesSeleccionados"] != "")
                        $chequesSeleccionados = explode(',', $_POST["chequesSeleccionados"]);
                    else
                        $chequesSeleccionados = array();

                    //creo la forma de pago en efectivo si es que existe parte en efectivo
                    if ($_POST["montoEfectivo"] != 0) {
                        $formaPagoOrden = new FormaPagoOrden();
                        $formaPagoOrden->ordenPagoId = $idOrdenesPago;
                        $formaPagoOrden->monto = $_POST["montoEfectivo"];
                        $formaPagoOrden->tipoFormaPago = FormaPagoOrden::TIPO_EFECTIVO;
                        $formaPagoOrden->formaPagoId = 0;
                        if (!$formaPagoOrden->save()) {
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error', 'Error al crear la Orden de pago2');
                            break;
                        }
                    }

                    //recorro los cheques seleccionados
                    for ($i = 0; $i < count($chequesSeleccionados); $i++) {
                        $cheque = Cheques::model()->findByPk($chequesSeleccionados[$i]);
                        $cheque->estado = Cheques::TYPE_EN_PESIFICADOR;
                        $cheque->save();
                        $formaPagoOrden = new FormaPagoOrden();
                        $formaPagoOrden->ordenPagoId = $idOrdenesPago;
                        $formaPagoOrden->monto = $cheque->montoOrigen - $cheque->pesificacion*$cheque->montoOrigen/100;
                        $formaPagoOrden->tipoFormaPago = FormaPagoOrden::TIPO_CHEQUES;
                        $formaPagoOrden->formaPagoId = $cheque->id;
                        if (!$formaPagoOrden->save()) {
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error', 'Error al crear la Orden de pago2');
                            break;
                        }
                    }
                    //$valor=$chequesSeleccionados[0].' '.$chequesSeleccionados[1];
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Orden de pago creada con exito');
                    $this->redirect(array('operacionesCheques/nuevaOperacion'));
                } else {
                    Yii::app()->user->setFlash('error', 'Error al crear la Orden de pago1');
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Error al crear la Orden de pago2');
            }
        }
        $this->render('create', array(
            'model' => $model, 'formaPagoOrden' => $formaPagoOrden, 'cheques' => $cheques, 'operacionChequeId' => $operacionChequeId
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenesPago'])) {
            $model->attributes = $_POST['OrdenesPago'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('OrdenesPago');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrdenesPago('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrdenesPago']))
            $model->attributes = $_GET['OrdenesPago'];

        if(isset(Yii::app()->session["ejecutar"])){
            echo Yii::app()->session["ejecutar"];
            unset(Yii::app()->session['ejecutar']);
        }
        $this->render('admin', array(
            'model' => $model, 'formaPagoOrden' => new FormaPagoOrden(),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = OrdenesPago::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ordenes-pago-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetDetalles() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $ordenesPago = OrdenesPago::model()->findByPk($id);

            $montoPagado = 0;
            $montoCheques = 0;
            $montoPagadoEfectivo = 0;
            if(!empty($ordenesPago->recibos)){
                ##aqui ya esta incluido lo de los cheques
                $montoPagado = $ordenesPago->totalMontoRecibos; 
                $montoCheques = $ordenesPago->getMontoCheques();
                $montoPagadoEfectivo = $montoPagado - $montoCheques;
                $saldoEfectivo = $ordenesPago->monto - $montoPagado;

            } else {
                ## al no haber recibos tomamos lo que se cargo en la pantalla que se crea la orden de pago
                $montoCheques = $ordenesPago->getMontoCheques();   
                $saldoEfectivo = $ordenesPago->monto - $montoCheques;
            } 

            $dataProvider = FormaPagoOrden::model()->getDetallesCheques($id);

            $render = $this->renderPartial('/ordenesPago/detalleOrdenesPago', 
                array(
                    'ordenesPago' => $ordenesPago, 
                    'formaPagoOrden' => new FormaPagoOrden(),
                    'dataProvider' => $dataProvider, 
                    'saldoEfectivo' => Utilities::MoneyFormat($saldoEfectivo), 
                    'montoPagadoEfectivo' => Utilities::MoneyFormat($montoPagadoEfectivo),
                    'montoCheques' => Utilities::MoneyFormat($montoCheques),
                    "processOutput" => false
                    ), true, true);

            echo $render;
        }
    }

    public function actionUpdateOrden() {
        if (isset($_POST["boton"]) && isset($_POST["ordenPagoId"])) {
            $id = $_POST["ordenPagoId"];
            $ordenesPago = $this->loadModel($id);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($_POST["boton"] == "Pagar") {

                    if ($ordenesPago->origenOperacion == OrdenesPago::ORIGEN_OPERACION_COMPRA) {

                        $recibo = new RecibosOrdenPago();
                        $recibo->ordenPagoId = $ordenesPago->id;
                        $recibo->fecha = date("Y-m-d");
                        ##es la primera vez entonces incluyo el monto de los cheques
                        if(empty($ordenesPago->recibos)){
                            $montoCheques = $ordenesPago->getMontoCheques();
                            $montoTotalRecibo = $montoCheques + $_POST["montoPagar"];
                        } else {
                            $montoTotalRecibo = $_POST["montoPagar"];
                        }
                        $recibo->montoTotal = $montoTotalRecibo;
                        if(!$recibo->save())
                            throw new Exception("Error al guardar el recibo", 1);
                            
                        ## ??????????
                        if(empty($ordenesPago->recibos)){
                            $formaPagoOrden = new FormaPagoOrden();
                            $listaFormaPagoOrden = $formaPagoOrden->getFormaPagoOrden($ordenesPago->id, FormaPagoOrden::TIPO_CHEQUES);

                            for ($i = 0; $i < count($listaFormaPagoOrden); $i++) {

                                $detalle = new RecibosDetalle();
                                $detalle->reciboId = $recibo->id;
                                $detalle->tipoFondoId = $listaFormaPagoOrden[$i]->formaPagoId;
                                $detalle->monto = $listaFormaPagoOrden[$i]->monto;
                                if(!$detalle->save()){
                                    throw new Exception("Error al guardar el detalle del recibo", 1);
                                }
                                $chequeId = $listaFormaPagoOrden[$i]->formaPagoId;
                                $cheque = Cheques::model()->findByPk($chequeId);

                                $colocacion = Colocaciones::model()->findAll("chequeId=:chequeId AND estado=:estado", array(":chequeId" => $chequeId, ':estado' => Colocaciones::ESTADO_ACTIVA));
                                //si el cheque estaba en una colocacion quiere decir que su estado era colocado sino sin colocar
                                if (count($colocacion) > 0) {

                                    $tipoMov = CtacteClientes::TYPE_CREDITO; //credito
                                    $conceptoId = 9; //Ingreso de fondos
                                    $productoId = 1; //compra de cheques
                                    $descripcion = "Orden de Pago";
                                    $fecha = date("d/m/Y");
                                    $origen = "OrdenesPago";
                                    $identificadorOrigen = $ordenesPago->id;

                                    for ($i = 0; $i < count($colocacion[0]->detalleColocaciones); $i++) {
                                        $ctacteClientes = new CtacteClientes();
                                        $ctacteClientes->tipoMov = $tipoMov;
                                        $ctacteClientes->conceptoId = $conceptoId;
                                        $ctacteClientes->clienteId = $colocacion[0]->detalleColocaciones[$i]->clienteId;
                                        $ctacteClientes->productoId = $productoId;
                                        $ctacteClientes->descripcion = $descripcion;
                                        $ctacteClientes->monto = $colocacion[0]->detalleColocaciones[$i]->monto;

                                        $ctacteClientes->saldoAcumulado=$ctacteClientes->getSaldoAcumuladoActual()+$ctacteClientes->monto;
                                        $ctacteClientes->fecha = $fecha;
                                        $ctacteClientes->origen = $origen;
                                        $ctacteClientes->identificadorOrigen = $identificadorOrigen;
                                        if (!$ctacteClientes->save()) {
                                            throw new Exception("Error al guardar el movimiento en cta cte", 1);
                                        }
                                    }
                                    //$this->actionIndex();
                                }
                                $cheque->estado = Cheques::TYPE_ACREDITADO;
                                $cheque->save();
                            }
                        } 
                        $detalle = new RecibosDetalle();
                        $detalle->reciboId = $recibo->id;
                        $detalle->tipoFondoId = 0;
                        $detalle->monto = $_POST["montoPagar"];
                        if(!$detalle->save()){
                            throw new Exception("Error al guardar el detalle del recibo", 1);
                        }

                        if($ordenesPago->totalMontoRecibos==$ordenesPago->monto){
                            $ordenesPago->estado = OrdenesPago::ESTADO_PAGADA;
                            $ordenesPago->save();
                        }


                        $flujoFondos = new FlujoFondos;
                        $flujoFondos->cuentaId = '6'; // corresponde a la caja de operaciones
                        $flujoFondos->conceptoId = '12'; // concepto para Compra de Cheques
                        $flujoFondos->descripcion = 'Compra de cheques, Orden Pago Num' . $ordenesPago->id; // bueno fijate ahi como podes armar una descripcion que tenga la mayor cantidad de info posible.
                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                        $flujoFondos->monto = $_POST["montoPagar"];

                        $flujoFondos->fecha = Date("d/m/Y");
                        $flujoFondos->origen = 'OrdenesPago';
                        $flujoFondos->identificadorOrigen = $ordenesPago->id;
                        $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                        $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                        $flujoFondos->userStamp = Yii::app()->user->model->username;
                        $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                        if (!$flujoFondos->save()) {
                            throw new Exception("Error al guardar en flujo fondos", 1);
                        }

                        $ctacteCliente = new CtacteClientes();
                        $ctacteCliente->tipoMov = CtacteClientes::TYPE_DEBITO;
                        $ctacteCliente->conceptoId = 12;
                        $ctacteCliente->clienteId = $ordenesPago->clienteId;
                        $ctacteCliente->productoId = 1;
                        $ctacteCliente->descripcion = "Orden de Pago Num.".$ordenesPago->id;

                        $ctacteCliente->monto = $recibo->montoTotal;
                        $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()-$ctacteCliente->monto;
                        $ctacteCliente->fecha = date("Y-m-d");
                        $ctacteCliente->origen = "OrdenesPago";
                        $ctacteCliente->identificadorOrigen = $ordenesPago->id;

                        if(!$ctacteCliente->save()){
                            throw new Exception("Error al efectuar movimiento en ctacte del cliente", 1);                        
                        }

                        $ejecutar = '<script type="text/javascript" language="javascript">
                        window.open("'.Yii::app()->createUrl("/recibosOrdenPago/reciboPDF", array("id"=>$recibo->id)).'");
                        </script>';

                        Yii::app()->session['ejecutar'] = $ejecutar;
                        Yii::app()->user->setFlash('success', 'Orden de Pago Procesada con exito');
                        ##signica que la orden de pago fue parcial, entonces pongo en ctacte del cliente lo que falte
                        // if($montoAcreditar!=0){
                        //     $tipoMov = CtacteClientes::TYPE_CREDITO; //credito
                        //     $conceptoId = 9; //Ingreso de fondos
                        //     $ctacteClientes = new CtacteClientes();
                        //     $ctacteClientes->tipoMov = $tipoMov;
                        //     $ctacteClientes->conceptoId = $conceptoId;
                        //     $ctacteClientes->clienteId = $ordenesPago->clienteId;
                        //     $ctacteClientes->productoId = 1;
                        //     $ctacteClientes->descripcion = "Ingreso de fondos por orden de Compra";
                        //     $ctacteClientes->monto = $montoAcreditar;

                        //     $ctacteClientes->saldoAcumulado=$ctacteClientes->getSaldoAcumuladoActual()+$ctacteClientes->monto;
                        //     $ctacteClientes->fecha = date("d/m/Y");
                        //     $ctacteClientes->origen = "OrdenesPago";
                        //     $ctacteClientes->identificadorOrigen = $ordenesPago->id;
                        //     if (!$ctacteClientes->save()) {
                        //         $transaction->rollBack();
                        //         Yii::app()->user->setFlash('error', 'Error al efectuar la Orden de pago2');
                        //         $this->actionAdmin();
                        //     }
                        // }

                        // $ordenesPago->estado = OrdenesPago::ESTADO_PAGADA;
                        // $ordenesPago->save();

                    } else {
                        if ($ordenesPago->origenOperacion == OrdenesPago::ORIGEN_OPERACION_RETIRO_FONDOS) {
                            //
                            /*
                            $productoCliente = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
                                                array(":clienteId" => $ordenesPago->clienteId, 
                                                    ":productoId" => $ordenesPago->productoId, ":nombreModelo" => "Clientes"));
                            */
                            $productoCliente = $ordenesPago->productoCtaCte;
						
							if (!$productoCliente)
								throw new Exception("Error al obtener la relación producto-cliente  ". $ordenesPago->clienteId . " - ". $ordenesPago->productoId, 1);
                            
                            $flujoFondos = new FlujoFondos;
                            $flujoFondos->cuentaId = '6'; // corresponde a la caja de operaciones
                            $flujoFondos->conceptoId = '16'; // pago prov
                            $flujoFondos->descripcion = $ordenesPago->descripcion; // bueno fijate ahi como podes armar una descripcion que tenga la mayor cantidad de info posible.
                            $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                            $flujoFondos->monto = $ordenesPago->monto;
                            $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                            $flujoFondos->fecha = Date("d/m/Y");
                            $flujoFondos->origen = 'OrdenesPago';
                            $flujoFondos->identificadorOrigen = $ordenesPago->id;
                            $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                            $flujoFondos->userStamp = Yii::app()->user->model->username;
                            $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                            if(!$flujoFondos->save()){
                                throw new Exception(var_dump($flujoFondos), 1);
                            }


                            //hacemos el descuento en la cuenta origen


                            $sql = "INSERT INTO ctacte
                                            (tipoMov, productoCtaCteId, conceptoId, descripcion, origen, identificadorOrigen, monto, fecha, userStamp, timeStamp, sucursalId, saldoAcumulado)
                                            VALUES (:tipoMov, :productoCtaCteId, :conceptoId, :descripcion, :origen, :identificadorOrigen, :monto, :fecha, :userStamp, :timeStamp, :sucursalId, :saldoAcumulado)";


                            $command = $connection->createCommand($sql);
                            $tipoMov = CtacteClientes::TYPE_DEBITO;
                            $conceptoId = 16;
                            $descripcion = $ordenesPago->descripcion;
                            $origen="OrdenesPago";
                            $identificadorOrigen=$ordenesPago->id;
                            $fecha = Date("Y-m-d");
                     		//$productoId = 1;
                            $userStamp = Yii::app()->user->model->username;
                            $timeStamp = Date("Y-m-d h:m:s");
                            $sucursalId = Yii::app()->user->model->sucursalId;
                            
                            $ctacte = new Ctacte();
                            $ctacte->productoCtaCteId=$productoCliente->id;
                            
                            $saldoAcumuladoActual = $ctacte->getSaldoAcumuladoActual();
                            $saldoAcumulado=$saldoAcumuladoActual-$ordenesPago->monto;

                            $clienteId = $ordenesPago->clienteId;
//
                            $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
							$command->bindValue(":productoCtaCteId", $productoCliente->id, PDO::PARAM_STR);
                            $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                            $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                            $command->bindValue(":origen", $origen, PDO::PARAM_STR);
                            $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_STR);
                            $command->bindValue(":monto", $ordenesPago->monto, PDO::PARAM_STR);

                            $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);

                            $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                            $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                            $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                            $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
                            if(!$command->execute())
                                throw new Exception("Error", 1);
                            
                            $ordenesPago->estado=OrdenesPago::ESTADO_PAGADA;
                            if ($ordenesPago->save()) {
                                Yii::app()->user->setFlash('success', 'Movimiento realizado con exito');
                                $ejecutar = '<script type="text/javascript" language="javascript">
                                    window.open("'.Yii::app()->createUrl("/ordenesPago/reciboPDF", array("id"=>$id)).'");
                                </script>';

                                Yii::app()->session['ejecutar'] = $ejecutar;
                            } else {
                                
                                //Yii::app()->user->setFlash('success', 'ERRRORR' .var_dump(  $ordenesPago->getErrors() ) );
                                print_r($ordenesPago->getErrors());
                                $transaction->rollback();
                                //$this->redirect(array('admin'));
                                return ;
                            }                     
                            
                            
                        }
                    }

                    $transaction->commit();
                    $this->redirect(array('admin'));
                    // $this->actionFinal($id);
                    //$this->redirect(array('ordenesPago/admin'));
                } else {
                    if ($_POST["boton"] == "Anular") {
                        $ordenesPago->estado = OrdenesPago::ESTADO_ANULADA;
                        $ordenesPago->save();

                        $operacionCheque = $ordenesPago->operacionesChequeOrdenPago->operacionesCheques;
                        $operacionCheque->estado = OperacionesCheques::ESTADO_A_PAGAR;

                        if(!$operacionCheque->save())
                            throw new Exception(var_dump($operacionCheque->getErrors()), 1);


                        $formaPagoOrden = new FormaPagoOrden();
                        //busco los cheques para ponerlos en el estado que correspondia
                        $listaFormaPagoOrden = $formaPagoOrden->getFormaPagoOrden($ordenesPago->id, FormaPagoOrden::TIPO_CHEQUES);
                        for ($i = 0; $i < count($listaFormaPagoOrden); $i++) {
                            $chequeId = $listaFormaPagoOrden[$i]->formaPagoId;
                            $cheque = Cheques::model()->findByPk($chequeId);

                            $colocacion = Colocaciones::model()->findAll("chequeId=:chequeId AND estado=:estado", array(":chequeId" => $chequeId, ':estado' => Colocaciones::ESTADO_ACTIVA));
                            //si el cheque estaba en una colocacion quiere decir que su estado era colocado sino sin colocar
                            if (count($colocacion) > 0) {
                                $cheque->estado = Cheques::TYPE_EN_CARTERA_COLOCADO;
                            }
                            else
                                $cheque->estado = Cheques::TYPE_EN_CARTERA_SIN_COLOCAR;
                            $cheque->save();
                            if(!$listaFormaPagoOrden[$i]->delete())
                                throw new Exception(var_dump($listaFormaPagoOrden[$i]->getErrors()), 1);

                        }
                        $formaPagoOrdenEfectivo = $formaPagoOrden->getFormaPagoOrden($ordenesPago->id, FormaPagoOrden::TIPO_EFECTIVO);
                        if(!$formaPagoOrdenEfectivo[0]->delete())
                            throw new Exception(var_dump($formaPagoOrdenEfectivo[0]->getErrors()), 1);
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'La orden fue anulada con exito');
                        $this->redirect(array('ordenesPago/admin'));
                    }
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', $e->getMessage());
                $this->redirect(array('ordenesPago/admin'));
            }
        }
    }

    public function actionReciboPDF($id) {
        $model = $this->loadModel($id);


        $formaPagoOrdenEfectivo = FormaPagoOrden::model()->getFormaPagoOrden($model->id, FormaPagoOrden::TIPO_EFECTIVO);
        $formaPagoOrdenCheques = FormaPagoOrden::model()->getFormaPagoOrden($model->id, FormaPagoOrden::TIPO_CHEQUES);


        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Recibo");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 12);
        //$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . Utilities::ViewDateFormat($model->fecha) . '
                       <br/>
                       <br/>
                       Cliente: ' . $model->productoCtaCte->cliente->razonSocial . '
                       <br/>
                       <br/>
                       Orden de Pago Nro: ' . $model->id . '
                       <br/>
                       <br/>
                       Monto Total: ' . Utilities::MoneyFormat($model->monto) . '
                       <br/>
                       <br/>
                       Monto Efectivo: ' . Utilities::MoneyFormat($formaPagoOrdenEfectivo[0]->monto) . '
                       <br/>
                       <br/>
                       <br/>';
        if (count($formaPagoOrdenCheques) > 0) {
            $html.= '<table><tr><td>Librador</td><td>Nro Cheque</td><td>Monto</td></tr>';
            $montoCheques = 0;
            for ($i = 0; $i < count($formaPagoOrdenCheques); $i++) {
                $montoCheques+=$formaPagoOrdenCheques[$i]->monto;
                $chequeId = $formaPagoOrdenCheques[$i]->formaPagoId;
                $cheque = Cheques::model()->findByPk($chequeId);
                $html.="<tr><td>" . $cheque->librador->denominacion . "</td><td>" . $cheque->numeroCheque . "</td><td>" . Utilities::MoneyFormat($formaPagoOrdenCheques[$i]->monto) . "</td></tr>";
            }


            $html.='</tbody></table>';
        }
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }

    public function actionRetirarFondos() {

        $model = new OrdenesPago;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenesPago'])) {
            $model->attributes = $_POST['OrdenesPago'];
            $model->estado = OrdenesPago::ESTADO_PENDIENTE;
            $model->origenOperacion = OrdenesPago::ORIGEN_OPERACION_RETIRO_FONDOS;
            $model->descripcion = "RETIRO: ".$model->descripcion;

            $productoCtaCte = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
                    array(":clienteId" => $_POST['OrdenesPago']['clienteId'], 
                    ":productoId" => $_POST['OrdenesPago']['productoId'], ":nombreModelo" => "Clientes"));
            if (!isset($productoCtaCte))
                return false;

            $model->productoCtaCteId = $productoCtaCte->id;
            //$model->monedaId = 2; //pesos
            //$model->tasaCambio = Monedas::model()->findByPk($model->monedaId)->tasaCambioVenta;
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {
                if ($model->save()) {
                    $sql = "INSERT INTO formaPagoOrden (ordenPagoId, monto, tipoFormaPago, formaPagoId) values (:ordenPagoId, :monto, :tipoFormaPago, :formaPagoId)";
                    $command = $connection->createCommand($sql);
                    $command->bindValue(":ordenPagoId", $model->id, PDO::PARAM_STR);
                    $command->bindValue(":monto", $model->monto, PDO::PARAM_STR);
                    $command->bindValue(":tipoFormaPago", FormaPagoOrden::TIPO_EFECTIVO, PDO::PARAM_STR);
                    $command->bindValue(":formaPagoId", 0, PDO::PARAM_STR);
                    $command->execute();

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'El retiro de fondos fue creado con exito');
                    $model = new OrdenesPago;
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $model->unsetAttributes();
        $this->render('retiroFondos', array(
            'model' => $model, 'cliente' => new Clientes()
        ));
    }

    public function actionFinal($id) {
        $model = $this->loadModel($id);
        $ejecutar = '<script type="text/javascript" language="javascript">
		window.open("'.Yii::app()->createUrl("/ordenesPago/reciboPDF", array("id"=>$id)).'");
		</script>';

        Yii::app()->session['ejecutar'] = $ejecutar;
        Yii::app()->user->setFlash('success', 'Orden de Pago Procesada con exito');
        $model->unsetAttributes();
        $this->redirect(array('admin'));
    }

    public function actionRetirarFondosFinanciera() {

        $model = new OrdenesPago;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenesPago'])) {
            $model->attributes = $_POST['OrdenesPago'];
            $model->estado = OrdenesPago::ESTADO_PENDIENTE;
            $model->origenOperacion = OrdenesPago::ORIGEN_OPERACION_RETIRO_FONDOS;
            $model->descripcion = "RETIRO: ".$model->descripcion;

            $productoCtaCte = Productoctacte::model()->find("pkModeloRelacionado=:financieraId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
                    array(":financieraId" => $_POST['OrdenesPago']['financieraId'], 
                    ":productoId" => $_POST['OrdenesPago']['productoId'], ":nombreModelo" => "Financieras"));
            if (!isset($productoCtaCte))
                return false;

            $model->productoCtaCteId = $productoCtaCte->id;
            //$model->monedaId = 2; //pesos
            //$model->tasaCambio = Monedas::model()->findByPk($model->monedaId)->tasaCambioVenta;
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();

            try {
                if ($model->save()) {
                    $sql = "INSERT INTO formaPagoOrden (ordenPagoId, monto, tipoFormaPago, formaPagoId) values (:ordenPagoId, :monto, :tipoFormaPago, :formaPagoId)";
                    $command = $connection->createCommand($sql);
                    $command->bindValue(":ordenPagoId", $model->id, PDO::PARAM_STR);
                    $command->bindValue(":monto", $model->monto, PDO::PARAM_STR);
                    $command->bindValue(":tipoFormaPago", FormaPagoOrden::TIPO_EFECTIVO, PDO::PARAM_STR);
                    $command->bindValue(":formaPagoId", 0, PDO::PARAM_STR);
                    $command->execute();

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'El retiro de fondos fue creado con exito');
                    $model = new OrdenesPago;
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        $model->unsetAttributes();
        $this->render('retiroFondosFinanciera', array(
            'model' => $model, 'Financieras' => new Financieras()
        ));
    }

}
