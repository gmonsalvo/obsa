<?php
$this->breadcrumbs=array(
	'Cheques'=>array('adminCheques'),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listado de Cheques', 'url'=>array('adminCheques')),
);
?>

<h2><b>Devolucion de Cheque</b></h2>

<?php
	echo $this->renderPartial('viewCheck', array('model'=>$model));
	if ($model->estado == 4)
	{
		echo "<br><b>EL CHEQUE YA FUE DEVUELTO</b>";
	}
	else
	{
		echo $this->renderPartial('_formUpdateDevolucion', array('model'=>$model));
	}
?>