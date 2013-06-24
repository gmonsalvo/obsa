<?php

class RecibosOrdenPagoController extends Controller
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
				'actions'=>array('create','update','reciboPDF'),
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
		$model=new RecibosOrdenPago;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RecibosOrdenPago']))
		{
			$model->attributes=$_POST['RecibosOrdenPago'];
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

		if(isset($_POST['RecibosOrdenPago']))
		{
			$model->attributes=$_POST['RecibosOrdenPago'];
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
		$dataProvider=new CActiveDataProvider('RecibosOrdenPago');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RecibosOrdenPago('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecibosOrdenPago']))
			$model->attributes=$_GET['RecibosOrdenPago'];

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
		$model=RecibosOrdenPago::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='recibos-orden-pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionReciboPDF($id) {
        $model = $this->loadModel($id);

        $ordenPago=$model->ordenPago;
        //$formaPagoOrdenEfectivo = FormaPagoOrden::model()->getFormaPagoOrden($ordenPago->id, FormaPagoOrden::TIPO_EFECTIVO);
        $formaPagoOrdenCheques = FormaPagoOrden::model()->getFormaPagoOrden($ordenPago->id, FormaPagoOrden::TIPO_CHEQUES);

        $montoEfectivo = 0;
        $montoCheques = 0;
        foreach ($model->recibosDetalles as $detalle) {
        	if($detalle->tipoFondoId==0)
        		$montoEfectivo+=$detalle->monto;
        	else
        		$montoCheques+=$detalle->monto;
        }

        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetFont("times", "B", 16);
        $pdf->SetTitle("Recibo");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        //$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont("times", "", 12);

        $html = "";
        $html.='<b>Fecha:</b> ' . Date("d/m/Y"). '
                       <br/>
                       <br/>
                       <b>Cliente:</b> ' . $ordenPago->cliente->razonSocial . '
                       <br/>
                       <br/>
                       <b>Recibo Nro:</b> ' . $model->id . '
                       <br/>
                       <br/>
                       <b>Monto Total:</b> ' . Utilities::MoneyFormat($model->montoTotal) . '
                       <br/>
                       <br/>
                       <b>Monto Efectivo:</b> ' . Utilities::MoneyFormat($montoEfectivo) . '
                       <br/>
                       <br/>
                       <b>Monto Cheques:</b> ' . Utilities::MoneyFormat($montoCheques) . '
                       <br/>
                       <br/>
                       <br/>';              
        if ($montoCheques != 0) {

            $html.= '<table border="1" cellpadding="3"><tr><td align="center" style="width:60%"><b>Librador</b></td><td align="center" style="width:20%"><b>Nro Cheque</b></td><td align="center" style="width:20%"><b>Monto</b></td></tr>';
            $montoCheques = 0;
            for ($i = 0; $i < count($formaPagoOrdenCheques); $i++) {
                //$montoCheques+=$formaPagoOrdenCheques[$i]->monto;
                $chequeId = $formaPagoOrdenCheques[$i]->formaPagoId;
                $cheque = Cheques::model()->findByPk($chequeId);
                $html.='<tr><td align="center">' . $cheque->librador->denominacion . '</td><td align="right">' . $cheque->numeroCheque . '</td><td align="right">' . Utilities::MoneyFormat($formaPagoOrdenCheques[$i]->monto) . '</td></tr>';
            }
            $html.='</tbody></table>';
        }
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->SetFont("times", "B", 12);
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }
}
