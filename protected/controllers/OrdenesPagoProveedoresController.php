<?php

class OrdenesPagoProveedoresController extends Controller {

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
                'actions' => array('create', 'update', 'reciboPDF', 'admin', 'updateOrden', 'getDetalles'),
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
		window.open("reciboPDF/' . $id . '");
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
        $model = new OrdenesPagoProveedores;
        $formaPagoOrden = new FormaPagoOrdenProveedores();
        $cheques = new Cheques();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenesPagoProveedores'])) {
            $model->attributes = $_POST['OrdenesPagoProveedores'];
            //$model->monto = $_POST["montoEfectivo"] + $_POST["montoCheques"];
            $model->estado = OrdenesPagoProveedores::ESTADO_PENDIENTE;
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $idOrdenesPagoProveedores = $model->id;
                    $montoEfectivo = $model->monto;

                    $sql = "INSERT INTO formaPagoOrdenProveedores (ordenPagoId, monto, tipoFormaPago, formaPagoId) values (:ordenPagoId, :monto, :tipoFormaPago, :formaPagoId)";
                    $command = $connection->createCommand($sql);
                    $command->bindValue(":ordenPagoId", $idOrdenesPagoProveedores, PDO::PARAM_STR);
                    $command->bindValue(":monto", $montoEfectivo, PDO::PARAM_STR);
                    $command->bindValue(":tipoFormaPago", FormaPagoOrden::TIPO_EFECTIVO, PDO::PARAM_STR);
                    $command->bindValue(":formaPagoId", 0, PDO::PARAM_STR);
                    $command->execute();

//                    $flujoFondos = new FlujoFondos;
//                    $flujoFondos->cuentaId = '8'; // corresponde a la caja de operaciones
//                    $flujoFondos->conceptoId = '11'; // pago prov
//                    $flujoFondos->descripcion = "Proveedor: ".$model->proveedor->denominacion.". Detalles: ".$model->descripcion; // bueno fijate ahi como podes armar una descripcion que tenga la mayor cantidad de info posible.
//                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
//                    $flujoFondos->monto = $model->monto;
//                    $flujoFondos->fecha = Date("d/m/Y");
//                    $flujoFondos->origen = 'ordenesPagoProveedores';
//                    $flujoFondos->identificadorOrigen = $model->id;
//                    $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
//                    $flujoFondos->userStamp = Yii::app()->user->model->username;
//                    $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
//                    $flujoFondos->save();


