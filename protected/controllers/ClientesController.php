<?php

class ClientesController extends Controller {

	////// Propiedades

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
		
	////// Métodos nuevos

    public function actionGetCliente() {
        if (isset($_POST['id'])) {
            $cliente = $this->loadModel($_POST['id']);
            $cliente->saldo=$cliente->saldo;
            $cliente->saldoColocaciones=$cliente->saldoColocaciones;
            $cliente=array("cliente"=>$cliente, "saldo"=>$cliente->saldo, "saldoColocaciones" =>$cliente->saldoColocaciones);
            echo CJSON::encode($cliente);
            //echo $cliente->razonSocial . ';' . $cliente->tasaInversor . ';' . $cliente->saldo . ';' . $cliente->id;
        }
    }

    public function actionGetSaldos() {
        if (isset($_POST['id'])) {
			
            $cliente = $this->loadModel($_POST['id']);
			$cliente->productosId = $_POST['productoId'];

            if ($cliente != null) {
                $datos=array(
                    "saldo"=>!empty($cliente->saldo) ? $cliente->saldo : 0,
                    "saldoColocaciones"=>!empty($cliente->saldoColocaciones) ? $cliente->saldoColocaciones : 0,
                    "montoPermitidoDescubierto"=>!empty($cliente->montoPermitidoDescubierto) ? $cliente->montoPermitidoDescubierto : 0
                   );
                echo CJSON::encode($datos);
                //echo $cliente->saldo . ';' . $cliente->saldoColocaciones;
            }
        }
    }

