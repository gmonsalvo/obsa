<?php

/**
 * This is the model class for table "sucursales".
 *
 * The followings are the available columns in table 'sucursales':
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property string $email
 * @property string $comisionGeneral
 * @property string $tasaDescuentoGeneral
 * @property string $tasaInversores
 * @property string $tasaPesificacion
 * @property string $tasaPromedioPesificacion
 * @property integer $diasClearing
 * @property integer $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Bancos[] $bancoses
 * @property Clientes[] $clientes
 * @property Libradores[] $libradores
 * @property Operadores[] $operadores
 * @property Pesificadores[] $pesificadores
 * @property Usuarios[] $usuarioses
 */
class Sucursales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sucursales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sucursales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, comisionGeneral, tasaDescuentoGeneral, tasaInversores, tasaPesificacion, diasClearing, userStamp, timeStamp, tasaPromedioPesificacion', 'required'),
			array('diasClearing', 'numerical', 'integerOnly'=>true),
			array('nombre, email', 'length', 'max'=>45),
			array('direccion', 'length', 'max'=>100),
			array('comisionGeneral, tasaDescuentoGeneral, tasaInversores, tasaPesificacion', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, direccion, email, comisionGeneral, tasaDescuentoGeneral, tasaInversores, tasaPesificacion, diasClearing, tasaPromedioPesificacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bancoses' => array(self::HAS_MANY, 'Bancos', 'sucursalId'),
			'clientes' => array(self::HAS_MANY, 'Clientes', 'sucursalId'),
			'libradores' => array(self::HAS_MANY, 'Libradores', 'sucursalId'),
			'operadores' => array(self::HAS_MANY, 'Operadores', 'sucursalId'),
			'pesificadores' => array(self::HAS_MANY, 'Pesificadores', 'sucursalId'),
			'usuarioses' => array(self::HAS_MANY, 'Usuarios', 'sucursalId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'direccion' => 'Direccion',
			'email' => 'Email',
			'comisionGeneral' => 'Comision General a Operadores',
			'tasaDescuentoGeneral' => 'Tasa Descuento General',
			'tasaInversores' => 'Tasa Inversores',
			'tasaPesificacion' => 'Tasa Pesificacion',
			'tasaPromedioPesificacion' => 'Tasa Promedio Pesificacion',
			'diasClearing' => 'Dias Clearing',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}

	protected function beforeValidate()
	{
		$this->userStamp = Yii::app()->user->model->username;
		$this->timeStamp = Date("Y-m-d h:m:s");
		return parent::beforeValidate();
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('comisionGeneral',$this->comisionGeneral,true);
		$criteria->compare('tasaDescuentoGeneral',$this->tasaDescuentoGeneral,true);
		$criteria->compare('tasaInversores',$this->tasaInversores,true);
		$criteria->compare('tasaPesificacion',$this->tasaPesificacion,true);
		$criteria->compare('diasClearing',$this->diasClearing);
		$criteria->compare('userStamp',$this->userStamp);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

}