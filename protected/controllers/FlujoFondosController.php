<?php

class FlujoFondosController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'adminCaja', 'filtrar', 'cierreCaja', 'movimientoCuentas',
                    'calcular', 'realizar', 'cancelar', 'createMov', 'cierreCajaPDF', 'mayorCuentas', 'gridMayorCuentas'),
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
        $model = new FlujoFondos;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FlujoFondos'])) {
            $model->attributes = $_POST['FlujoFondos'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['FlujoFondos'])) {
            $model->attributes = $_POST['FlujoFondos'];
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
        $dataProvider = new CActiveDataProvider('FlujoFondos');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new FlujoFondos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FlujoFondos'])) {
                $model->attributes = $_GET['FlujoFondos'];
         if (isset($_GET['fechaDesde'])){
            $model->fechaDesde=date('Y-m-d', CDateTimeParser::parse($_GET['fechaDesde'], 'dd/MM/yyyy'));
            $model->fechaHasta=date('Y-m-d', CDateTimeParser::parse($_GET['fechaHasta'], 'dd/MM/yyyy'));
          }else {
            $model->fechaDesde=date('Y-m-d', CDateTimeParser::parse($model->fechaDesde, 'dd/MM/yyyy'));
            $model->fechaHasta=date('Y-m-d', CDateTimeParser::parse($model->fechaHasta, 'dd/MM/yyyy'));
          }
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = FlujoFondos::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAdminCaja() {
        $model = new FlujoFondos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FlujoFondos']))
            $model->attributes = $_GET['FlujoFondos'];

        $this->render('adminCaja', array(
            'model' => $model,
        ));
    }

    public function actionFiltrar() {
        $model = new FlujoFondos;
        $fechaDesde = Utilities::MysqlDateFormat($_GET['fechaDesde']);
        $fechaHasta = Utilities::MysqlDateFormat($_GET['fechaHasta']);
        $model->fechaDesde = $fechaDesde;
        $model->fechaHasta = $fechaHasta;

        $dataProvider = $model->searchByDate($fechaDesde, $fechaHasta);
        $this->renderPartial('_adminCaja', array('flujoFondos' => $model,
            'dataProvider' => $dataProvider,
        ));
        $saldo = $model->getSaldoByDate($fechaDesde, $fechaHasta);
        if ($saldo == 0) {
            echo "<div align='right'><b><font color='navy'>Saldo: 0,00</font></b></div>";
        } elseif ($saldo > 0) {
            echo "<div align='right'><b><font color='green'>Saldo: " . Yii::app()->numberFormatter->format("#,##0.00", $saldo) . "</font></b></div>";
        } elseif ($saldo < 0) {
            echo "<div align='right'><b><font color='red'>Saldo: " . Yii::app()->numberFormatter->format("#,##0.00", $saldo) . "</font></b></div>";
        };
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'flujo-fondos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCierreCaja() {
        $model = new Cheques('search');
        $model->unsetAttributes();
//        if (isset($_GET['FlujoFondos']))
//            $model->attributes = $_GET['FlujoFondos'];
//        if(isset($_POST))
//            Yii::app()->user->setFlash('success', var_dump($_POST));
        if (isset($_POST['btnCierre'])) {
            $valor = "";
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                $chequesColocados = Cheques::model()->findChequesColocadosDelDia();

                $conceptoId = '17'; //ganancia comisiones
                $error = '';
                $gananciaCapital = 0;
                $tipoMov = CtacteClientes::TYPE_CREDITO;
                foreach ($chequesColocados as $cheque) {
//                    $tasaDescuento = $cheque->tasaDescuento;
                    $colocacion = Colocaciones::model()->getColocacionActiva($cheque->id);
                    $gananciaTotal = $cheque->montoOrigen - $cheque->montoNeto;
                    //echo "Ganancia 1:".$gananciaTotal;
                    if ($colocacion != null) {
                        $montoFlujoFondos = 0;
                        $montoComisionOperadorTomador = 0;

                        foreach ($colocacion->detalleColocaciones as $detalleColocacion) {
                            $montoInversor = $colocacion->calculoValorActual($detalleColocacion->monto, Utilities::ViewDateFormat($cheque->fechaPago), $detalleColocacion->tasa, $colocacion->getClearing());
                            $gananciaInversor = $detalleColocacion->monto - $montoInversor;
                            //echo "Ganancia Inversor:".$gananciaInversor;
                            $gananciaTotal-=$gananciaInversor;
                        }
                        //echo "Ganancia 2:".$gananciaTotal;
                        $tasaPromedioPesificacion=Yii::app()->user->model->sucursal->tasaPromedioPesificacion;
                        $gastoPromedioPesificacion =($tasaPromedioPesificacion*$cheque->montoOrigen)/100;

                        $gananciaTotal-=$gastoPromedioPesificacion;
                        //echo "Ganancia 3:".$gananciaTotal;
                        $descripcion = "Ganancia en comision por colocacion en cheque numero " . $cheque->numeroCheque;
                        //lo que me quedo de la gananica luego de haber restado todas las ganancias de los inversores
                        //pregunta esa ganancia de los operadores inversores es la misma para todos??? osea se divide en la cantidad de clientes inversores???
                        $gananciaOperadoresInversores = $gananciaTotal * (0.1);
                        $gananciaOperadorTomador = $gananciaTotal * (0.1);
                        $gananciaCapital += $gananciaTotal * (0.8);

                        foreach ($colocacion->detalleColocaciones as $detalleColocacion) {

                            $porcentajeColocacion = $detalleColocacion->monto/$cheque->montoOrigen;
                            $gananciaOperadorInversor = $gananciaOperadoresInversores*$porcentajeColocacion;
                            $cliente  = $detalleColocacion->cliente;
                            $operador = $cliente->operador;
                            $clienteId = $operador->clienteId;
                            // $this->actionAcreditarCtacteCliente($tipoMov, $conceptoId, $clienteId, $descripcion, "DetalleColocaciones", $detalleColocacion->id , $gananciaOperadorInversor);
                            $comisionOperador = new ComisionesOperadores();
                            $comisionOperador->detalleColocacionId = $detalleColocacion->id;
                            $comisionOperador->operadorId = $operador->id;
                            $comisionOperador->porcentaje = $porcentajeColocacion;
                            $comisionOperador->monto = Utilities::truncateFloat($gananciaOperadorInversor,2);
                            $comisionOperador->estado = ComisionesOperadores::ESTADO_PENDIENTE;
                            if(!$comisionOperador->save())
                                throw new Exception(var_dump($comisionOperador->getErrors()), 1);

                        }
                        $operacionCheque  = $cheque->operacionCheque;
                        $cliente = $operacionCheque->cliente;

                        $comisionOperador = new ComisionesOperadores();
                        $comisionOperador->detalleColocacionId = $colocacion->detalleColocaciones[0]->id;
                        $comisionOperador->operadorId = $cliente->operadorId;
                        $comisionOperador->porcentaje = 1;
                        $comisionOperador->monto = Utilities::truncateFloat($gananciaOperadorTomador,2);
                        $comisionOperador->estado = ComisionesOperadores::ESTADO_PENDIENTE;
                        if(!$comisionOperador->save())
                            throw new Exception(var_dump($comisionOperador->getErrors()), 1);
                        //$this->actionAcreditarCtacteCliente($tipoMov, $conceptoId, $clienteId, $descripcion, "DetalleColocaciones",$detalleColocacion->id, $gananciaOperadorTomador);

                    }

                    $cheque->comisionado = true;
                    $cheque->save();
                }

                $flujoFondos = new FlujoFondos;
                $flujoFondos->cuentaId = '8'; // corresponde fondo fijo
                $flujoFondos->conceptoId = $conceptoId; // concepto para Compra de Cheques
                $flujoFondos->descripcion = "Ganancia de Capital por Colocaciones";
                $flujoFondos->tipoFlujoFondos = $tipoMov;

                $flujoFondos->monto = $gananciaCapital;
                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto; //tipo mov es credito
                $flujoFondos->fecha = Date("d/m/Y");
                $flujoFondos->origen = 'Colocaciones';
                $flujoFondos->identificadorOrigen = 0;
                $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                $flujoFondos->userStamp = Yii::app()->user->model->username;
                $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                $flujoFondos->save();

                $flujoFondos = new FlujoFondos;
                $flujoFondos->cuentaId = '12'; // diferencia pesificaciones
                $saldo = $flujoFondos->getSaldoAcumuladoActual();
                $flujoFondos->monto = abs($saldo);
                if($saldo > 0){ 
                    $tipoMov = FlujoFondos::TYPE_DEBITO;
                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto; //tipo mov es credito
                } else {
                    $tipoMov = FlujoFondos::TYPE_CREDITO;
                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto; //tipo mov es credito
                }
                $flujoFondos->conceptoId = "25"; // concepto para Compra de Cheques
                $flujoFondos->descripcion = "Saldo cuenta de diferencia de pesificaciones saldado";
                
                $flujoFondos->fecha = Date("d/m/Y");
                $flujoFondos->origen = '';
                $flujoFondos->identificadorOrigen = 0;
                $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                $flujoFondos->userStamp = Yii::app()->user->model->username;
                $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                $flujoFondos->save();

                // $flujoFondos = new FlujoFondos;
                // $flujoFondos->cuentaId = '8'; // corresponde fondo fijo
                // $flujoFondos->conceptoId = "25"; // concepto para Compra de Cheques
                // $flujoFondos->descripcion = "Saldo Diferencia por pesificaciones";
                // $flujoFondos->tipoFlujoFondos = $tipoMov;

                // $flujoFondos->monto = abs($saldo);
                // if($saldo > 0){ 
                //     $tipoMov = FlujoFondos::TYPE_CREDITO;
                //     $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto; //tipo mov es credito
                // } else {
                //     $tipoMov = FlujoFondos::TYPE_DEBITO;
                //     $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto; //tipo mov es credito
                // }

                // $flujoFondos->fecha = Date("d/m/Y");
                // $flujoFondos->origen = '';
                // $flujoFondos->identificadorOrigen = 0;
                // $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                // $flujoFondos->userStamp = Yii::app()->user->model->username;
                // $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                // $flujoFondos->save();
                //$transaction->rollBack();
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Movimiento realizado con exito' . $valor);
                echo '<script type="text/javascript" language="javascript">
		window.open("'.Yii::app()->createUrl("/flujoFondos/cierreCajaPDF").'");
		</script>';
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
            $cheques = Cheques::model()->searchChequesByEstado(Cheques::TYPE_EN_CARTERA_SIN_COLOCAR);
            if(count($cheques->getData())>0){
                $deshabilitarSubmit = "disabled";
                Yii::app()->user->setFlash('error', "Existen cheques sin colocar. Por favor coloquelos para poder hacer el arqueo");
            }else
                $deshabilitarSubmit = false;
            $this->render('cierreCaja', array('deshabilitarSubmit' => $deshabilitarSubmit,
                'cheques' => $model, 'cuentaPesos' => Cuentas::model()->findByPk('6'), 'cuentaDolares' => Cuentas::model()->findByPk('9'),
            ));

    }

    public function actionAcreditarCtacteCliente($tipoMov, $conceptoId, $clienteId, $descripcion, $origen, $identificadorOrigen, $monto) {

        $sql = "INSERT INTO ctacteClientes
                                            (tipoMov, conceptoId, clienteId, productoId, descripcion, monto, fecha, origen, identificadorOrigen, userStamp, timeStamp, sucursalId, saldoAcumulado)
                                            VALUES (:tipoMov, :conceptoId, :clienteId, :productoId, :descripcion, :monto, :fecha, :origen, :identificadorOrigen, :userStamp, :timeStamp, :sucursalId, :saldoAcumulado)";

        $ctacteCliente = new CtacteClientes();
        $ctacteCliente->clienteId=$clienteId;
        $saldoAcumuladoActual = $ctacteCliente->getSaldoAcumuladoActual();
        if($tipoMov==CtacteClientes::TYPE_DEBITO)
            $saldoAcumulado=$saldoAcumuladoActual-$monto;
        else
            $saldoAcumulado=$saldoAcumuladoActual+$monto;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $productoId = 1;
        $fecha = Date("Y-m-d");
        $userStamp = Yii::app()->user->model->username;
        $timeStamp = Date("Y-m-d h:m:s");
        $sucursalId = Yii::app()->user->model->sucursalId;

        $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
        $command->bindValue(":clienteId", $clienteId, PDO::PARAM_STR);
        $command->bindValue(":productoId", $productoId, PDO::PARAM_STR);
        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
        $command->bindValue(":monto", $monto, PDO::PARAM_STR);
        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        $command->bindValue(":origen", $origen, PDO::PARAM_STR);
        $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_STR);
        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
        $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
        $command->execute();
    }

    public function actionCalcular() {
        $model = new FlujoFondos;
        $diferencia = "";
        switch ($_POST['moneda']) {
            case "pesos":
                $diferencia = $model->calcularDiferencia($_POST['total'], '6');
                break;
            case "dolares":
                $diferencia = $model->calcularDiferencia($_POST['total'], '9');
                break;
            default;
        }
        echo $diferencia;
    }

    public function actionMovimientoCuentas() {
        $model = new MovimientosCuentas;
        $this->render('movimientoCuentas', array(
            'model' => $model,
        ));
    }

    public function actionCreateMov() {
        if (isset($_POST['MovimientosCuentas'])) {  //recibimos los campos desde el Formulario
            $model = new FlujoFondos;
            $movimiento = new MovimientosCuentas;
            $movimiento->attributes = $_POST['MovimientosCuentas'];
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            $valid = $movimiento->validate();
            if ($movimiento->monto > 0) {
                if (strlen($movimiento->descripcion) != 0) {
                    try {

                        //hacemos el descuento en la cuenta origen
                        $sql = "INSERT INTO flujoFondos
						  (cuentaId, conceptoId,descripcion, tipoFlujoFondos, monto, fecha, origen,identificadorOrigen, userStamp, timeStamp, sucursalId, saldoAcumulado)
				 VALUES (:cuentaId, :conceptoId, :descripcion, :tipoFlujoFondos, :monto, :fecha, :origen,:identificadorOrigen, :userStamp, :timeStamp, :sucursalId, :saldoAcumulado)";

                        $cuentaId = $movimiento->cuentaOrigen;
                        $tipoFlujoFondos = FlujoFondos::TYPE_DEBITO; //debito
                        $conceptoId = '14'; //Egreso de fondos por movimiento de cuenta
                        $descripcion = $movimiento->descripcion;
                        $fecha = Date("Y-m-d");
                        $monto = $movimiento->monto;
                        $origen = "FlujoFondos";
                        $identificadorOrigen = $movimiento->cuentaDestino;

                        $flujoFondos = new FlujoFondos();
                        $flujoFondos->cuentaId = $cuentaId;
                        $saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $monto; // es debito
                        $userStamp = Yii::app()->user->model->username;
                        $timeStamp = Date("Y-m-d h:m:s");
                        $sucursalId = Yii::app()->user->model->sucursalId;
                        $command = $connection->createCommand($sql);
                        $command->bindValue(":cuentaId", $cuentaId, PDO::PARAM_STR);
                        $command->bindValue(":tipoFlujoFondos", $tipoFlujoFondos, PDO::PARAM_STR);
                        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                        $command->bindValue(":monto", $monto, PDO::PARAM_STR);
                        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                        $command->bindValue(":origen", $origen, PDO::PARAM_STR);
                        $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_STR);
                        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                        $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
                        $command->execute();

                        //Hacemos el movimiento de ingreso de fondos en la otra cuenta

                        $cuentaId = $movimiento->cuentaDestino;
                        $tipoFlujoFondos = FlujoFondos::TYPE_CREDITO; //debito
                        $conceptoId = '15'; //Egreso de fondos por movimiento de cuenta
                        $descripcion = $movimiento->descripcion;
                        $fecha = Date("Y-m-d");
                        $monto = $movimiento->monto;
                        $origen = "FlujoFondos";
                        $identificadorOrigen = $movimiento->cuentaOrigen;

                        $flujoFondos = new FlujoFondos();
                        $flujoFondos->cuentaId = $cuentaId;
                        $saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $monto; // es credito
                        $userStamp = Yii::app()->user->model->username;
                        $timeStamp = Date("Y-m-d h:m:s");
                        $sucursalId = Yii::app()->user->model->sucursalId;
                        $command = $connection->createCommand($sql);
                        $command->bindValue(":cuentaId", $cuentaId, PDO::PARAM_STR);
                        $command->bindValue(":tipoFlujoFondos", $tipoFlujoFondos, PDO::PARAM_STR);
                        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                        $command->bindValue(":monto", $monto, PDO::PARAM_STR);
                        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                        $command->bindValue(":origen", $origen, PDO::PARAM_STR);
                        $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_STR);
                        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                        $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
                        $command->execute();

                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Movimiento realizado con exito');
                        $this->redirect(array('movimientoCuentas'));
                    } catch (Exception $e) { // an exception is raised if a query fails
                        $transaction->rollback();
                        echo "Error" . $e;
                        echo "--------------<br>";
                        print_r($movimiento);
                    }
                } else {
                    Yii::app()->user->setFlash('error', 'Debe Especificar una descripcion');
                    $this->redirect(array('movimientoCuentas'));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Debe Especificar el Monto');
                $this->redirect(array('movimientoCuentas'));
            }
        }
    }

    public function actionCancelar() {

    }

    public function actionCierreCajaPDF() {

        $fechaHoy = Date("Y-m-d");
        $sucursalId = Yii::app()->user->model->sucursalId;
        $gastosPesificacion = 0;
        $descuento = 0;
        $html = '';
        $chequesColocados = Cheques::model()->findChequesColocadosDelDia();
        $ordenesPago = OrdenesPago::model()->searchByFecha(Date("Y-m-d"));
        $ordenesIngreso = OrdenIngreso::model()->searchByFecha(Date("Y-m-d"));
        $flujoFondos = new FlujoFondos();
        $flujoFondos->cuentaId = 6;
        if (count($chequesColocados) > 0) {
            $html = '<table border="1">
                        <tr>
				            <td align="center">Nro Cheque</td><td align="center">Banco</td><td align="center">Librador</td><td align="center">Monto</td><td align="center">Fecha Vto.</td>
                        </tr>';
            foreach ($chequesColocados as $cheque) {
                $html.="<tr><td>" . $cheque->numeroCheque . "</td><td>" . $cheque->banco->nombre . "</td><td>" . $cheque->librador->denominacion . "</td><td>" . Utilities::MoneyFormat($cheque->montoOrigen) . "</td><td>" . Utilities::ViewDateFormat($cheque->fechaPago) . "</td></tr>";
            }
            $html.='</table>';
        }

        $html.='<br>';
        $html.='Total dinero en pesos: ' . Utilities::MoneyFormat($flujoFondos->getSaldoAcumuladoActual()) . '<br/><br/>';
        //$html.='Total dinero en dolares: ' . Utilities::MoneyFormat(OperacionesCambio::model()->getSaldo('9')) . '<br/><br/>';
        if (count($ordenesIngreso->getData()) > 0) {
            $html.='<table border="1">
                        <tr>
                            <td align="center">Nro Orden Ingreso</td><td align="center">Cliente</td><td align="center">Monto</td>
                        </tr>';
            foreach ($ordenesIngreso->getData() as $orden) {
                $html.="<tr><td>" . $orden->id . "</td><td>" . $orden->cliente->razonSocial . "</td><td>" . Utilities::MoneyFormat($orden->monto) . "</td></tr>";
            }
            $html.='</tbody></table>';
        }
        $html.='<br>';


        if (count($ordenesPago->getData()) > 0) {
            $html.='<table border="1">
                        <tr>
                            <td align="center">Nro Orden Pago</td><td align="center">Cliente</td><td align="center">Monto</td>
                        </tr>';
            foreach ($ordenesPago->getData() as $orden) {
                $html.="<tr><td>" . $orden->id . "</td><td>" . $orden->cliente->razonSocial . "</td><td>" . Utilities::MoneyFormat($orden->monto) . "</td></tr>";
            }
            $html.='</table>';
        }
        $html.='<br />';


        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Resumen del cierre de Caja");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 14);
        $pdf->Cell(0, 3, 'Detalles del cierre de caja Dia ' . Date("d-m-Y"), 0, 1, 'C');

        $pdf->SetFont("times", "", 12);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($cheque->id . ".pdf", "I");
    }

    public function actionMayorCuentas() {
        $model = new FlujoFondos;
        $this->render('mayorCuentas', array(
            'model' => $model,
        ));
    }

    public function actionGridMayorCuentas() {
        if (isset($_GET)) {
            $dataProvider = FlujoFondos::model()->searchByDateAndCuenta(Utilities::MysqlDateFormat($_GET["fechaIni"]), Utilities::MysqlDateFormat($_GET["fechaFin"]), $_GET["cuentaId"]);
            $this->renderPartial('_gridFlujoFondos', array('model' => new FlujoFondos,
                'dataProvider' => $dataProvider,
            ));
        }
    }

}
