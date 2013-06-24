<?php

class ColocacionesController extends Controller {

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
                'actions' => array('create', 'update', 'delete', 'asignarColocaciones', 'recolocacion', 'editarColocacion', 'recolocar', 'realizarRecolocacion', 'calculoValorActual', 'informePosicion'),
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
        $model = new Colocaciones;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Colocaciones'])) {
            $model->attributes = $_POST['Colocaciones'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $model->estado = Colocaciones::ESTADO_ACTIVA;
            $flag = true;
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $colocacionId = $model->id;
                    $cheques = Cheques::model()->findByPk($model->chequeId);
                    $cheques->estado = Cheques::TYPE_EN_CARTERA_COLOCADO;
                    $cheques->save();
                    $listaDetalleColocaciones = explode(',', $_POST['detallesColocaciones']);
                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 6) {
                        $detalleColocacion = new DetalleColocaciones();
                        $detalleColocacion->colocacionId = $colocacionId;
                        $detalleColocacion->clienteId = $listaDetalleColocaciones[$i];
                        $detalleColocacion->monto = $listaDetalleColocaciones[$i + 2];
                        $detalleColocacion->tasa = $listaDetalleColocaciones[$i + 4];
                        if (!$detalleColocacion->save()) {
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error', var_dump($detalleColocacion->getErrors()));
                            $this->render('create', array(
                                'model' => $model, 'cheques' => $cheques, 'clientes' => new Clientes)
                            );
                        }
                    }
                    $conceptoId = 10; //
                    $productoId = 1; //compra de cheques
                    $fecha = date("d/m/Y");
                    $origen = "Colocaciones";
                    $identificadorOrigen = $model->id;
                    $descripcion = "Inversion Nro ".$model->chequeId;

