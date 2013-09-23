<?php

class OperacionesChequesController extends Controller {

	////// Propiedades
	
	////// Métodos Nuevos
	
	public function actionCargarProductosCliente() {
		
		$cliente = Clientes::model()->findByPk($_POST['OperacionesCheques']['clienteId']); 
		
		$i = -9999999;
		
		foreach($cliente->productos as $producto) {
			if ($i == -9999999)
				$i = $producto->id;
			echo CHtml::tag('option', array('value'=>$producto->id),CHtml::encode($producto->nombre),true);
		}
		
		echo "<script>";
		if($cliente->tasaTomador != "")
			echo "$('#TmpCheques_tasaDescuento').val(".$cliente->tasaTomador.");";
        if($cliente->tasaPesificacionTomador != "")
            echo "$('#TmpCheques_pesificacion').val(".$cliente->tasaPesificacionTomador.");";
		echo "$('#clienteId').val($('#OperacionesCheques_clienteId').val());";
		echo "$('#productoId').val('".$i."');";
		echo "</script>";
	}
		
	////// Métodos Generados

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
                'actions' => array('create', 'update', 'admin', 'nuevaOperacion', 'generatePDF', 'ResumenPDF','imprimirPDF','anularOperacion', 'cargarProductosCliente'),
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
        $ejecutar = '<script type="text/javascript" language="javascript">
        window.open("'.Yii::app()->createUrl("/operacionesCheques/generatePDF", array("id"=>$id)).'");
        window.open("'.Yii::app()->createUrl("/operacionesCheques/ResumenPDF", array("id"=>$id)).'");
        </script>';

