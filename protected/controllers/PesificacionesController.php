<?php

class PesificacionesController extends Controller {

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
                'actions' => array('create', 'update', 'resumenPDF', 'admin', 'getDetallePesificaciones', 'acreditar', 'resumenPDF', 'detallePesificacion','acreditacionPesificacion','getSaldo'),
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
        echo '<script type="text/javascript" language="javascript">
		window.open("resumenPDF/' . $id . '");
		</script>';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Pesificaciones;

        $cheques = new Cheques('search');
        $cheques->unsetAttributes();  // clear any default values
        if (isset($_GET['Cheques']))
            $cheques->attributes = $_GET['Cheques'];


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Pesificaciones'])) {
            $model->attributes = $_POST['Pesificaciones'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $model->montoAcreditar = 0;
            $model->montoGastos = 0;
            $model->estado = Pesificaciones::ESTADO_ABIERTO;
            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {
                //throw new Exception("hola");
                if ($model->save()) {
                    $comisionPesificador=0;
                    $pesificacionId = $model->id;
                    $sql = "INSERT INTO detallePesificaciones (pesificacionId, chequeId, tipoMov, conceptoId, estado, monto) VALUES(:pesificacionId, :chequeId, :tipoMov, :conceptoId, :estado, :monto)";
                    $command = $connection->createCommand($sql);
                    $listaDetallePesificaciones = explode(';', $_POST['detallesPesificaciones']);
                    $tasaDescuento = $model->pesificador->tasaDescuento;
                        for ($i = 1; $i < count($listaDetallePesificaciones); $i++) {
                            $cheques = Cheques::model()->findByPk($listaDetallePesificaciones[$i]);
                            $cheques->estado = Cheques::TYPE_EN_PESIFICADOR;
                            $command->bindValue(":pesificacionId", $pesificacionId, PDO::PARAM_STR);
                            $command->bindValue(":chequeId", $listaDetallePesificaciones[$i], PDO::PARAM_STR);
                            $command->bindValue(":tipoMov", DetallePesificaciones::TYPE_DEBITO, PDO::PARAM_INT);
                            $command->bindValue(":conceptoId", 1, PDO::PARAM_INT);
                            $command->bindValue(":estado", 1, PDO::PARAM_INT);
                            $command->bindValue(":monto", $cheques->montoOrigen, PDO::PARAM_STR);
                            $command->execute();
                            if (!$cheques->save())
                                throw new Exception($cheques->getErrors());
                            $model->montoGastos+=($cheques->montoOrigen * $tasaDescuento) / 100;
                            $comisionPesificador+=$cheques->montoOrigen *($tasaDescuento/100);
                        }
                     // con la comision del pesificador calculada registramos el gasto.
                    $sql = "INSERT INTO detallePesificaciones (pesificacionId, chequeId, tipoMov, conceptoId, estado, monto) VALUES(:pesificacionId, :chequeId, :tipoMov, :conceptoId, :estado, :monto)";
                    $command = $connection->createCommand($sql);
                    $command->bindValue(":pesificacionId", $pesificacionId, PDO::PARAM_STR);
                    $command->bindValue(":chequeId", 0, PDO::PARAM_STR);
                    $command->bindValue(":tipoMov", DetallePesificaciones::TYPE_CREDITO, PDO::PARAM_INT);
                    $command->bindValue(":conceptoId", 5, PDO::PARAM_INT);
                    $command->bindValue(":estado", 1, PDO::PARAM_INT);
                    $command->bindValue(":monto", $comisionPesificador, PDO::PARAM_STR);
                    $command->execute();
                    $model->save();
                    $transaction->commit();
                    $cheques = new Cheques('search');
                    $cheques->unsetAttributes();  // clear any default values
                    echo '<script type="text/javascript" language="javascript">
                                                window.open("ResumenPDF/' . $model->id . '");
                                                </script>';
                    Yii::app()->user->setFlash('success', 'Pesificacion creada con exito');
                } else
                    Yii::app()->user->setFlash('error', 'Error al crear la pesificacion');
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Error al crear la pesificacion:' . $e->getMessage());
            }
        }