                    //$cheque = Cheques::model()->findByPk($model->chequeId);
                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 6) {
                        $ctacteCliente = new CtacteClientes();
                        $ctacteCliente->tipoMov = CtacteClientes::TYPE_DEBITO;
                        $ctacteCliente->conceptoId = 10;
                        $ctacteCliente->clienteId = $listaDetalleColocaciones[$i];
                        $ctacteCliente->productoId = $productoId;
                        $ctacteCliente->descripcion = $descripcion;
                        $valorActual = $model->calculoValorActual($listaDetalleColocaciones[$i + 2], Utilities::ViewDateFormat($cheques->fechaPago), $listaDetalleColocaciones[$i + 4], $_POST["clearing"]);

                        $ctacteCliente->monto = $valorActual;
                        $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()-$ctacteCliente->monto;
                        $ctacteCliente->fecha = $fecha;
                        $ctacteCliente->origen = $origen;
                        $ctacteCliente->identificadorOrigen = $identificadorOrigen;
                        if (!$ctacteCliente->save()) {
                            $transaction->rollBack();
                            Yii::app()->user->setFlash('error', var_dump($ctacteCliente->getErrors()));
                            $this->render('create', array(
                                'model' => $model, 'cheques' => $cheques, 'clientes' => new Clientes)
                            );
                        }
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'La colocacion fue realizada con exito');
                    $this->redirect(array("create"));
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $cheques = new Cheques('search');
        $cheques->unsetAttributes();  // clear any default values
        if (isset($_GET['Cheques'])) {
            $cheques->attributes = $_GET['Cheques'];
        }

        $model->unsetAttributes();
        $clientes=new Clientes("search");
        if (isset($_GET['Clientes'])) {
            $clientes->attributes = $_GET['Clientes'];
        }
        $this->render('create', array(
            'model' => $model, 'cheques' => $cheques, 'clientes' => $clientes)
        );
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

        if (isset($_POST['Colocaciones'])) {
            $model->attributes = $_POST['Colocaciones'];
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
        $dataProvider = new CActiveDataProvider('Colocaciones');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Colocaciones('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Colocaciones']))
            $model->attributes = $_GET['Colocaciones'];

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
        $model = Colocaciones::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'colocaciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAsignarColocaciones() {
        $this->render('create', array('model' => new Colocaciones, 'cheques' => new Cheques, 'clientes' => new Clientes));
    }

    public function actionRecolocacion() {
        $model = new Colocaciones;
        $clientes = new Clientes('search');
        $clientes->unsetAttributes();  // clear any default values
        if (isset($_GET['Clientes']))
            $clientes->attributes = $_GET['Clientes'];
        $this->render('createRecolocacion', array(
            'model' => $model, 'cheques' => new Cheques, 'clientes' => $clientes)
        );
    }

    public function actionEditarColocacion() {
        if (isset($_POST['idCheque']) || isset($_GET['idCheque'])) {

            //de aqui veo si el cheque vino de un get o un post
            $idCheque = isset($_POST['idCheque']) ? $_POST['idCheque'] : $_GET['idCheque'];

            $model = Colocaciones::model()->find('chequeId=:chequeId && estado=:estado', array('chequeId' => $idCheque, 'estado' => Colocaciones::ESTADO_ACTIVA));

            $cheques = Cheques::model()->findByPk($idCheque);
            $idCliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : 0;
            //$clientesDataProvider = $clientes->getClientesColocacion($model->id);
            $this->render('update', array(
                'originalModel' => $model, 'nuevoModel' => new Colocaciones, 'cheques' => $cheques, 'detalleColocaciones' => DetalleColocaciones::model()->getDetalleColocaciones($model->id, $idCliente), 'idClienteRecolocado' => $idCliente)
            );
        } else {
            $model = new Colocaciones;
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['Colocaciones'])) {
                $model->attributes = $_POST['Colocaciones'];
                $model->fecha = Date("Y-m-d");
                $model->estado = Colocaciones::ESTADO_ACTIVA;

                $connection = Yii::app()->db;

                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {

                        //pongo la colocacion padre como inactiva
                        $originalModel = Colocaciones::model()->findByPk($model->colocacionAnteriorId);
                        $originalModel->estado = Colocaciones::ESTADO_INACTIVA;
                        $originalModel->save();

                        $colocacionId = $model->id;
                        $cheque = Cheques::model()->findByPk($model->chequeId);
                        $inversoresActuales = array();
                        $listaDetalleColocaciones = explode(',', $_POST['detallesColocaciones']);
                        // creo los detalles para la nueva colocacion
                        for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 6) {
                            //voy guardando los ids de los inversores de la nueva colocacion
                            $inversoresActuales[] = $listaDetalleColocaciones[$i];

                            $detalleColocacion = new DetalleColocaciones();
                            $detalleColocacion->colocacionId = $colocacionId;
                            $detalleColocacion->clienteId = $listaDetalleColocaciones[$i];
                            
                            $detalleColocacion->monto = $listaDetalleColocaciones[$i + 2];
                            $detalleColocacion->tasa = $listaDetalleColocaciones[$i + 4];
                            if (!$detalleColocacion->save()) {
                                throw new Exception("Error al guardar detalle", 1);
                            } 
                        }

                        ##
                        #Seccion de actualizacion de comisiones, solo si el cheque ya fue comisionado
                        # es decir despues de cierre de caja
                        if($cheque->comisionado == 1) {    
                            $inversoresAnteriores = array();
                            //guardo en un array los ids de los inversores que estaban antes
                            foreach ($originalModel->detalleColocaciones as $detalleColocacion) {
                                $inversoresAnteriores[] = $detalleColocacion->clienteId;

                            }

                            //hago un diff entre los 2 arrays, por ahora suponemos que se reemplazo solo un inversor
                            $inversoresADevolverComision = array_diff($inversoresAnteriores, $inversoresActuales);
                            //otro diff para saber quien es el nuevo inversor colocado 
                            $inversoresNuevos = array_diff($inversoresActuales,$inversoresAnteriores);                       
                            
                            //recorro los detalles anteriores y busco cual es el que se reemplazo por el nuevo inversor  
                            foreach ($originalModel->detalleColocaciones as $detalleColocaciones) {
                                //supongo que hay uno solo que esta en la posicion 0
                                if($detalleColocaciones->clienteId == current($inversoresADevolverComision)){
                                    $comisionOperador = $detalleColocaciones->comisionOperador;

                                    //aqui se usa la regla de 3 simple para saber cuanto le corresponde al operador anterior al dia en
                                    //que se recoloca
                                    $montoComision = $comisionOperador->monto;
                                    $fechaColocacion = Utilities::ViewDateFormat($originalModel->fecha);
                                    $hoy = date("d-m-Y");
                                    $diasColocados = $originalModel->diasColocados;
                                    $diasColocadosAlDia = Utilities::RestarFechas3($fechaColocacion,$hoy);
                                    $montoComisionAlDia = Utilities::truncateFloat($montoComision*$diasColocadosAlDia/$diasColocados,2);
                                    
                                    //actualizo el registro de comision con el nuevo monto
                                    $comisionOperador->monto = $montoComisionAlDia;
                                    if(!$comisionOperador->save()){
                                        throw new Exception("Error Al actualizar comision", 1);
                                    }

                                    //recorro los nuevos detalles para ver cual es el detalle asociado al cambio    
                                    foreach ($model->detalleColocaciones as $detalleColocacionesNuevo) {
                                        //busco el detalle con el inversor nuevo
                                        if($detalleColocacionesNuevo->clienteId == current($inversoresNuevos)) {
                                            $operador = $detalleColocacionesNuevo->cliente->operador;

                                            //si la comision original ya fue acreditada tengo que hacer debito en 
                                            //operador original por la diferencia
                                            //y hacer un credito en el nuevo operador con la otra diferencia
                                            //idea si el operador es el mismo habria que hacer los movimientos igual?
                                            if($comisionOperador->estado == ComisionesOperadores::ESTADO_ACREDITADO){
                                                //debito del operador original la parte que va para el nuevo
                                                $ctacteCliente = new CtacteClientes();
                                                $ctacteCliente->tipoMov = CtacteClientes::TYPE_DEBITO;
                                                $ctacteCliente->conceptoId = 10;
                                                $ctacteCliente->clienteId = $operador->clienteId;
                                                $ctacteCliente->productoId = 1;
                                                $ctacteCliente->descripcion = "Debito por reemplazo en inversion";

                                                $ctacteCliente->monto = $montoComision - $montoComisionAlDia;
                                                $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()-$ctacteCliente->monto;
                                                $ctacteCliente->fecha = date("Y-m-d");
                                                $ctacteCliente->origen = "DetalleColocaciones";
                                                $ctacteCliente->identificadorOrigen = $detallesColocaciones->id;
                                                if (!$ctacteCliente->save()) {
                                                    throw new Exception("Error Al debitar", 1);

                                                }
                                                //pongo lo que le va al nuevo operador
                                                $ctacteCliente = new CtacteClientes();
                                                $ctacteCliente->tipoMov = CtacteClientes::TYPE_CREDITO;
                                                $ctacteCliente->conceptoId = 10;
                                                $ctacteCliente->clienteId = $detalleColocacionesNuevo->cliente->operador->clienteId;
                                                $ctacteCliente->productoId = 1;
                                                $ctacteCliente->descripcion = "Credito por reemplazo de inversion";

                                                $ctacteCliente->monto = $montoComisionAlDia;
                                                $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()-$ctacteCliente->monto;
                                                $ctacteCliente->fecha = date("Y-m-d");
                                                $ctacteCliente->origen = "DetalleColocaciones";
                                                $ctacteCliente->identificadorOrigen = $detalleColocacionesNuevo->id;
                                                if (!$ctacteCliente->save()) {
                                                    throw new Exception("Error al acreditar comision en ctacte", 1);
                                                }
                                            }
                                            //para el nuevo detalle creo un registo en comisionesOperadores con el monto de la diferencia
                                            //para el nuevo operador
                                            $nuevaComision = new ComisionesOperadores();
                                            $nuevaComision->detalleColocacionId = $detalleColocacionesNuevo->id;
                                            $nuevaComision->operadorId = $operador->id;
                                            $nuevaComision->porcentaje = $comisionOperador->porcentaje;
                                            $nuevaComision->monto = $montoComision - $montoComisionAlDia;
                                            $nuevaComision->estado = $comisionOperador->estado;
                                            
                                            if(!$nuevaComision->save())
                                                throw new Exception("Error al guardar la comision");
                                        }
                                        
                                    } 
                                }
                            }
                        }
                        
                        $conceptoId = 10; //
                        $productoId = 1; //compra de cheques
                        $fecha = date("d/m/Y");
                        $origen = "Colocaciones";
                        $identificadorOrigen = $model->id;
                        $descripcion = "Acreditacion por reemplazo. Inversion Nro. ".$model->chequeId;
                        $cheques = Cheques::model()->findByPk($model->chequeId);
                        for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 6) {
                            $ctacteCliente = new CtacteClientes();
                            $ctacteCliente->tipoMov = CtacteClientes::TYPE_DEBITO;
                            $ctacteCliente->conceptoId = 10;
                            $ctacteCliente->clienteId = $listaDetalleColocaciones[$i];
                            $ctacteCliente->productoId = $productoId;
                            $ctacteCliente->descripcion = $descripcion;
                            $valorActual = $model->calculoValorActual($listaDetalleColocaciones[$i + 2], Utilities::ViewDateFormat($cheques->fechaPago), $listaDetalleColocaciones[$i + 4], $_POST["clearing"]);

                            $ctacteCliente->monto = $valorActual;
                            $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()-$ctacteCliente->monto;
                            $ctacteCliente->fecha = $fecha;
                            $ctacteCliente->origen = $origen;
                            $ctacteCliente->identificadorOrigen = $identificadorOrigen;
                            if (!$ctacteCliente->save()) {
                                throw new Exception("Error al crear la acreditacion por reemplazo");
                            }
                        }

                        $descripcion = "Devolucion por recolocacion";
                        $tipoMov = CtacteClientes::TYPE_CREDITO; //credito
                        $conceptoId = 9; //
                        $productoId = 1; //compra de cheques
                        $origen = "Colocaciones";
                        $identificadorOrigen = $model->id;
                        if ($_POST['idClienteRecolocado'] != 0) {
                            //busco quien era el cliente que ya no esta en la colocacion
                            for ($i = 0; $i < count($originalModel->detalleColocaciones); $i++) {
                                if ($originalModel->detalleColocaciones[$i]->clienteId == $_POST['idClienteRecolocado']) {
                                    $valorActual = $model->calculoValorActual($originalModel->detalleColocaciones[$i]->monto, Utilities::ViewDateFormat($model->cheque->fechaPago), $originalModel->detalleColocaciones[$i]->tasa, $_POST["clearing"]);
                                    $ctacteCliente = new CtacteClientes();
                                    $ctacteCliente->tipoMov = $tipoMov;
                                    $ctacteCliente->conceptoId = $conceptoId;
                                    $ctacteCliente->clienteId = $_POST['idClienteRecolocado'];
                                    $ctacteCliente->productoId = $productoId;
                                    $ctacteCliente->descripcion = $descripcion;

                                    $ctacteCliente->monto = $valorActual;
                                    // por ser credito sumo al monto acumulado
                                    $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()+$ctacteCliente->monto;
                                    $ctacteCliente->fecha = $fecha;
                                    $ctacteCliente->origen = $origen;
                                    $ctacteCliente->identificadorOrigen = $identificadorOrigen;
                                    if (!$ctacteCliente->save()) {
                                        throw new Exception("Error al guardar la acreditacion");
                                    }
                                    break;
                                }
                            }
                        } else {
                            //caso contrario recoloco todos los clientes
                            for ($i = 0; $i < count($originalModel->detalleColocaciones); $i++) {
                                $valorActual = $model->calculoValorActual($originalModel->detalleColocaciones[$i]->monto, Utilities::ViewDateFormat($model->cheque->fechaPago), $originalModel->detalleColocaciones[$i]->tasa, $_POST["clearing"]);
                                $ctacteCliente = new CtacteClientes();
                                $ctacteCliente->tipoMov = $tipoMov;
                                $ctacteCliente->conceptoId = $conceptoId;
                                $ctacteCliente->clienteId = $originalModel->detalleColocaciones[$i]->clienteId;
                                $ctacteCliente->productoId = $productoId;
                                $ctacteCliente->descripcion = $descripcion;

                                $ctacteCliente->monto = $valorActual;
                                $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()+$ctacteCliente->monto;
                                $ctacteCliente->fecha = $fecha;
                                $ctacteCliente->origen = $origen;
                                $ctacteCliente->identificadorOrigen = $identificadorOrigen;
                                if (!$ctacteCliente->save()) {
                                    throw new Exception("Error al guardar la comision");
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Movimiento realizado con exito');
                        $this->redirect(array('recolocacion'));
                    }
                } catch (Exception $e) { // an exception is raised if a query fails
                    $transaction->rollBack();
                    //die();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                                //de aqui veo si el cheque vino de un get o un post
                    $idCheque = $_POST["Colocaciones"]["chequeId"];

                    $model = Colocaciones::model()->find('chequeId=:chequeId && estado=:estado', array('chequeId' => $idCheque, 'estado' => Colocaciones::ESTADO_ACTIVA));

                    $cheques = Cheques::model()->findByPk($idCheque);
                    $idCliente = $_POST['idClienteRecolocado'];
                    //$clientesDataProvider = $clientes->getClientesColocacion($model->id);
                    $this->render('update', array(
                        'originalModel' => $model, 'nuevoModel' => new Colocaciones, 'cheques' => $cheques, 'detalleColocaciones' => DetalleColocaciones::model()->getDetalleColocaciones($model->id, $idCliente), 'idClienteRecolocado' => $idCliente)
                    );
                }
            }
            $clientes = new Colocaciones('search');
            $clientes->unsetAttributes();  // clear any default values
            if (isset($_GET['Clientes']))
                $clientes->attributes = $_GET['Clientes'];
            $this->render('create', array(
                'model' => $model, 'cheques' => new Cheques, 'clientes' => $clientes)
            );
        }

    }

    public function actionRealizarRecolocacion() {

    }

    public function actionCalculoValorActual() {
        $model = new Colocaciones;
        if (isset($_POST)) {
            $montoOrigen = $_POST["montoColocado"];
            $tasa = $_POST["tasa"];
            $cheque = Cheques::model()->findByPk($_POST["idCheque"]);

            echo $model->calculoValorActual($montoOrigen, Utilities::ViewDateFormat($cheque->fechaPago), $tasa, $_POST["clearing"]);
        }
        //echo "hola";
    }

    public function actionInformePosicion() {
        $this->render('informePosicion', array('model' => new Colo
        ));
    }

}