        Yii::app()->session['ejecutar'] = $ejecutar;
        // $modelos = array('model' => new OrdenesPago(), 'formaPagoOrden' => new FormaPagoOrden(), 'cheques' => new Cheques(), 'operacionChequeId' => $id);
        // $this->render('/ordenesPago/create', $modelos);
        $this->redirect(array('ordenesPago/create', 'operacionChequeId' => $id));
//		$this->render('view',array(
//			'model'=>$this->loadModel($id),
//		));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new OperacionesCheques;
        $cheque = new Cheques;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OperacionesCheques'])) {
            $model->attributes = $_POST['OperacionesCheques'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model, 'cheque' => $cheque,
        ));
    }

    public function actionNuevaOperacion() {
        $model = new OperacionesCheques;
        $tmpcheque = new TmpCheques;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['OperacionesCheques'])) {
            $model->attributes = $_POST['OperacionesCheques'];
            $model->estado = OperacionesCheques::ESTADO_A_PAGAR;
            $model->montoNetoTotal = Utilities::Unformat($model->montoNetoTotal);
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $tmpcheques = $command->select('*')->from('tmpCheques')->where('DATE(timeStamp)=:fechahoy AND userStamp=:username AND presupuesto=0', array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username))->queryAll();
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save() && count($tmpcheques) > 0) { //si valida OperacionCheque y ademas cargo algun TmpCheque
                    $operacionChequeId = $model->id;
                    $tasaPromedioPesificacion=Yii::app()->user->model->sucursal->tasaPromedioPesificacion;
                    foreach ($tmpcheques as $tcheque) {
                        $cheque = new Cheques();
                        $cheque->operacionChequeId = $operacionChequeId;
                        $cheque->tasaDescuento = $tcheque['tasaDescuento'];
                        $cheque->clearing = $tcheque['clearing'];
                        $cheque->pesificacion = $tcheque['pesificacion'];
                        $cheque->numeroCheque = $tcheque['numeroCheque'];
                        $cheque->libradorId = $tcheque['libradorId'];
                        $cheque->bancoId = $tcheque['bancoId'];
                        $cheque->montoOrigen = $tcheque['montoOrigen'];
                        $cheque->fechaPago = $tcheque['fechaPago'];
                        $cheque->tipoCheque = $tcheque['tipoCheque'];
                        $cheque->endosante = $tcheque['endosante'];
                        $cheque->montoNeto = $tcheque['montoNeto'];
                        $cheque->estado = $tcheque['estado'];
                        $cheque->tieneNota = $tcheque['tieneNota'];
                        if (!$cheque->save()) {
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error', var_dump($cheque->getErrors()));
                            $this->render('crear', array(
                                'model' => $model, 'tmpcheque' => $tmpcheque
                            ));
                        }

                         ##Acredito la prevision por la pesificacion usando la tasa promedio
                    
                        $previsionPesificacion = $cheque->montoOrigen*$tasaPromedioPesificacion/100;
                        $gastoPesificacion = $cheque->montoOrigen*$cheque->pesificacion/100;
                        $diferenciaPesificacion = $gastoPesificacion - $previsionPesificacion;

                        $flujoFondos = new FlujoFondos;
                        $flujoFondos->cuentaId = '11'; // fondo de inversores
                        $flujoFondos->conceptoId = 24; // credito en fondo inversores
                        $flujoFondos->descripcion = "Prevision de pesificacion para cheque nro. ".$cheque->numeroCheque;
                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;

                        $flujoFondos->monto = $previsionPesificacion;
                        $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto; //tipo mov es credito
                        $flujoFondos->fecha = Date("d/m/Y");
                        $flujoFondos->origen = 'Cheques';
                        $flujoFondos->identificadorOrigen = $cheque->id;
                        $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                        $flujoFondos->userStamp = Yii::app()->user->model->username;
                        $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                        $flujoFondos->save();
                        if(!$flujoFondos->save()) {
                            throw new Exception("Error al efectuar movimiento en fondo de inversores", 1); 
                        }

                        $flujoFondos = new FlujoFondos;
                        $flujoFondos->cuentaId = '12'; // diferencia pesificaciones
                        $flujoFondos->conceptoId = 18; 
                        $flujoFondos->descripcion = "Diferencia de la pesificacion por la compra del cheque nro. ".$cheque->numeroCheque;
                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;

                        $flujoFondos->monto = $diferenciaPesificacion;
                        $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto; //tipo mov es credito
                        $flujoFondos->fecha = Date("d/m/Y");
                        $flujoFondos->origen = 'Cheques';
                        $flujoFondos->identificadorOrigen = $cheque->id;
                        $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                        $flujoFondos->userStamp = Yii::app()->user->model->username;
                        $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                        $flujoFondos->save();
                        if(!$flujoFondos->save()) {
                            throw new Exception("Error al efectuar movimiento en fondo de inversores", 1); 
                        }
                    }
                    //borro los registros temporales
                    $command->delete('tmpCheques', 'DATE(timeStamp)=:fechahoy AND userStamp=:username AND presupuesto=0', array(':fechahoy' => Date('Y-m-d'), ':username' => Yii::app()->user->model->username));
                    /*
					$transaction->rollBack();
					print_r($_POST);
					exit;*/
					
					$productoCtaCte = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", 
                    array(":clienteId" => $_POST['OperacionesCheques']['clienteId'], 
                    ":productoId" => $_POST['OperacionesCheques']['productoId'], ":nombreModelo" => "Clientes"));
		            if (!isset($productoCtaCte))
		                throw new Exception("Error al obtener la información del cliente", 1); 
					
                    $ctacte = new Ctacte();
                    $ctacte->tipoMov = Ctacte::TYPE_CREDITO;
                    $ctacte->conceptoId = 12;
                    $ctacte->productoCtaCteId = $productoCtaCte->id;
                    $ctacte->descripcion = "Credito por la compra de cheques";
					$ctacte->sucursalId = Yii::app()->user->model->sucursalId;
                    $ctacte->monto = $model->montoNetoTotal;
                    $ctacte->saldoAcumulado=$ctacte->getSaldoAcumuladoActual()+$ctacte->monto;
                    $ctacte->fecha = date("Y-m-d");
                    $ctacte->origen = "OperacionesCheques";
                    $ctacte->identificadorOrigen = $model->id;
			        $ctacte->userStamp = Yii::app()->user->model->username;
			        $ctacte->timeStamp = Date("Y-m-d h:m:s");
					
                    if(!$ctacte->save())
                        throw new Exception("Error al efectuar movimiento en ctacte del cliente", 1);                        

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Movimiento realizado con exito');
                    $this->redirect(array('view', 'id' => $model->id));
                } else {
                    if (count($tmpcheques) == 0) {
                        $tmpcheque->addError('error', 'Debe ingresar al menos un cheque para cerrar la Operacion');
                        $transaction->rollBack();
                    }
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
        $model->init();
        $this->render('crear', array(
            'model' => $model, 'tmpcheque' => $tmpcheque
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

        if (isset($_POST['OperacionesCheques'])) {
            $model->attributes = $_POST['OperacionesCheques'];
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
        $dataProvider = new CActiveDataProvider('OperacionesCheques');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OperacionesCheques('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OperacionesCheques'])) {
            $model->attributes = $_GET['OperacionesCheques'];
        }
        if(isset(Yii::app()->session["ejecutar"])){
            echo Yii::app()->session["ejecutar"];
            unset(Yii::app()->session['ejecutar']);
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
        $model = OperacionesCheques::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'operaciones-cheques-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGeneratePDF($id) {
        $convertirNumero = new n2t();
        $model = $this->loadModel($id);
        $html = '<h2>CONTRATO DE COMPRA</h2>
				<h2><b>FECHA:</b></h2>
				<br/>
				Entre INTERNACIONAL BUSINESS ADVISORS S.A. (I.B.A), en adelante el COMPRADOR, representada en este caso por su Presidente, HERALDO JOSE IRIONDO,
				DNI: 17.613.879, con domicilio en calle San Martin N 631, piso 5, dpto. C, de la ciudad de San Miguel de Tucuman, provincia de Tucuman; y:
				<br/>
				<b>NOMBRE:</b> ' . $model->cliente->razonSocial . '
				<br/>
				<b>DNI:</b> ' . $model->cliente->documento . '
				<br/>
				<b>DOMICILIO:</b> ' . $model->cliente->direccion . '
				<br/>
				<br/>
				En adelante el VENDEDOR, acuerdan en celebrar el presente CONTRATO DE COMPRA de las siguientes especies:
				<br/><br/>
				<table border="1" cellpadding="3">
				<tr>
				<td align="center" style="width:10%">ESP.</td><td align="center" style="width:15%">BANCO</td><td align="center" style="width:10%">NRO.</td><td align="center" style="width:15%">VTO.</td><td align="center" style="width:20%">LIBRADOR</td><td align="center" style="width:15%">ENDOSANTE</td><td align="center" style="width:15%">IMPORTE</td>
				</tr>';
        foreach ($model->cheques as $cheque) {
            $html.='<tr>
					<td align="center">CH. PD.</td><td align="center">' . $cheque->banco->nombre . '</td><td align="center">' . $cheque->numeroCheque . '</td><td align="center">' . Utilities::ViewDateFormat($cheque->fechaPago) . '</td><td align="center">' . $cheque->librador->denominacion . '</td><td align="center">' . $cheque->endosante . '</td><td>' . Utilities::MoneyFormat($cheque->montoOrigen) . '</td>
					</tr>';
        }
        $html.="</table><br/><br/>
				Con relacion a las especies antes descriptas, las partes (COMPRADOR y VENDEDOR) de comun acuerdo declaran:<br/>
				Que estan de acuerdo en el precio pactado por la compra, el que asciende a la suma total:<br/>
				DE $: " . $model->montoNetoTotal . " (PESOS: " . Utilities::num2letras($model->montoNetoTotal) . "). <br/>
				1)Que el COMPRADOR no tiene conocimiento ni responsabilidad alguna con relacion al motivo por el cual se encuentran en posesion del VENDEDOR las especies antes citadas.<br/>
				2)Que el VENDEDOR es responsable por la acreditacion en tiempo y forma de las especies mencionadas en el cuadro precedente. En caso de rechazo de pago de las mismas
				por parte del banco emisor, el VENDEDOR sera responsable liso y llano por la devolucion al COMPRADOR del importe que este le abonara con oportunidad de celebrarse
				el presente contrato, mas los gastos bancarios generados.<br/>
				3)En caso de incumplimiento por parte del VENDEDOR de lo establecido en el punto 3) del presente, se devengara a favor del COMPRADOR una tasa de interes del 5% (cinco por ciento)
				mensual sobre el importe mencionado en el punto 1) del presente, la que se aplicara desde la fecha de rechazo de la especie hasta la efectiva cancelacion de la
				misma por parte del VENDEDOR.
				<br/><br/><br/><br/><br/><br/><br/><br/>
				VENDEDOR   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMPRADOR ";
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Contrato de Compra");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "", 12);
        $pdf->writeHTML($html, true, false, false, false, '');
        $pdf->Output($cheque->id . ".pdf", "I");
    }

    public function actionResumenPDF($id) {
        $convertirNumero = new n2t();
        $model = $this->loadModel($id);
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Resumen de la Operatoria");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 14);
        $pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Detalles de la Operatoria', 0, 1, 'C');
        $pdf->SetFont("times", "", 12);
        $html = '
			<table border="1" cellpadding="3">
				<tr>
				<td align="center" style="width:10%">ESP.</td><td align="center" style="width:10%">BANCO</td><td align="center" style="width:10%">NRO.</td><td align="center" style="width:12%">VTO.</td><td align="center" style="width:10%">DIAS AL VENC.</td><td align="center" style="width:20%">LIBRADOR</td><td align="center" style="width:15%">ENDOSANTE</td><td align="center" style="width:15%">IMPORTE</td>
			</tr>';
        $gastosPesificacion = 0;
        $descuento = 0;
        foreach ($model->cheques as $cheque) {
            $diasAlVencimiento=Utilities::RestarFechas(Date("d-m-Y"),Utilities::ViewDateFormat($cheque->fechaPago))+$cheque->clearing;
            $html.="<tbody><tr>
					<td>CH. PD.</td><td>" . $cheque->banco->nombre . "</td><td>" . $cheque->numeroCheque . "</td><td>" . Utilities::ViewDateFormat($cheque->fechaPago) . "</td><td>".$diasAlVencimiento."</td><td>" . $cheque->librador->denominacion . "</td><td>" . $cheque->endosante . "</td><td>" . Utilities::MoneyFormat($cheque->montoOrigen) . "</td>
					</tr>";
            $gastosPesificacion+=($cheque->pesificacion / 100) * $cheque->montoOrigen;
            $descuento+=$cheque->montoOrigen - $cheque->montoNeto - ($cheque->pesificacion / 100) * $cheque->montoOrigen;
        }
        $html.='</tbody></table>';
        $html.='<br>';
        $html.='<b>Descuento total:</b> ' . Utilities::MoneyFormat($descuento) . '<br/><br/>';
        $html.='<b>Gastos de pesificacion:</b> ' . Utilities::MoneyFormat($gastosPesificacion) . '<br/><br/>';
        $html.='<b>TOTAL:</b> ' . Utilities::MoneyFormat($model->montoNetoTotal) . ' (PESOS: ' . Utilities::num2letras($model->montoNetoTotal) . ')';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($cheque->id . ".pdf", "I");
    }

    public function actionImprimirPDF($id){

        $ejecutar = '<script type="text/javascript" language="javascript">
        window.open("'.Yii::app()->createUrl("/operacionesCheques/generatePDF", array("id"=>$id)).'");
        window.open("'.Yii::app()->createUrl("/operacionesCheques/ResumenPDF", array("id"=>$id)).'");
        </script>';

        Yii::app()->session['ejecutar'] = $ejecutar;
        $this->redirect(array('admin'));

    }


    public function actionAnularOperacion(){
        if($_GET["operacionChequeId"]){
            try{
                $model = $this->loadModel($_GET["operacionChequeId"]);
                $model->estado = OperacionesCheques::ESTADO_ANULADO;

                //Anulo todos los cheques esa operacion
                $resultado = Cheques::model()->updateAll(array('estado'=>Cheques::TYPE_ANULADO), "operacionChequeId = :operacionChequeId", array('operacionChequeId'=>$model->id));
                if(!$resultado)
                    throw new Exception("Error al anular la operacion", 1);
                if(!$model->save())
                    throw new Exception(var_dump($model->getErrors()), 1);
                Yii::app()->user->setFlash('success', "La Operacion fue anulada con exito");
            } catch (Exception $e){
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
        $this->redirect(array('admin'));
    }

}
