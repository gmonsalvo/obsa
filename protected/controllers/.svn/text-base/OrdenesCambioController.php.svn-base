<?php

class OrdenesCambioController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'getDetalles', 'updateOrden', 'reciboPDF','final'),
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
        $model = new OrdenesCambio;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenesCambio'])) {
            $model->attributes = $_POST['OrdenesCambio'];
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

        if (isset($_POST['OrdenesCambio'])) {
            $model->attributes = $_POST['OrdenesCambio'];
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
        $dataProvider = new CActiveDataProvider('OrdenesCambio');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrdenesCambio('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrdenesCambio']))
            $model->attributes = $_GET['OrdenesCambio'];
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
        $model = OrdenesCambio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ordenes-cambio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetDetalles() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $ordenesCambio = OrdenesCambio::model()->findByPk($id);
            $render = $this->renderPartial('/operacionesCambio/detalleOperaciones', array('ordenesCambio' => $ordenesCambio), true);
            echo $render;
        }
    }

    public function actionUpdateOrden() {
        if (isset($_POST["boton"]) && isset($_POST["ordenCambioId"])) {
            $id = $_POST["ordenCambioId"];
            $ordenesCambio = $this->loadModel($id);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($_POST["boton"] == "Pagar") {
                    $ordenesCambio->estado = OrdenesCambio::ESTADO_PAGADA;
                    if ($ordenesCambio->save()) {
                        if ($ordenesCambio->operacionCambio->moneda->denominacion == "Dolar") {
                            $flujoFondos = new FlujoFondos;
                            $flujoFondos->cuentaId = '9'; // corresponde a la caja de dolares
                            $flujoFondos->monto = $ordenesCambio->operacionCambio->monto;
                            if ($ordenesCambio->operacionCambio->tipoOperacion == OperacionesCambio::TYPE_COMPRA) {
                                $flujoFondos->conceptoId = "20"; // concepto para Compra dolares
                                $flujoFondos->descripcion = 'Compra de dolares';
                                $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
                                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
                            } else {
                                $flujoFondos->conceptoId = "21"; // concepto para Compra dolares
                                $flujoFondos->descripcion = 'Venta de dolares';
                                $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                            }

                            $flujoFondos->fecha = Date("d/m/Y");
                            $flujoFondos->origen = 'OrdenesCambio';
                            $flujoFondos->identificadorOrigen = $ordenesCambio->id;
                            $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                            $flujoFondos->userStamp = Yii::app()->user->model->username;
                            $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                            $flujoFondos->save();

                            $flujoFondos = new FlujoFondos;
                            $flujoFondos->cuentaId = '6'; // corresponde a la caja de operaciones
                            if ($ordenesCambio->operacionCambio->tipoOperacion == OperacionesCambio::TYPE_COMPRA) {
                                $flujoFondos->conceptoId = "21"; // concepto para Compra dolares
                                $flujoFondos->descripcion = 'Compra de dolares';
                                $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                                $flujoFondos->monto = ($ordenesCambio->operacionCambio->monto) * ($ordenesCambio->operacionCambio->tasaCambio);
                                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                            } else {
                                $flujoFondos->conceptoId = "20"; // concepto para Venta dolares
                                $flujoFondos->descripcion = 'Venta de dolares';
                                $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
                                $flujoFondos->monto = ($ordenesCambio->operacionCambio->monto) * ($ordenesCambio->operacionCambio->tasaCambio);
                                $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
                            }

                            $flujoFondos->fecha = Date("d/m/Y");
                            $flujoFondos->origen = 'OrdenesCambio';
                            $flujoFondos->identificadorOrigen = $ordenesCambio->id;
                            $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                            $flujoFondos->userStamp = Yii::app()->user->model->username;
                            $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                            $flujoFondos->save();
                        } else {
                            if ($ordenesCambio->operacionCambio->moneda->denominacion == "Euro") {
                                $flujoFondos = new FlujoFondos;
                                $flujoFondos->cuentaId = '10'; // corresponde a la caja de euros
                                $flujoFondos->monto = $ordenesCambio->operacionCambio->monto;
                                if ($ordenesCambio->operacionCambio->tipoOperacion == OperacionesCambio::TYPE_COMPRA) {
                                    $flujoFondos->conceptoId = "20"; // concepto para Compra dolares
                                    $flujoFondos->descripcion = 'Compra de euros';
                                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
                                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
                                } else {
                                    $flujoFondos->conceptoId = "21"; // concepto para Venta euros
                                    $flujoFondos->descripcion = 'Venta de euros';
                                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                                }

                                $flujoFondos->fecha = Date("d/m/Y");
                                $flujoFondos->origen = 'OrdenesCambio';
                                $flujoFondos->identificadorOrigen = $ordenesCambio->id;
                                $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                                $flujoFondos->userStamp = Yii::app()->user->model->username;
                                $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                                $flujoFondos->save();

                                $flujoFondos = new FlujoFondos;
                                $flujoFondos->cuentaId = '6'; // corresponde a la caja de operaciones
                                if ($ordenesCambio->operacionCambio->tipoOperacion == OperacionesCambio::TYPE_COMPRA) {
                                    $flujoFondos->conceptoId = "21"; // concepto para Compra euros
                                    $flujoFondos->descripcion = 'Compra de euros';
                                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                                    $flujoFondos->monto = ($ordenesCambio->operacionCambio->monto) * ($ordenesCambio->operacionCambio->tasaCambio);
                                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                                } else {
                                    $flujoFondos->conceptoId = "20"; // concepto para Venta euros
                                    $flujoFondos->descripcion = 'Venta de euros';
                                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
                                    $flujoFondos->monto = ($ordenesCambio->operacionCambio->monto) * ($ordenesCambio->operacionCambio->tasaCambio);
                                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() + $flujoFondos->monto;
                                }

                                $flujoFondos->fecha = Date("d/m/Y");
                                $flujoFondos->origen = 'OrdenesCambio';
                                $flujoFondos->identificadorOrigen = $ordenesCambio->id;
                                $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                                $flujoFondos->userStamp = Yii::app()->user->model->username;
                                $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                                $flujoFondos->save();
                            }
                        }
                        $transaction->commit();
                        $this->actionFinal($id);
                    } else {
                        $transaction->rollBack();
                        Yii::app()->user->setFlash('error', 'Hubo un error en la transaccion');
                        $this->actionAdmin();
                    }
                } else {
                    if ($_POST["boton"] == "Anular") {
                        $ordenesCambio->estado = OrdenesCambio::ESTADO_ANULADA;
                        $ordenesCambio->save();
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'La orden fue anulada con exito');
                        $this->actionAdmin();
                    }
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Hubo un error en la transaccion');
                $this->actionAdmin();
            }
        } else {
            $this->actionAdmin();
        }
    }

    public function actionFinal($id) {
        $model = $this->loadModel($id);
        $ejecutar = '<script type="text/javascript" language="javascript">
		window.open("'.Yii::app()->createUrl("/ordenesCambio/reciboPDF", array("id"=>$id)).'");
		</script>';
        Yii::app()->session['ejecutar'] = $ejecutar;
        Yii::app()->user->setFlash('success', 'Orden de Cambio Procesada con exito');
        $model->unsetAttributes();
        $this->redirect(array('admin'));
    }

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
        //$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Recibo orden de cambio', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . Utilities::ViewDateFormat($model->fecha) . '
                       <br/>
                       <br/>
                       Cliente: ' . $model->operacionCambio->cliente->razonSocial . '
                       <br/>
                       <br/>
                       Orden de Cambio Nro: ' . $model->id . '
                       <br/>
                       <br/>';
        if ($model->operacionCambio->tipoOperacion == OperacionesCambio::TYPE_COMPRA) {
            $capital = "Recibido: " . $model->operacionCambio->moneda->denominacion . " " . $model->operacionCambio->monto;
            $cliente = "Pago: " . Utilities::MoneyFormat($model->operacionCambio->monto * $model->operacionCambio->tasaCambio);
            $tasa = "Cotizacion: " . $model->operacionCambio->tasaCambio;
        } else {
            $capital = "Capital recibe: " . Utilities::MoneyFormat($model->operacionCambio->monto * $model->operacionCambio->tasaCambio);
            $cliente = "Cliente recibe: " . $model->operacionCambio->moneda->denominacion . " " . $model->operacionCambio->monto;
            $tasa = "A una tasa de cambio: " . $model->operacionCambio->tasaCambio;
        }
        $html.=$capital . "<br>";
        $html.=$cliente . "<br>";
        $html.=$tasa . "<br>";
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }

}
