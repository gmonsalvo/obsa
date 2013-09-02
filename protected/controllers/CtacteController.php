<?php

class CtacteController extends Controller
{
	///// Métodos propios
	
	public function actionCargarProductosCliente() {
		
		$cliente = Clientes::model()->findByPk($_POST['Ctacte']['clienteId']);
		
		foreach($cliente->productos as $producto)
			echo CHtml::tag('option', array('value'=>$producto->id),CHtml::encode($producto->nombre),true);
	}
	
    public function actionFiltrar() {
        if(isset($_GET)){
        	exit();
            $model=new Ctacte();
            //$model->productoCtaCteId=$_GET["productoCtaCteId"];
            $dataProvider=$model->searchByFechaAndCliente(Utilities::MysqlDateFormat($_GET["fechaIni"]),Utilities::MysqlDateFormat($_GET["fechaFin"]),$_GET["clienteId"],$_GET["productoId"]);
            $this->renderPartial('/ctacte/gridCtaCte', array('model' =>$model,
            'dataProvider' => $dataProvider,
        ));
        }
    }
	
	///// Métodos generados
		
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
				'actions'=>array('create','update','admin','delete','cargarProductosCliente','filtrar'),
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
		$model=new Ctacte;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ctacte']))
		{
			$model->attributes=$_POST['Ctacte'];
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

		if(isset($_POST['Ctacte']))
		{
			$model->attributes=$_POST['Ctacte'];
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
		$dataProvider=new CActiveDataProvider('Ctacte');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $model = new Ctacte('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ctacte'])){
            $model->attributes = $_GET['Ctacte'];
            if (isset($_GET['fechaInicio'])){
                $model->fechaInicio=date('Y-m-d', CDateTimeParser::parse($_GET['fechaInicio'], 'dd/MM/yyyy'));
                $model->fechaFin=date('Y-m-d', CDateTimeParser::parse($_GET['fechaFin'], 'dd/MM/yyyy'));
            }else {
                $model->fechaInicio=date('Y-m-d', CDateTimeParser::parse($model->fechaInicio, 'dd/MM/yyyy'));
                $model->fechaFin=date('Y-m-d', CDateTimeParser::parse($model->fechaFin, 'dd/MM/yyyy'));
            }

          }  
        
        $this->render('admin', array(
            'model' => $model,
        ));
		
		/*
		$model=new Ctacte('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ctacte']))
			$model->attributes=$_GET['Ctacte'];

		$this->render('admin',array(
			'model'=>$model,
		));
		*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Ctacte::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ctacte-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