        $this->render('create', array(
            'model' => $model, 'cheques' => $cheques, 'valor' => 'prueba'
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

        if (isset($_POST['Pesificaciones'])) {
            $model->attributes = $_POST['Pesificaciones'];
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
        $dataProvider = new CActiveDataProvider('Pesificaciones');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Pesificaciones('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pesificaciones']))
            $model->attributes = $_GET['Pesificaciones'];

        $cheques = new Cheques('search');
        $cheques->unsetAttributes();  // clear any default values
        if (isset($_GET['Cheques'])) {
            $cheques->attributes = $_GET['Cheques'];
        }

        $this->render('admin', array(
            'model' => $model, 'cheques' => $cheques
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Pesificaciones::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pesificaciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetDetallePesificaciones() {
        if (isset($_POST['pesificacionesId'])) {
            $model = $this->loadModel($_POST['pesificacionesId']);
            $monto = 0;
            foreach ($model->detallePesificaciones as $detallePesificaciones) {
                $monto+=$detallePesificaciones->cheque->montoOrigen;
            }
            $gastosPesificacion = ($monto * $model->pesificador->tasaDescuento) / 100;
            $totalNetoCheques = $monto - $gastosPesificacion;
            $dataProvider = $model->searchById();
            $render = $this->renderPartial('/detallePesificaciones/verDetalles', array('dataProvider' => $dataProvider, 'model' => new Pesificaciones, "totalNetoCheques" => $totalNetoCheques), true);
            echo $render . ';' . $monto . ';' . $model->montoAcreditar . ';' . $model->montoGastos . ';' . $gastosPesificacion;
        }
    }

    public function actionAcreditar() {
        if (isset($_POST['pesificacionId'])) {
            $valor = '';
            $model = $this->loadModel($_POST['pesificacionId']);
            // $model->montoAcreditar = $_POST['montoAcreditar'];
            // $model->montoGastos = $_POST['montoGastos'];

            // $saldo = $_POST["totalNominalCheques"] - $model->montoAcreditar - $model->montoGastos;
            if ($model->saldo == 0)
                $model->estado = Pesificaciones::ESTADO_CERRADO;

            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {

                    $detallePesificaciones = $model->searchById();
                    foreach( $detallePesificaciones->getData() as $detallePesificacion) {
                        /*conceptoId=4 es Efectivo muevo a caja de operaciones*/
                        if($detallePesificacion->estado==DetallePesificaciones::ESTADO_PENDIENTE){
                            if($detallePesificacion->conceptoId==4){
                                $flujoFondos = new FlujoFondos;
                                $flujoFondos->cuentaId = '6'; // corresponde caja de operaciones
                                $flujoFondos->conceptoId = 22; // Acreditacion Efectivo Pesificacion
                                $flujoFondos->descripcion = "Acreditacion en pesificacion";
                                $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
                                $flujoFondos->monto = $detallePesificacion->monto;

                                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;


                                $flujoFondos->fecha = Date("d/m/Y");
                                $flujoFondos->origen = 'Pesificaciones';
                                $flujoFondos->identificadorOrigen = $model->id;
                                $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                                $flujoFondos->userStamp = Yii::app()->user->model->username;
                                $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                                $flujoFondos->save();

                            }
                            $detallePesificacion->estado=DetallePesificaciones::ESTADO_ACREDITADO;
                            $detallePesificacion->save();
                        }
                    }
                    //si esta cerrado hago los movimientos correspondientes
                    if ($model->estado == Pesificaciones::ESTADO_CERRADO) {
                        foreach ($model->detallePesificaciones as $detallePesificaciones) {

                            if(isset($detallePesificaciones->chequeId)){
                                $cheque = $detallePesificaciones->cheque;
                                $tasaDiferencial = $cheque->pesificacion - $model->pesificador->tasaDescuento;
                                $operadorClienteId = $cheque->operacionCheque->operador->clienteId;
                                $montoTotalComision = abs($tasaDiferencial) * $detallePesificaciones->cheque->montoOrigen / 100;
                                if ($tasaDiferencial != 0) {

                                    $comisionOperador = $cheque->operacionCheque->operador->comision;
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
                                    // $this->actionAcreditarCtacteCliente($tipoMov, $conceptoId, $operadorClienteId, $descripcion, "Pesificaciones",$model->id, $montoComision);

                                    $valor = "paso3";
                                    
                                    $criteria = new CDbCriteria();
                                    $criteria->condition = "identificadorOrigen=:chequeId AND origen='Cheques' AND cuentaId=:cuentaId";
                                    $criteria->params = array(":chequeId" => $cheque->id, ":cuentaId" => 11);
                                    $movPrevision = FlujoFondos::model()->find($criteria);

                                    $diferenciaPesificacionReal = $movPrevision->monto - $cheque->montoOrigen*$model->pesificador->tasaDescuento/100;

                                    $flujoFondos = new FlujoFondos;
                                    $flujoFondos->cuentaId = '12'; // diferencia pesificaciones
                                    $flujoFondos->conceptoId = 18; 
                                    $flujoFondos->descripcion = "Diferencia de la pesificacion por la compra del cheque nro. ".$cheque->numeroCheque;
                                    

                                    if($diferenciaPesificacionReal > 0){
                                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;    
                                        $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
                                    }else{
                                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                                        $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                                    }

                                    $flujoFondos->monto = abs($diferenciaPesificacionReal);
                                    $flujoFondos->fecha = Date("d/m/Y");
                                    $flujoFondos->origen = 'DetallePesificaciones';
                                    $flujoFondos->identificadorOrigen = $detallePesificaciones->id;
                                    $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                                    $flujoFondos->userStamp = Yii::app()->user->model->username;
                                    $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                                    $flujoFondos->save();
                                    if(!$flujoFondos->save()) {
                                        throw new Exception("Error al efectuar movimiento en fondo de inversores", 1); 
                                    }
                                }

                                $tipoMov = CtacteClientes::TYPE_CREDITO;
                                $conceptoId = '19'; //Acreditacion cheques

                                if($detallePesificaciones->chequeId!=0) {
                                    $cheque = $detallePesificaciones->cheque;
                                    $cheque->estado = Cheques::TYPE_ACREDITADO;
                                    $cheque->save();
                                }

                                $colocaciones = Colocaciones::model()->find('chequeId=:chequeId AND estado=:estado', array(':chequeId' => $detallePesificaciones->chequeId, ':estado' => Colocaciones::ESTADO_ACTIVA));

                                if ($colocaciones != null) {
                                    for ($i = 0; $i < count($colocaciones->detalleColocaciones); $i++) {

                                        // $cheques = Cheques::model()->findByPk($detallePesificaciones->cheque->id);
                                        // $cheques->estado = Cheques::TYPE_ACREDITADO;
                                        // $cheques->save();
                                        $this->actionAcreditarCtacteCliente($tipoMov, $conceptoId, $colocaciones->detalleColocaciones[$i]->clienteId, "Acreditacion cheque numero " . $detallePesificaciones->cheque->numeroCheque, "Pesificaciones",$model->id, $colocaciones->detalleColocaciones[$i]->monto);
                                    }
                                } 
                            }
                        }
                    }
                    //tasa diferencial
                }
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Acreditacion realizada con exito');
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', $valor . $e->getMessage());
            }

            $model->unsetAttributes();
            $this->render('admin', array(
                'model' => $model
            ));
        }
    }

    public function actionAcreditarCtacteCliente($tipoMov, $conceptoId, $clienteId, $descripcion, $origen, $identificadorOrigen, $monto) {

        $ctacteCliente = new CtacteClientes();
        $ctacteCliente->clienteId=$clienteId;
        $saldoAcumuladoActual = $ctacteCliente->getSaldoAcumuladoActual();
        if($tipoMov==CtacteClientes::TYPE_DEBITO)
            $saldoAcumulado=$saldoAcumuladoActual-$monto;
        else
            $saldoAcumulado=$saldoAcumuladoActual+$monto;
        $sql = "INSERT INTO ctacteClientes
                                            (tipoMov, conceptoId, clienteId, productoId, descripcion, monto, fecha, origen, identificadorOrigen,  userStamp, timeStamp, sucursalId, saldoAcumulado)
                                            VALUES (:tipoMov, :conceptoId, :clienteId, :productoId, :descripcion, :monto, :fecha, :origen, :identificadorOrigen, :userStamp, :timeStamp, :sucursalId, :saldoAcumulado)";

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
        $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_INT);
        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
        $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
        $command->execute();
    }

    public function actionResumenPDF($id) {
        $model = $this->loadModel($id);
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Resumen de la Pesificacion");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 12);
        $pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Detalles de la Pesificacion', 0, 1, 'C');

        $html = '
			<table border="1">
				<thead>
				<tr>
				<th>Numero Cheque</th><th>Fecha Pago</th><th>Monto</th><th>Tipo</th>
			</tr>
			</thead>';
        $monto = 0;

        foreach ($model->detallePesificaciones as $detallePesificaciones) {
            $html.="<tbody><tr>
					<td>" . $detallePesificaciones->cheque->numeroCheque . "</td><td>" . $detallePesificaciones->cheque->fechaPago . "</td><td>" . Utilities::MoneyFormat($detallePesificaciones->cheque->montoOrigen) . "</td><td>" . $detallePesificaciones->cheque->getTypeDescription("tipoCheque") . "</td></tr>";
            $monto+=$detallePesificaciones->cheque->montoOrigen;
        }
        $html.='</tbody></table>';
        $html.='<br>';
        $html.='Monto: ' . Utilities::MoneyFormat($monto) . '<br/><br/>';
        $html.='Pesificador: ' . $model->pesificador->denominacion . '<br/><br/>';
        $html.='% Pesificacion: ' . ($model->pesificador->tasaDescuento) . '<br/><br/>';
        $gastoTotal = ($monto * $model->pesificador->tasaDescuento) / 100;
        $total = $monto - $gastoTotal;
        $html.='TOTAL: ' . Utilities::MoneyFormat($total);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($model->id . ".pdf", "I");
    }

    public function actionDetallePesificacion() {
        if (isset($_GET["pesificacionId"])) {
            $model = $this->loadModel($_GET['pesificacionId']);
            $totalNominalCheques = 0;
            foreach ($model->detallePesificaciones as $detallePesificaciones) {
                $totalNominalCheques+=$detallePesificaciones->cheque->montoOrigen;
            }
            $gastosPesificacion = ($totalNominalCheques * $model->pesificador->tasaDescuento) / 100;
            $totalNetoCheques = $totalNominalCheques - $gastosPesificacion;
            //            $render = $this->renderPartial('/detallePesificaciones/verDetalles', array('dataProvider' => $dataProvider, 'model' => new Pesificaciones, "totalNetoCheques" => $totalNetoCheques), true);
            //            echo $render . ';' . $monto . ';' . $model->montoAcreditar . ';' . $model->montoGastos . ';' . $gastosPesificacion;
            //

            $this->render("detallePesificacion", array("model" => $model, "totalNetoCheques" => $totalNetoCheques, "totalNominalCheques" => $totalNominalCheques, "gastosPesificacionCheques" => $gastosPesificacion, "cheques" => new Cheques()));
        }
    }

    public function actionAcreditacionPesificacion(){
        if (isset($_GET["pesificacionId"])) {
            $model = $this->loadModel($_GET['pesificacionId']);
            // $totalNominalCheques = 0;
            // foreach ($model->detallePesificaciones as $detallePesificaciones) {
            //     $totalNominalCheques+=$detallePesificaciones->cheque->montoOrigen;
            // }
            // $gastosPesificacion = ($totalNominalCheques * $model->pesificador->tasaDescuento) / 100;
            // $totalNetoCheques = $totalNominalCheques - $gastosPesificacion;
            //            $render = $this->renderPartial('/detallePesificaciones/verDetalles', array('dataProvider' => $dataProvider, 'model' => new Pesificaciones, "totalNetoCheques" => $totalNetoCheques), true);
            //            echo $render . ';' . $monto . ';' . $model->montoAcreditar . ';' . $model->montoGastos . ';' . $gastosPesificacion;
            //

            $render = $this->renderPartial('/detallePesificaciones/verDetalles', array( 'model' => $model), true, true);
            $this->render("acreditacionPesificacion", array("model" => $model, "render"=>$render));
        }
    }

    public function actionGetSaldo(){
        if(isset($_GET["id"])){
            $model = $this->loadModel($_GET['id']);
            echo Utilities::MoneyFormat(abs($model->saldo));
        }

    }

}
