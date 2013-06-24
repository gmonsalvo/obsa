<?php

class TmpChequesController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'calcularMontoNeto', 'delete', 'deleteCheque','esChequeCorriente'),
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

        $model = new TmpCheques;

        // Ajax Validation enabled
        $this->performAjaxValidation($model);
        // Flag to know if we will render the form or try to add
        // new jon.
        $flag = true;
        if (isset($_POST['TmpCheques'])) {
            $flag = false;
            $model->attributes = $_POST['TmpCheques'];
            if(!isset($_POST['TmpCheques']['tasaDescuento']))
              $model->tasaDescuento = 0;
            $resultado = $model->calcularMontoNeto($model->montoOrigen, $model->fechaPago, $model->tasaDescuento, $model->clearing, $model->pesificacion, $_POST["fechaOperacion"]);
            if ($resultado["estado"]==TmpCheques::TYPE_INDEFINIDO){
              $model->addError("estado","El cheque a ingresar ya expiro");
              echo CJSON::encode(array("errores"=>CHtml::errorSummary($model)));
            } else {
              $model->estado = $resultado["estado"];
              $model->montoNeto = Utilities::Unformat($resultado["montoNeto"]);
              $model->montoOrigen = $_POST['TmpCheques']["montoOrigen"];
              $model->fechaPago = Utilities::MysqlDateFormat($model->fechaPago);

              $connection = Yii::app()->db;
              $command = Yii::app()->db->createCommand();
              if ($model->save()) {
                  $operacionesCheques=new OperacionesCheques();
                  $operacionesCheques->init();
                  $datos=array(
                    "montoNetoTotal"=>Utilities::MoneyFormat($operacionesCheques->montoNetoTotal),
                    "montoNominalTotal"=>Utilities::MoneyFormat($operacionesCheques->montoNominalTotal),
                    "totalIntereses"=>Utilities::MoneyFormat($operacionesCheques->montoIntereses),
                    "totalPesificacion"=>Utilities::MoneyFormat($operacionesCheques->montoPesificacion),
                    "errores"=>null
                    );
                  echo CJSON::encode($datos);
                  $model = new TmpCheques('search');
                  $model->unsetAttributes();  // clear any default values
                  if (isset($_GET['TmpCheques']))
                      $model->attributes = $_GET['TmpCheques'];
              }else
                  echo CJSON::encode(array("errores"=>CHtml::errorSummary($model)));
            }
        }
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

        if (isset($_POST['TmpCheques'])) {
            $model->attributes = $_POST['TmpCheques'];
            if ($model->save())
                $this->redirect(array('/operacionesCheques/nuevaOperacion', 'id' => $model->id));
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
        $dataProvider = new CActiveDataProvider('TmpCheques');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TmpCheques('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TmpCheques']))
            $model->attributes = $_GET['TmpCheques'];

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
        $model = TmpCheques::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tmp-cheques-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCalcularMontoNeto() {

        $model = new TmpCheques;
        $datos = $model->calcularMontoNeto($_POST['montoOrigen'], $_POST['fechaPago'], $_POST['tasaDescuento'], $_POST['clearing'], $_POST['pesificacion'], $_POST['fechaOperacion']);
        echo CJSON::encode($datos);
    }

    public function actionDeleteCheque() {
        $tmpcheque = new TmpCheques;
        $id = $_GET['id'];
        $this->loadModel($id)->delete();
        $operacionesCheques=new OperacionesCheques();
        $operacionesCheques->init();
        $datos=array(
              "montoNetoTotal"=>Utilities::MoneyFormat($operacionesCheques->montoNetoTotal),
              "totalIntereses"=>Utilities::MoneyFormat($operacionesCheques->montoIntereses),
              "totalPesificacion"=>Utilities::MoneyFormat($operacionesCheques->montoPesificacion),
        );
        echo CJSON::encode($datos);
    }

    public function actionEsChequeCorriente(){
      if($_POST){
        echo CJSON::encode(array("esCorriente"=>TmpCheques::model()->esChequeCorriente($_POST["fechaPago"],$_POST["fechaOperacion"])));
      }
    }

}