    public function actionGetDataProvider() {
        $model = new Cheques;
        $dataProvider = $model->searchByFecha2($_POST['fechaIni'], $_POST['fechaFin']);
        $this->render('grid', array('model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    // data provider para el campo de autocompletado buscnado por razonSocial y tomando el clienteId
    public function actionBuscarRazonSocial() {
    	
        $q = $_GET['term'];
        if (isset($q)) {
            $criteria = new CDbCriteria;
            //si agregue a la url los tipos busca filtra en la busqueda por esos
            if (isset($_GET['tipo']))
                $criteria->compare('tipoCliente', $_GET['tipo'], "OR");

            $criteria->compare('razonSocial', $q, true);
            //$criteria->condition = ' UCASE(razonSocial) like :q';
            $criteria->order = 'razonSocial'; // correct order-by field
            $criteria->limit = 50;
            //$criteria->params = array(':q' => '%' . strtoupper(trim($q)) . '%');
            $clientes = Clientes::model()->findAll($criteria);

            if (!empty($clientes)) {
                $out = array();
                foreach ($clientes as $c) {
                    $out[] = array(
                        'label' => $c->razonSocial,
                        'value' => $c->razonSocial,
                        'id' => $c->id,
                    );
                }

                echo CJSON::encode($out);
                Yii::app()->end();
            } else {
                echo "La consulta no devolvio resultados";
            }
        }
    }

    public function actionBuscarNombreCliente() {
		
		$model = $_POST["OrdenIngreso"];
		
        $criteria = new CDbCriteria;
        $criteria->compare('razonSocial', $model["nombreCliente"], true);
        $criteria->order = 'razonSocial'; // correct order-by field
        $criteria->limit = 50;
        $clientes = Clientes::model()->findAll($criteria);
		
		echo CJSON::encode($clientes);
    }

    public function actionGetInversoresDeCheque() {
        if (isset($_POST["chequeId"])) {
            $model = new Clientes;
            $colocaciones = Colocaciones::model()->find('chequeId=:chequeId AND estado=:estado', array(':chequeId' => $_POST["chequeId"][0], ':estado' => Colocaciones::ESTADO_ACTIVA));
            if(!empty($colocaciones)) {
                $dataProvider = $model->getInversoresDeCheque($_POST["chequeId"][0]);
                $this->renderPartial('inversoresDeCheque', array('model' => $model,
                    'dataProvider' => $dataProvider,
                ));
            }
        }
    }

    public function actionRanking() {
        $ranking = $this->getRanking(true);
        $this->render('ranking', $ranking);
    }

    public function actionExportarRanking(){
        $ranking = $this->getRanking($_GET["paginacion"]);
        $columns = array(
            array(
                'name' => 'Cliente',
                'type' => 'raw',
                'value' => 'CHtml::encode($data["razonSocial"])'
            ),
            array(
                'name' => 'Efectivo',
                'type' => 'raw',
                'value' => 'Utilities::MoneyFormat($data["saldo"])'
            ),
            array(
                'name' => 'Cheques',
                'type' => 'raw',
                'value' => 'Utilities::MoneyFormat($data["saldoColocaciones"])'
            ),
            array(
                'name' => 'Total',
                'type' => 'raw',
                'value' => 'Utilities::MoneyFormat($data["total"])'
            ),
            array(
                'name' => '%',
                'type' => 'raw',
                'value' => 'Utilities::truncateFloat($data["porcentaje"],2)'
            ),
        );
        $config = array(
            'title'     => 'Ranking Clientes',
            //'subTitle'  => 'Informe Al: '.$model->fecha,
            // 'colWidths' => array(40, 90, 40, 70),
        );
        $this->exportarGrid($filename,$ranking["arrayDataProvider"],$columns,$config);
    }


    public function getRanking($paginacion){
        $model = new Clientes('search');
        $clientes = Clientes::model()->findAll();
        $sumaTotal = 0;

        $saldos = array();
        foreach ($clientes as $cliente) {
            $saldos[$cliente->id]["saldoColocaciones"]=$cliente->saldoColocaciones;
            $saldos[$cliente->id]["saldo"]=$cliente->saldo;
            $sumaTotal+=$saldos[$cliente->id]["saldoColocaciones"] + $saldos[$cliente->id]["saldo"];
        }
        $rawData = array();
        $i = 1;
        foreach ($clientes as $cliente) {
            $total = $saldos[$cliente->id]["saldoColocaciones"] + $saldos[$cliente->id]["saldo"];
            $porcentaje = $sumaTotal != 0 ? ($total / $sumaTotal) * 100 : 0;
            $rawData[] = array('id' => $i, 'razonSocial' => $cliente->razonSocial, 'saldo' => $saldos[$cliente->id]["saldo"], 'saldoColocaciones' => $saldos[$cliente->id]["saldoColocaciones"], 'total' => $total, 'porcentaje' => $porcentaje);
            $i++;
        }

        if($paginacion)
            $paginacion = array('pageSize' => 10);
        else
            $paginacion = false;    

        $arrayDataProvider = new CArrayDataProvider($rawData, array(
                    'id' => 'id',
                    'sort' => array(
                        'defaultOrder' => 'porcentaje DESC',
                        'attributes' => array(
                            'porcentaje'
                        ),
                    ),
                    'pagination' => $paginacion,
                ));
        return compact("arrayDataProvider","sumaTotal");
    }

    public function actionInformePosicion() {
        $this->layout = '//layouts/column1';
        $this->render('informePosicion', array(
            ''
        ));
    }

    public function actionGetInforme() {
        if (isset($_GET["clienteId"])) {
            $informe = $this->getInforme($_GET["clienteId"], true);
            $this->renderPartial('viewInforme', $informe);
        }
    }

    private function getInforme($clienteId, $paginacion){

        $cliente = Clientes::model()->findByPk($clienteId);
        $saldo = $cliente->saldo;
        $colocaciones = Colocaciones::model()->getColocacionesCliente($clienteId);
        $montoColocadoTotal = 0;
        $valorActualTotal = 0;
        $rawData = array();
        foreach ($colocaciones as $colocacion) {
            $cheque = $colocacion->cheque;
            foreach ($colocacion->detalleColocaciones as $detalleColocaciones) {
                if ($detalleColocaciones->clienteId == $clienteId) {
                    $montoColocadoTotal+=$detalleColocaciones->monto;
                    $capital = $colocacion->calculoValorActual($detalleColocaciones->monto, Utilities::ViewDateFormat($cheque->fechaPago), $detalleColocaciones->tasa, $colocacion->getClearing());
                    $valorActual = Colocaciones::model()->calculoValorActual($detalleColocaciones->monto, Utilities::ViewDateFormat($cheque->fechaPago), $detalleColocaciones->tasa, $colocacion->getClearing());
                    $valorActualTotal+=$valorActual;

                    $rawData[] = array(
                        'id' => $detalleColocaciones->id,
                        'numeroCheque' => $cheque->numeroCheque,
                        'banco' => $cheque->banco->nombre,
                        'librador' => $cheque->librador->denominacion,
                        'fechaInicio' => $colocacion->fecha,
                        'fechaPago' => $cheque->fechaPago,
                        'dias' => Utilities::RestarFechas3($colocacion->fecha,$cheque->fechaPago),
                        'porcentajeTenencia' => Clientes::model()->getPorcentajeTenencia($cheque->id, $clienteId),
                        'capital' => $capital,
                        'intereses' => ($detalleColocaciones->monto - $capital),
                        'valorNominal' => $detalleColocaciones->monto,
                        'valorActual' => $valorActual
                        );
                }
            }
        }

        $totalDepositos = Ctacte::model()->getTotalPorConcepto($clienteId, 9);
        $totalRetiros = Ctacte::model()->getTotalPorConcepto($clienteId, 16);

        $cliente = Clientes::model()->findByPk($clienteId);
        $interesesDevengados = $cliente->montoColocaciones - $cliente->saldoColocaciones;

        $resumen = "<b>Tasa Anual Promedio : </b> " . Colocaciones::model()->getTasaAnualPromedio($clienteId) . "%<br>";
        $resumen.="<b>Total Depositos :</b> " . Utilities::MoneyFormat($totalDepositos) . "<br>";
        $resumen.="<b>Total Retiros :</b> " . Utilities::MoneyFormat($totalRetiros) . "<br>";
        //$resumen.="<b>Intereses Devengados :</b> " . Utilities::MoneyFormat($interesesDevengados) . "<br>";

        if($paginacion)
            $paginacion = array("pageSize"=>10);
        $arrayDataProvider = new CArrayDataProvider($rawData, array(
                    'id' => 'id',
                    'pagination' => $paginacion,
                ));

        return compact("arrayDataProvider", "montoColocadoTotal", "valorActualTotal","saldo","resumen");
    
    }

    public function actionExportPDF() {
        echo '<script type="text/javascript" language="javascript">
		window.open("informePDF/' . $_GET["clienteId"] . '");
		</script>';
    }

    public function actionInformePDF() {
        //$html = $this->actionGetInforme();
        if (isset($_GET["id"])) {
           
            $informe = $this->getInforme($_GET["id"], false);
            error_reporting(E_ALL & ~E_NOTICE);
            $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor("CAPITAL ADVISORS");
            $pdf->SetTitle("Informe de Posicion");
            $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->setPageOrientation('l');
            $pdf->SetFont("times", "B", 16);
            $pdf->Write(0, Date("d/m/Y"), '', 0, 'R', true, 0, false, false, 0);
            $pdf->Cell(0, 3, 'Informe de Posicion', 0, 1, 'C');

            $html='<table border="1" cellpadding="2">';
            $html.='<tr>';
            $html.='
            <td align="center" style="width:9%">Nro. Cheque</td>
            <td align="center" style="width:9%">Banco</td>
            <td align="center" style="width:21%">Librador</td>
            <td align="center" style="width:8%">Fecha Ini.</td>
            <td align="center" style="width:8%">Fecha Vto.</td>
            <td align="center" style="width:5%">Dias</td>
            <td align="center" style="width:10%">% Tenencia</td>
            <td align="center" style="width:10%">Capital</td>
            <td align="center" style="width:10%">Valor Actual</td>
            <td align="center" style="width:10%">Valor Nominal</td>
            </tr>';

            foreach($informe["arrayDataProvider"]->getData() as $row){
                $html.="<tr>";
                $html.="<td>".$row["numeroCheque"]."</td>";
                $html.="<td>".$row["banco"]."</td>";
                $html.="<td>".ucwords(strtolower($row["librador"]))."</td>";
                $html.="<td>".Utilities::ViewDateFormat($row["fechaInicio"])."</td>";
                $html.="<td>".Utilities::ViewDateFormat($row["fechaPago"])."</td>";
                $html.='<td align="right">'.$row["dias"].'</td>';
                $html.='<td align="right">'.Utilities::truncateFloat($row["porcentajeTenencia"],2).'</td>';
                $html.='<td align="right">'.Utilities::MoneyFormat($row["capital"]).'</td>';
                $html.='<td align="right">'.Utilities::MoneyFormat($row["intereses"]).'</td>';
                $html.='<td align="right">'.Utilities::MoneyFormat($row["valorNominal"]).'</td>';
                $html.='<td align="right">'.Utilities::MoneyFormat($row["valorActual"]).'</td>';
                $html.="</tr>";
            }
            $html.="</table><br />";
            $html.=$informe["resumen"];
            //$pdf->writeHTML($estilos, true, false, true, false, '');
            $pdf->SetFont("times", "", 11);
            //echo $html;
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output("export.pdf", "I");
        }
    }

    public function actionExportarLista(){
        $model = new Clientes;
        $dataProvider = $model->search();
        $dataProvider->setPagination(false);
        $filename = "Listado Clientes";
        $columns =array(
            'id',
            'razonSocial',
            'fijo',
            'celular',
            'direccion',
            'email',
            'documento',
            'tasaInversor',
            array(
                'name'=>'tipoCliente',
                'header'=>'Tipo Cliente',
                'value'=>'$data->getTypeDescription()',
            ),
            array(
                'name'=>'operadorId',
                'header'=>'Operador',
                'value'=>'$data->operador->apynom',
            )
        );
        $config = array(
            'title'     => 'Listado Clientes',
        );
        $this->exportarGrid($filename,$dataProvider,$columns,$config);
    }


	protected function dibujarCeldaProductosLista($data) 
    {
    	$model = $this->loadModel($data->id);
		
		$contenido = '';
		
		foreach ($model->productos as $producto)
			$contenido = $contenido.CHtml::encode($producto['nombre'].' - '.$producto['descripcion']).'<br>';
		
		return $contenido;
    }
	 	
	protected function dibujarCeldaProductosGrilla($data) 
    {
    	$model = $this->loadModel($data->id);
		
		$contenido = '';
		
		foreach ($model->productos as $producto)
			$contenido = $contenido.'<b>'.CHtml::encode($producto['nombre']).'</b><br>'.CHtml::encode($producto['descripcion']).'<br>';
		
		return $contenido;
    } 	

	public function actionValidarProducto()
	{
		$productoId = $_POST['productoId'];
		$clienteId = $_POST['clienteId'];
		
		$productoCtaCte = Productoctacte::model()->find("pkModeloRelacionado=:clienteId AND productoId=:productoId AND nombreModelo=:nombreModelo", array(":clienteId" => $clienteId, ":productoId" => $productoId, ":nombreModelo" => "Clientes"));
		
		if (!$productoCtaCte) {
			echo 'jQuery(\'#botonEnviar\').removeAttr(\'disabled\');';
			return true;
		}
		
		$ctacte = Ctacte::model()->find("productoCtaCteId=:productoCtaCteId", array(":productoCtaCteId" => $productoCtaCte->id));
		
		if (!$ctacte) {
			echo 'jQuery(\'#botonEnviar\').removeAttr(\'disabled\');';
			return true;
		}
		
		$contenido = 'producto.checked = true; jQuery(\'#botonEnviar\').removeAttr(\'disabled\');';
		
		echo $contenido;
	} 

	////// Métodos generados

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
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'expression' => 'Yii::app()->user->checkAccess("usuario")',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'updatefield', 'delete', 'getCliente', 'getDataProvider', 'buscarRazonSocial', 'buscarNombreCliente', 'getSaldos', 'getInversoresDeCheque', 'ranking', 'informePosicion', 'getInforme', 'exportPDF', 'informePDF', 'exportarRanking', 'exportarLista', 'validarProducto'),
                'users' => array('@'),
                //'expression' => 'Yii::app()->user->checkAccess("administrador")',
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
            'model' => $this->loadModel($id), 'apoderados' => new Apoderados(), 'beneficiarios' => new Beneficiarios(),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Clientes;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Clientes'])) {
            $model->attributes = $_POST['Clientes'];
			
			$model->productos = array();
			$model->productosCliente = array();
			
			$productos = $_POST['Clientes']['productosId'];
			
			$transaccion = Yii::app()->db->beginTransaction();
			
			if($model->save()) {
				
				$error = false;
				
				if ($productos)
					foreach ($productos as $idproducto) {
						$relacion = new Productoctacte();
						$relacion->nombreModelo = 'Clientes';
						$relacion->pkModeloRelacionado = $model->id;
						$relacion->productoId = (int) $idproducto;
				        $relacion->userStamp = Yii::app()->user->model->username;
				        $relacion->timeStamp = Date("Y-m-d h:m:s");
						if (!$relacion->save()) {
							$error = true;
							break;
						}
					}
				
				if (!$error) {
					$transaccion->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
				else
					$transaccion->rollBack();
			}			
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

        if (isset($_POST['Clientes'])) {
        	
			$transaccion = Yii::app()->db->beginTransaction();
			$error = false;
			
            $model->attributes = $_POST['Clientes'];
			
			$productos = $_POST['Clientes']['productosId'];
			$productosCliente = $model->productosCliente;
			
			if (!$productos) {
				$model->productos = array();
				$model->productosCliente = array();
			}
			else {
				if ($productosCliente) {
					$indice = 0;
					foreach ($productosCliente as $producto) {
						if (!in_array($producto->productoId, $productos))
							unset($productosCliente[$indice]);
						$indice++;
					}
				}
				
				foreach ($productos as $idproducto) {
					
					$relacion = new Productoctacte();
					
					$resultado = $relacion->find("productoId = :productoId AND pkModeloRelacionado = :pkModeloRelacionado AND nombreModelo = :nombreModelo", array(":productoId" => $idproducto, ":pkModeloRelacionado" => $model->id, ":nombreModelo" => "Clientes"));
					
					if (!$resultado) {
						
						$relacion->nombreModelo = 'Clientes';
						$relacion->pkModeloRelacionado = $model->id;
						$relacion->productoId = (int) $idproducto;
				        $relacion->userStamp = Yii::app()->user->model->username;
				        $relacion->timeStamp = Date("Y-m-d h:m:s");
						if (!$relacion->save()) {
							$error = true;
							break;
						}
						
						array_push($productosCliente, $relacion);
					}
				}
				
				if (!$error) {
					
					$model->productosCliente = $productosCliente;
					
					if ($model->save()) {
						$model = $this->loadModel($id);
						
						$transaccion->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
					else
						$transaccion->rollBack();
				}
				else
					$transaccion->rollBack();
			}
			
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
            
            $model = $this->loadModel($id);
            
			$ctacte = new Ctacte();
			
			if ($model->productosCliente) {
				foreach ($model->productosCliente as $productoCliente) {
					$resultado = $ctacte->find("productoCtaCteId = :productoCtaCteId", array(":productoCtaCteId" => $productoCliente->id));
					
					if ($resultado)
						throw new CHttpException('Este cliente tiene movimientos activos. No se puede eliminar.');
				}	
			}
			
			$model->productosCliente = array();
			
			if ($model->save(false))
				$model->delete();
			else {
				print_r($model->getErrors());
				exit;
			}

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
        $dataProvider = new CActiveDataProvider('Clientes');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Clientes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Clientes']))
            $model->attributes = $_GET['Clientes'];

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
        $model = Clientes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'clientes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

