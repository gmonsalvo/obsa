<?php

class OrdenIngresoController extends Controller
{
	////// Propiedades
	
	////// Métodos nuevos
	
	//esta funcion actualiza la orden de pago y acrtedita los fondos en la cuenta corriente del cliente
	//o tambien anula la orden dependiendo de la accion seleccionada por el usuario
	public function actionUpdateOrden() {
      if (isset($_POST["boton"]) && isset($_POST["ordenIngresoId"])) {
      	
        	$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
		
            $id = $_POST["ordenIngresoId"];
            $ordenIngreso = $this->loadModel($id);
            try {
                if ($_POST["boton"] == "Acreditar Fondos") {
                    if($ordenIngreso->tipo == OrdenIngreso::TIPO_DEPOSITO) {
						$productoCliente = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", array(":clienteId" => $ordenIngreso->clienteId, ":productoId" => $ordenIngreso->productoId, ":nombreModelo" => "Clientes"));
						
						if (!$productoCliente) {
							$transaction->rollback();
							return false;
						}
						
	                    //metemos un credito en cuenta corriente para este cliente
						$sql = "INSERT INTO ctacte
	                            (tipoMov, productoCtaCteId, conceptoId, descripcion, monto, fecha, origen, identificadorOrigen, userStamp, timeStamp, sucursalId, saldoAcumulado)
	                            VALUES (:tipoMov, :productoCtaCteId, :conceptoId, :descripcion, :monto, :fecha, :origen, :identificadorOrigen, :userStamp, :timeStamp, :sucursalId, :saldoAcumulado)";

	                    $tipoMov = Ctacte::TYPE_CREDITO; //credito
	                    $conceptoId = 9; //Ingreso de fondos
	                    $descripcion = "Deposito Num.".$id;
	                    $fecha = Date("Y-m-d");
	                    $operacionRelacionada = "Acreditacion de Fondos";
	                    $origen="OrdenIngreso";
	                    $identificadorOrigen=$ordenIngreso->id;

	                    $ctacte = new Ctacte();
	                    $ctacte->productoCtaCteId=$productoCliente->id;
	                    $saldoAcumuladoActual = $ctacte->getSaldoAcumuladoActual();
	                    $saldoAcumulado=$saldoAcumuladoActual+$ordenIngreso->monto;
	                    $userStamp = Yii::app()->user->model->username;
	                    $timeStamp = date("Y-m-d h:m:s");
	                    $sucursalId = Yii::app()->user->model->sucursalId;
	                    $command = $connection->createCommand($sql);
						$command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
	                    $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
	                    $command->bindValue(":productoCtaCteId", $productoCliente->id, PDO::PARAM_STR);
	                    $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
	                    $command->bindValue(":monto", $ordenIngreso->monto, PDO::PARAM_STR);
	                    $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
	                    $command->bindValue(":origen", $origen, PDO::PARAM_STR);
	                    $command->bindValue(":identificadorOrigen", $identificadorOrigen, PDO::PARAM_STR);
	                    $command->bindValue(":saldoAcumulado", $saldoAcumulado, PDO::PARAM_STR);
	                    $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
	                    $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
	                    $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
	                    $command->execute();
						
						//tenemos que meter un movimiento en la caja de operaciones sea cual sea tipo de ordeningreso
						$flujoFondos=new FlujoFondos;
						$flujoFondos->cuentaId='6'; // cajade oepracion
						$flujoFondos->conceptoId='9'; // concepto para ingreso de fondos
						$flujoFondos->descripcion='Ingreso de Fondos Orden Num'.$id;
						$flujoFondos->tipoFlujoFondos=FlujoFondos::TYPE_CREDITO;
						$flujoFondos->monto=$ordenIngreso->monto;
						$flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
						$flujoFondos->fecha=Date("d/m/Y");
						$flujoFondos->origen='ordenIngreso';
						$flujoFondos->identificadorOrigen=$id;
						$flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
						$flujoFondos->userStamp = Yii::app()->user->model->username;
						$flujoFondos->timeStamp = Date("d/m/Y h:m:s");
						if (!$flujoFondos->save()) {
							$transaction->rollback();
							return false;							
						}

						$ordenIngreso->estado = OrdenIngreso::ESTADO_PAGADA;
						if (!$ordenIngreso->save()){
							$transaction->rollback();
							return false;
						}
						$transaction->commit();
                	} else {
                		if($ordenIngreso->tipo == OrdenIngreso::TIPO_PESIFICACION_INDIVIDUAL){
							//cambio el estado del cheque a acreditado
							$chequeId = $ordenIngreso->identificadorOrigen;
							$cheque = Cheques::model()->findByPk($chequeId);
							$tasaDescuento = (1-($ordenIngreso->monto/$cheque->montoOrigen))*100;
							if(Pesificaciones::model()->AcreditarCheque($chequeId, $tasaDescuento)){
								$ordenIngreso->estado = OrdenIngreso::ESTADO_PAGADA;
                    			if (!$ordenIngreso->save()) {
									$transaction->rollback();
									return false;
                    			}
								$transaction->commit();
							} else {
								$this->redirect(array('admin'));
								$transaction->commit();
							}
							// Cheques::model()->updateByPk($ordenIngreso->identificadorOrigen, array("estado"=>Cheques::TYPE_ACREDITADO));
                		}
                	}
	                $this->actionFinal($id);
                } else {
                    if ($_POST["boton"] == "Anular") {
                        $ordenIngreso->estado = OrdenIngreso::ESTADO_ANULADA;
                        if (!$ordenIngreso->save()) {
							$transaction->rollback();
							return false;
                        }
                        $ordenIngreso->unsetAttributes();
                        Yii::app()->user->setFlash('success','Orden de Ingreso Anulada');
						$this->render('/ordenIngreso/admin',array('model'=>$ordenIngreso));
						$transaction->commit();
                    }
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                print_r($e);
            }
        }
    }

	//funcion para imprimir un pdf con la orden de ingreso
	 public function actionReciboPDF($id) {
        $model = $this->loadModel($id);


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
        $pdf->Cell(0, 3, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . $model->fecha . '
                       <br/>
                       <br/>
                       Cliente: ' . $model->cliente->razonSocial . '
                       <br/>
                       <br/>
                       Orden de Ingreso Nro: ' . $model->id . '
                       <br/>
                       <br/>
                       Monto Total: ' . Utilities::MoneyFormat($model->monto) . '
                       <br/>
                       <br/>
                       Monto Efectivo: ' . Utilities::MoneyFormat($model->monto) . '
                       <br/>
                       <br/>
                       <br/>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }

	public function actionFinal($id)
	{
		$model = $this->loadModel($id);
		$ejecutar = '<script type="text/javascript" language="javascript">
		window.open("reciboPDF/'.$id.'");
		</script>';
		Yii::app()->session['ejecutar'] = $ejecutar;
        Yii::app()->user->setFlash('success','Orden de Ingreso Procesada con exito');
		$this->redirect(array('admin'));

	}

	public function actionLevantarCheque($id){
		if($id){
			$model = new OrdenIngreso;
			$cheque = Cheques::model()->findByPk($id);
			if($cheque===null)
				throw new CHttpException(404,'The requested page does not exist.');
			if(isset($_POST["OrdenIngreso"])){
				$model->attributes=$_POST['OrdenIngreso'];
				##calculo de nuevo el monto
				$model->monto = $_POST["montoOrigen"] - ($_POST["porcentajeReconocimiento"] * $_POST["montoOrigen"] / 100);
				$model->estado = OrdenIngreso::ESTADO_PENDIENTE;
				$model->descripcion = "Orden Ingreso por cheque levandato num ". $model->identificadorOrigen;
				$model->clienteId = $cheque->operacionCheque->clienteId;
				$model->productoId = 1;
				if($model->save()){
				    Yii::app()->user->setFlash('success','Ingreso de Fondos realizado con exito');
					$model->unsetAttributes();
					$this->redirect(array('cheques/adminCheques'));
				}

			}
			$this->render("levantarCheque",array("cheque"=>$cheque,"model"=>$model));
		}
	}

	public function actionPrueba() {
		$this->render("prueba",array("post"=>$_POST));
	}
	
	public function actionCargarProductosCliente() {
		
		$cliente = Clientes::model()->findByPk($_POST['OrdenIngreso']['clienteId']); //buscarProductosCliente($_POST['OrdenIngreso']['clienteId']);
		
		foreach($cliente->productos as $producto)
			echo CHtml::tag('option', array('value'=>$producto->id),CHtml::encode($producto->nombre),true);
	}
	
	////// Métodos generados
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','updateOrden','reciboPDF','levantarCheque', "prueba", "cargarProductosCliente"),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OrdenIngreso;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrdenIngreso']))
		{
			$model->attributes=$_POST['OrdenIngreso'];
			if($model->save())
			    Yii::app()->user->setFlash('success','Ingreso de Fondos realizado con exito');
				$model->unsetAttributes();
				$this->redirect('create',array(
					'model'=>$model,
					));

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrdenIngreso']))
		{
			$model->attributes=$_POST['OrdenIngreso'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('OrdenIngreso');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrdenIngreso('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenIngreso']))
			$model->attributes=$_GET['OrdenIngreso'];

		if(isset(Yii::app()->session["ejecutar"])){
            echo Yii::app()->session["ejecutar"];
            unset(Yii::app()->session['ejecutar']);
        }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=OrdenIngreso::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-ingreso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
