<?php

class DetallePesificacionesController extends Controller
{
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
				'actions'=>array('create','update','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new DetallePesificaciones;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
			if(isset($_POST['DetallePesificaciones']))
			{
				$pesificacion = Pesificaciones::model()->findByPk($_POST["DetallePesificaciones"]["pesificacionId"]);
				$monto = $_POST['DetallePesificaciones']["monto"];

				$saldoAnterior = $pesificacion->saldo;
				$saldoActual = $saldoAnterior + $monto;
				if($saldoActual<=0){
					$model->attributes=$_POST['DetallePesificaciones'];
					$model->estado=DetallePesificaciones::ESTADO_PENDIENTE;
					$model->tipoMov=DetallePesificaciones::TYPE_CREDITO;
					if($model->save()){
						$render = $this->renderPartial('/detallePesificaciones/verDetalles', array( 'model' => Pesificaciones::model()->findByPk($model->pesificacionId)), true, true);
						 echo CJSON::encode(array("status"=>"success","detallePesificaciones"=>$render));

						}
					else
						echo CJSON::encode(array("status"=>"error","errores"=>CHtml::errorSummary($model)));
				} else {
					$model->addError('error', 'Se supero el saldo. Ingrese un valor menor');
					echo CJSON::encode(array("status"=>"error","errores"=>CHtml::errorSummary($model)));
				}
			} else {
				$pesificacionId = isset($_GET["pesificacionId"]) ? $_GET["pesificacionId"] : 0;
				if(isset($_GET["asDialog"])) {
					if(isset($_GET["id"]))
						$model = DetallePesificaciones::model()->findByPk($_GET["id"]);

					$render = $this->renderPartial('/detallePesificaciones/_form', array( 'model' => $model, 'pesificacionId'=>$pesificacionId ), true);
					echo $render;
				} else {
					$render = $this->renderPartial('/detallePesificaciones/_form', array( 'model' => $model, 'pesificacionId'=>$pesificacionId ), true);
					echo $render;
					// $this->render('create',array(
					// 'model'=>$model,
					// ));
				}
			}

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
		if(isset($_GET["asDialog"])) {
			$render = $this->renderPartial('/detallePesificaciones/_formUpdate', array( 'model' => $model), true);
			echo $render;
		} else {

				$model=$this->loadModel($_GET["id"]);

				$pesificacion = $model->pesificacion;
				$monto = $_GET["monto"] - $model->monto;
				$saldoAnterior = $pesificacion->saldo;
				$saldoActual = $saldoAnterior + $monto;
				if($saldoActual<=0){

					$model->conceptoId=$_GET['conceptoId'];
					$model->monto=$_GET['monto'];
					if($model->save()){
							$render = $this->renderPartial('/detallePesificaciones/verDetalles', array( 'model' => Pesificaciones::model()->findByPk($model->pesificacionId)), true, true);
							 echo CJSON::encode(array("status"=>"success","detallePesificaciones"=>$render));
					} 	else
						echo CJSON::encode(array("status"=>"error","errores"=>CHtml::errorSummary($model)));
				} else {
					$model->addError('error', 'Se supero el saldo. Ingrese un valor menor');
					echo CJSON::encode(array("status"=>"error","errores"=>CHtml::errorSummary($model)));
				}
					//$this->redirect(array('view','id'=>$model->id));


			// $this->render('update',array(
			// 	'model'=>$model,
			// ));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
			$model->eliminado = true;
			$model->save();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			$render = $this->renderPartial('/detallePesificaciones/verDetalles', array( 'model' => Pesificaciones::model()->findByPk($model->pesificacionId)), true);
			echo CJSON::encode(array("status"=>"success","detallePesificaciones"=>$render));
			// if(!isset($_GET['ajax']))
			// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DetallePesificaciones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DetallePesificaciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DetallePesificaciones']))
			$model->attributes=$_GET['DetallePesificaciones'];

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
		$model=DetallePesificaciones::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='detalle-pesificaciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
