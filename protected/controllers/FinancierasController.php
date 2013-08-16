<?php

class FinancierasController extends Controller
{
	////// Propiedades
	
	////// Métodos nuevos
	
	////// Métodos generados
	
	protected function dibujarCeldaResponsablesLista($data) 
    {
    	$model = $this->loadModel($data->id);
		
		$contenido = '';
		
		foreach ($model->responsables as $responsable)
			$contenido = $contenido.CHtml::encode($responsable['nombre'].' - Cel.: '.$responsable['celular'].' - E-Mail.: '.$responsable['email']).'<br>';
		
		return $contenido;
    }
	 	
	protected function dibujarCeldaResponsablesGrilla($data) 
    {
    	$model = $this->loadModel($data->id);
		
		$contenido = '';
		
		foreach ($model->responsables as $responsable)
			$contenido = $contenido.'<b>'.CHtml::encode($responsable['nombre']).'</b><br>'.CHtml::encode($responsable['celular']).'<br>'.CHtml::encode($responsable['email']).'<br>';
		
		return $contenido;
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
				'actions'=>array('create', 'update', 'admin', 'delete'),
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
		$model=new Financieras;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				
		if(isset($_POST['Financieras'])) {
			$model->attributes=$_POST['Financieras'];
			
			$data=array();
			
			if (isset($_POST['select_right'])) {
	        	$vect = $_POST['select_right'];
	        	foreach ($vect as $responsableId) {
	        		$data[] = (int) $responsableId;
	        	}						
			}
			
			$model->responsables = $data;
			
			$data=array();
			
			if (isset($_POST['productosSeleccionados'])) {
	        	$vect = $_POST['productosSeleccionados'];
	        	foreach ($vect as $productoId) {
	        		$data[] = (int) $productoId;
	        	}						
			}
			
			$model->productos = array();
			$model->productosFinanciera = array();
			
			$productos = $_POST['Financieras']['productosId'];
			
			$transaccion = Yii::app()->db->beginTransaction();
			
			if($model->save()) {
				
				$error = false;
				
				if ($productos)
					foreach ($productos as $idproducto) {
						$relacion = new Productoctacte();
						$relacion->nombreModelo = 'Financieras';
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

		if(isset($_POST['Financieras'])) {
			
			$data=array();
			
			$model->attributes=$_POST['Financieras'];
			
			if (isset($_POST['select_right'])) {
	        	$vect = $_POST['select_right'];
	        	foreach ($vect as $responsableId) {
	        		$data[] = (int) $responsableId;
	        	}						
			}
			
			$model->responsables = $data;
			
			/*
			header('Content-type: text/plain');
			print_r($model->relacionProductosFinanciera);
			exit;
			*/
			
			$model->productos = array();
			$model->productosFinanciera = array();
			
			$productos = $_POST['Financieras']['productosId'];
			
			$transaccion = Yii::app()->db->beginTransaction();
			
			if($model->save()) {
				
				$error = false;
				
				if ($productos)
					foreach ($productos as $idproducto) {
						$relacion = new Productoctacte();
						$relacion->nombreModelo = 'Financieras';
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

		$this->render('update',array('model'=>$model,));
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
			
			$model = $this->loadModel($id); 
			
			$model->responsables = array();
			
			$model->productos = array();
			$model->productosFinanciera = array();
			
			if ($model->save(false))
				$model->delete();
			else {
				print_r($model->getErrors());
				exit;
			}

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
		$dataProvider=new CActiveDataProvider('Financieras');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Financieras('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Financieras']))
			$model->attributes=$_GET['Financieras'];

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
		$model=Financieras::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='financieras-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
