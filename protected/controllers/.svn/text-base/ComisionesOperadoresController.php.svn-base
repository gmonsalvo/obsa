<?php

class ComisionesOperadoresController extends Controller
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
				'actions'=>array('create','update','admin'),
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
		$model=new ComisionesOperadores;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ComisionesOperadores']))
		{
			$model->attributes=$_POST['ComisionesOperadores'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['ComisionesOperadores']))
		{
			$model->attributes=$_POST['ComisionesOperadores'];
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
		$dataProvider=new CActiveDataProvider('ComisionesOperadores');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(isset($_POST["operadorId"])){
			try{
				$operador = Operadores::model()->findByPk($_POST["operadorId"]);
				$comisiones = $operador->getComisionesPendientes();
				$monto = 0;
				foreach ($comisiones as $comision) {
					$monto+=$comision->monto;
					$comision->estado = ComisionesOperadores::ESTADO_ACREDITADO;
					if(!$comision->save())
						throw new Exception("Error al acreditar", 1);
				}
				$ctacteCliente = new CtacteClientes();
                $ctacteCliente->tipoMov = CtacteClientes::TYPE_CREDITO;
                $ctacteCliente->conceptoId = 17;
                $ctacteCliente->clienteId = $operador->clienteId;
                $ctacteCliente->productoId = 1;
                $ctacteCliente->descripcion = "Acreditacion comision por colocacion";
                $ctacteCliente->monto = $monto;
                $ctacteCliente->saldoAcumulado=$ctacteCliente->getSaldoAcumuladoActual()+$ctacteCliente->monto;
                $ctacteCliente->fecha = date("Y-m-d");
                $ctacteCliente->origen = "Operadores";
                $ctacteCliente->identificadorOrigen = $operador->id;
                if(!$ctacteCliente->save())	
			    	throw new Exception("Error al acreditar", 1);
                Yii::app()->user->setFlash('success', "Se acreditaron las comisiones con exito");
            } catch (Exception $e){
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
		} 
		$model=new ComisionesOperadores('search');
		$model->unsetAttributes();  // clear any default values
		$totalAcreditar = 0;
		if(isset($_GET['ComisionesOperadores'])){
			$model->attributes=$_GET['ComisionesOperadores'];
			$operador = Operadores::model()->findByPk($_GET['ComisionesOperadores']["operadorId"]);
			$comisiones = $operador->getComisionesPendientes();
			foreach ($comisiones as $comision) {
				$totalAcreditar+=$comision->monto;
			}

		}
		$model->estado = ComisionesOperadores::ESTADO_PENDIENTE;
		$this->render('admin',array(
			'model'=>$model,'totalAcreditar' => $totalAcreditar
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ComisionesOperadores::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='comisiones-operadores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
