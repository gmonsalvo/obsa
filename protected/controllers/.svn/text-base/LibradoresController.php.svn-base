<?php

class LibradoresController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'ranking','buscarLibradores','exportarRanking'),
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
        $model = new Libradores;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Libradores'])) {
            $model->attributes = $_POST['Libradores'];
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

        if (isset($_POST['Libradores'])) {
            $model->attributes = $_POST['Libradores'];
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
            throw new CHttpException(400, 'Solicitud invalida. Por favor, no repita esta solicitud nuevamente.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Libradores');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Libradores('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Libradores']))
            $model->attributes = $_GET['Libradores'];

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
        $model = Libradores::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'La pagina solicitada no existe.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'libradores-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionRanking() {
        $ranking = $this->getRanking(true);
        
        $this->render('ranking', $ranking);
    }
    
    public function actionBuscarLibradores(){
        $q = $_GET['term'];
        if (isset($q)) {
            $criteria = new CDbCriteria();
            $criteria->order = 'denominacion';
            $criteria->compare('denominacion', $q, true);
            $libradores=Libradores::model()->findAll($criteria);
            if (!empty($libradores)) {
                $out = array();
                foreach ($libradores as $c) {
                    $out[] = array(
                        'label' => $c->denominacion,
                        'value' => $c->denominacion,
                        'id' => $c->id, // 
                    );
                }

                echo CJSON::encode($out);
                Yii::app()->end();
            } else {
                echo "La consulta no devolvio resultados";
            }
        }
    }

    public function actionExportarRanking(){

        $filename  = 'Ranking Libradores';
        $ranking = $this->getRanking(false);
        $columns = array(
                array(
                    'name' => 'Librador',
                    'type' => 'raw',
                    'value' => 'CHtml::encode($data["librador"])'
                ),
                array(
                    'name' => 'Total',
                    'type' => 'raw',
                    'value' => 'Utilities::MoneyFormat($data["total"])'
                ),
                array(
                    'name' => '% en cartera',
                    'type' => 'raw',
                    'value' => 'Utilities::truncateFloat($data["porcentajeEnCartera"],2)'
                ),
        );
        $config = array(
            'title'     => 'Ranking Libradores',
            //'subTitle'  => 'Informe Al: '.$model->fecha,
            // 'colWidths' => array(40, 90, 40, 70),
        );
        $this->exportarGrid($filename,$ranking["arrayDataProvider"],$columns,$config);
    }

    public function getRanking($paginacion){
        $libradores = Libradores::model()->findAll();
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(montoOrigen) as total";
        $criteria->condition = "estado=:estado";
        $criteria->params = array(":estado" => Cheques::TYPE_EN_CARTERA_COLOCADO);
        $cheques = Cheques::model()->find($criteria);
        $totalEnCartera = $cheques->total == null ? 0 : $cheques->total;

        $criteria->condition = "libradorId=:libradorId AND estado=:estado";
        $rawData = array();
        $i = 1;
        //veo si es cero asi no hago division en cero
        
        if($paginacion)
            $paginacion = array('pageSize' => 10);
        else
            $paginacion = false;   
        if ($totalEnCartera != 0) {
            foreach ($libradores as $librador) {
                $criteria->params = array(":libradorId" => $librador->id, ":estado" => Cheques::TYPE_EN_CARTERA_COLOCADO);
                $cheques = Cheques::model()->find($criteria);
                $total = $cheques->total == null ? 0 : $cheques->total;
                $porcentajeEnCartera = ($total / $totalEnCartera) * 100;
                $rawData[] = array('id' => $i, 'librador' => $librador->denominacion, 'total' => $total, 'porcentajeEnCartera' => $porcentajeEnCartera);
                $i++;
            }
        }
        $arrayDataProvider = new CArrayDataProvider($rawData, array(
            'id' => 'id',
            'sort' => array(
                'defaultOrder' => 'porcentajeEnCartera DESC',
                'attributes' => array(
                    'porcentajeEnCartera'
                ),
            ),
            'pagination' => $paginacion,
        ));

        return compact("arrayDataProvider","totalEnCartera");
    }

}