                    //$valor=$chequesSeleccionados[0].' '.$chequesSeleccionados[1];
                    $transaction->commit();
                    $model->unsetAttributes();  // clear any default values
                    Yii::app()->user->setFlash('success', 'Orden de Pago realizada con exito');
                }else{
                    Yii::app()->user->setFlash('error', 'Error al crear la orden de Pago');
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                 Yii::app()->user->setFlash('error', 'Error al crear la orden de Pago');

            }
        }

        $this->render('create', array(
            'model' => $model, 'cheques' => $cheques
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

        if (isset($_POST['OrdenesPagoProveedores'])) {
            $model->attributes = $_POST['OrdenesPagoProveedores'];
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
        $dataProvider = new CActiveDataProvider('OrdenesPagoProveedores');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrdenesPagoProveedores('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrdenesPagoProveedores']))
            $model->attributes = $_GET['OrdenesPagoProveedores'];

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
        $model = OrdenesPagoProveedores::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ordenes-pago-proveedores-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
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

                    $ordenesPago->estado = OrdenesPagoProveedores::ESTADO_PAGADA;
                    $ordenesPago->save();

                                        $sql = "INSERT INTO ctacteProveedores
                                            (tipoMov, conceptoId, proveedorId, descripcion, monto, fecha, userStamp, timeStamp, sucursalId)
                                            VALUES (:tipoMov, :conceptoId, :proveedorId, :descripcion, :monto, :fecha, :userStamp, :timeStamp, :sucursalId)";


                    $command = $connection->createCommand($sql);
                    $tipoMov = CtacteProveedores::TYPE_CREDITO;
                    $conceptoId = 13;
                    $descripcion = $ordenesPago->descripcion;
                    $fecha = Date("Y-m-d");

                    $userStamp = Yii::app()->user->model->username;
                    $timeStamp = Date("Y-m-d h:m:s");
                    $sucursalId = Yii::app()->user->model->sucursalId;

                    $proveedorId = $ordenesPago->proveedorId;

                    $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
                    $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                    $command->bindValue(":proveedorId", $proveedorId, PDO::PARAM_STR);
                    $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);

                    $command->bindValue(":monto", $ordenesPago->monto, PDO::PARAM_STR);
                    $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);

                    $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                    $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                    $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                    $command->execute();

                    //movimiento en Flujo fondos

                    $flujoFondos = new FlujoFondos;
                    $flujoFondos->cuentaId = '8'; // corresponde a la caja de operaciones
                    $flujoFondos->conceptoId = '11'; // pago prov
                    $flujoFondos->descripcion = "Proveedor: ".$ordenesPago->proveedor->denominacion.". Detalles: ".$ordenesPago->descripcion;
                    $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_DEBITO;
                    $flujoFondos->monto = $ordenesPago->monto;
                    $flujoFondos->saldoAcumulado = $flujoFondos->getSaldoAcumuladoActual() - $flujoFondos->monto;
                    $flujoFondos->fecha = Date("d/m/Y");
                    $flujoFondos->origen = 'OrdenesPagoProveedores';
                    $flujoFondos->identificadorOrigen = $ordenesPago->id;
                    $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
                    $flujoFondos->userStamp = Yii::app()->user->model->username;
                    $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
                    $flujoFondos->save();

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Orden de Pago realizada con exito');
                } else {
                    if ($_POST["boton"] == "Anular") {
                        $ordenesPago->estado = OrdenesPago::ESTADO_ANULADA;
                        $ordenesPago->save();

//                        $sql = "INSERT INTO ctacteProveedores
//                                            (tipoMov, conceptoId, proveedorId, descripcion, monto, fecha, userStamp, timeStamp, sucursalId)
//                                            VALUES (:tipoMov, :conceptoId, :proveedorId, :descripcion, :monto, :fecha, :userStamp, :timeStamp, :sucursalId)";
//
//
//                        $command = $connection->createCommand($sql);
//                        $tipoMov = CtacteProveedores::TYPE_CREDITO;
//                        $conceptoId = 13;
//                        $descripcion = "Anulacion de orden de pago a proveedor";
//                        $fecha = Date("Y-m-d");
//
//                        $userStamp = Yii::app()->user->model->username;
//                        $timeStamp = Date("Y-m-d h:m:s");
//                        $sucursalId = Yii::app()->user->model->sucursalId;
//
//                        $proveedorId = $ordenesPago->proveedorId;
////
//                        $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
//                        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
//                        $command->bindValue(":proveedorId", $proveedorId, PDO::PARAM_STR);
//                        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
//
//                        $command->bindValue(":monto", $ordenesPago->monto, PDO::PARAM_STR);
//                        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
//
//                        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
//                        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
//                        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
//                        $command->execute();

//                        $flujoFondos = new FlujoFondos;
//                        $flujoFondos->cuentaId = '8'; // corresponde a la caja de operaciones
//                        $flujoFondos->conceptoId = '11'; // pago prov
//                        $flujoFondos->descripcion = "Anulacion orden pago a proveedor"; // bueno fijate ahi como podes armar una descripcion que tenga la mayor cantidad de info posible.
//                        $flujoFondos->tipoFlujoFondos = FlujoFondos::TYPE_CREDITO;
//                        $flujoFondos->monto = $ordenesPago->monto;
//                        $flujoFondos->fecha = Date("d/m/Y");
//                        $flujoFondos->origen = 'ordenesPagoProveedores';
//                        $flujoFondos->identificadorOrigen = $ordenesPago->id;
//                        $flujoFondos->sucursalId = Yii::app()->user->model->sucursalId;
//                        $flujoFondos->userStamp = Yii::app()->user->model->username;
//                        $flujoFondos->timeStamp = Date("Y-m-d h:m:s");
//                        $flujoFondos->save();

                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Orden de Pago realizada con exito');
                    }
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Error en la operacion');
            }
        }
        $this->actionAdmin();
    }

    public function actionGetDetalles() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $ordenesPago = OrdenesPagoProveedores::model()->findByPk($id);
            $render = $this->renderPartial('/ordenesPagoProveedores/detalleOrdenesPago', array('ordenesPago' => $ordenesPago), true);
            echo $render;
        }
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
        $pdf->Cell(0, 3, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . Utilities::ViewDateFormat($model->fecha) . '
                       <br/>
                       <br/>
                       Proveedor: ' . $model->proveedor->denominacion . '
                       <br/>
                       <br/>
                       Orden de Pago Nro: ' . $model->id . '
                       <br/>
                       <br/>
                       Monto Total Efectivo: ' . Utilities::MoneyFormat($model->monto) . '
                       <br/>
                       <br/>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }

}
