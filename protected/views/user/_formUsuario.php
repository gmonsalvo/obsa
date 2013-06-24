<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 8, 'maxlength' => 8)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'perfilId'); ?>
        <?php echo $form->dropDownList($model, 'perfilId', CHtml::listData(Perfiles::model()->findAll(), 'id', 'descrpcion')); ?>
        <?php echo $form->error($model, 'perfilId'); ?>
    </div>


    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => 'Datos del Operador',
    ));
    ?>
    <?php echo CHtml::errorSummary($operador); ?>
    <div class="row">
        <?php echo CHtml::label("Apellido y Nombre", "apynom") ?>
        <?php echo CHtml::textField("apynom", $operador->apynom, array("id" => "apynom", 'size' => 60, 'maxlength' => 100)) ?>
        <?php //echo $form->error($model,'apynom');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Direccion", "direccion") ?>
        <?php echo CHtml::textField("direccion", $operador->direccion, array("id" => "direccion", 'size' => 60, 'maxlength' => 100)) ?>
        <?php //echo $form->error($model,'direccion');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Celular", "celular") ?>
        <?php echo CHtml::textField("celular", $operador->celular, array("id" => "celular", 'size' => 45, 'maxlength' => 45)) ?>
        <?php //echo $form->error($model,'celular');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Fijo", "fijo") ?>
        <?php echo CHtml::textField("fijo", $operador->fijo, array("id" => "fijo", 'size' => 45, 'maxlength' => 45)) ?>
        <?php //echo $form->error($model,'fijo');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Documento", "documento") ?>
        <?php echo CHtml::textField("documento", $operador->documento, array("id" => "documento", 'size' => 11, 'maxlength' => 11)) ?>
        <?php //echo $form->error($model,'documento');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Email", "email") ?>
        <?php echo CHtml::textField("email", $operador->email, array("id" => "email", 'size' => 60, 'maxlength' => 100)) ?>
        <?php //echo $form->error($model,'email');  ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Comision", "comision") ?>
        <?php echo CHtml::textField("comision", $operador->comision, array("id" => "comision", 'size' => 3, 'maxlength' => 3)) ?>
        <?php //echo $form->error($model,'comision');  ?>
    </div>


    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => 'Datos del Cliente',
    ));
    ?>
    <?php echo CHtml::errorSummary($cliente); ?>
    <div class="row">
        <?php echo CHtml::label("Razon Social", "razonSocial") ?>
        <?php echo CHtml::textField("razonSocial", $cliente->razonSocial, array("id" => "razonSocial", 'size' => 45, 'maxlength' => 45)) ?>
        <?php //echo $form->error($model,'razonSocial'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label("Documento", "documentoCliente") ?>
        <?php echo CHtml::textField("documentoCliente", $cliente->documento, array("id" => "documentoCliente", 'size' => 11, 'maxlength' => 11)) ?>
        <?php //echo $form->error($model,'documento'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label("Fijo", "fijoCliente") ?>
        <?php echo CHtml::textField("fijoCliente", $cliente->fijo, array("id" => "fijoCliente", 'size' => 45, 'maxlength' => 45)) ?>

        <?php //echo $form->error($model,'fijo'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Celular", "celularCliente") ?>
        <?php echo CHtml::textField("celularCliente", $cliente->celular, array("id" => "celularCliente", 'size' => 45, 'maxlength' => 45)) ?>
        <?php //echo $form->error($model,'celular'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Direccion", "direccionCliente") ?>
        <?php echo CHtml::textField("direccionCliente", $cliente->direccion, array("id" => "direccionCliente", 'size' => 45, 'maxlength' => 45)) ?>
        <?php echo $form->error($model, 'direccion'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Localidad", "localidadId") ?>
        <?php echo CHtml::dropDownList("localidadId", 0, CHtml::listData(Localidades::model()->findAll(), 'id', 'descripcion'), array("id" => "localidadId")) ?>
        <?php //echo $form->error($model,'localidadId'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Provincia", "provinciaId") ?>
        <?php echo CHtml::dropDownList("provinciaId", 0, CHtml::listData(Provincias::model()->findAll(), 'id', 'descripcion'), array("id" => "provinciaId")) ?>
        <?php //echo $form->error($model,'provinciaId'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Email", "emailCliente") ?>
        <?php echo CHtml::textField("emailCliente", $cliente->email, array("id" => "emailCliente", 'size' => 45, 'maxlength' => 45)) ?>
        <?php //echo $form->error($model,'email');  ?>
    </div>



    <div class="row">
        <?php echo CHtml::label("Tipo Cliente", "tipoCliente") ?>
        <?php echo CHtml::dropDownList("tipoCliente", 0, Clientes::model()->getTypeOptions(), array("id" => "tipoCliente")) ?>
        <?php //echo $form->labelEx($model,'tipoCliente');  ?>
        <?php //echo $form->error($model,'tipoCliente'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::label("Tasa Tomador", "tasaTomador") ?>
        <?php echo CHtml::textField("tasaTomador", Yii::app()->user->model->sucursal->tasaDescuentoGeneral, array("id" => "tasaTomador", 'size' => 5, 'maxlength' => 5)) ?>
        <?php //echo $form->error($model,'tasaTomador'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::label("Monto Maximo Tomador", "montoMaximoTomador") ?>
        <?php echo CHtml::textField("montoMaximoTomador", $cliente->montoMaximoTomador, array("id" => "montoMaximoTomador", 'size' => 15, 'maxlength' => 15)) ?>
        <?php //echo $form->error($model,'montoMaximoTomador'); ?>
    </div>	

    <div class="row">
        <?php echo CHtml::label("Tasa Inversor", "tasaInversor") ?>
        <?php echo CHtml::textField("tasaInversor", Yii::app()->user->model->sucursal->tasaInversores, array("id" => "tasaInversor", 'size' => 5, 'maxlength' => 5)) ?>
        <?php //echo $form->error($model,'tasaInversor'); ?>

    </div>
        <div class="row">
                <?php echo CHtml::label("Monto Permitido Descubierto", "montoPermitidoDescubierto") ?>
                <?php echo CHtml::textField("montoPermitidoDescubierto", $cliente->montoPermitidoCubierto, array("id" => "montoPermitidoCubierto", 'size' => 5, 'maxlength' => 5)) ?>                

	</div>

    <?php $this->endWidget(); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
    </div>

    <?php $this->endWidget(); ?>