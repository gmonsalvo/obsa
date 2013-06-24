<?php


//            $this->render('update', array(
//                'model' => $model, 'cheques' => $cheques, 'clientesDataProvider' => $clientes->getClientesColocacion($_POST['idColocacion']))
//            );

?>



<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<h2><b>Editar Colocacion</b></h2>";
		    $this->endWidget();
?>

<?php echo $this->renderPartial('_EditColocacionform', array('originalModel' => $originalModel,'nuevoModel'=> $nuevoModel,'cheques'=>$cheques,'detalleColocaciones'=>$detalleColocaciones,'idClienteRecolocado'=>$idClienteRecolocado)); ?>