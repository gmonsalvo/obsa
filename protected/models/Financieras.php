<?php

/**
 * This is the model class for table "financieras".
 *
 * The followings are the available columns in table 'financieras':
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $responsable
 * @property string $celular
 * @property string $email
 * @property string $tasaPromedio
 * @property integer $diasClearing
 * @property string $tasaPesificacion
 * @property string $userStamp
 * @property string $timeStamp
 */
class Financieras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Financieras the static model class
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
		return 'financieras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, direccion, responsable, userStamp, timeStamp', 'required'),
			array('diasClearing', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			array('direccion, telefono, responsable, celular, email, userStamp', 'length', 'max'=>45),
			array('tasaPromedio, tasaPesificacion', 'length', 'max'=>5),
			array('tasaPromedio, tasaPesificacion', 'numerical', 'integerOnly'=>false),
			array('email', 'email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, direccion, telefono, responsable, celular, email, tasaPromedio, diasClearing, tasaPesificacion, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'telefono' => 'Telefono',
			'responsable' => 'Responsable',
			'celular' => 'Celular',
			'email' => 'Email',
			'tasaPromedio' => 'Tasa Promedio',
			'diasClearing' => 'Dias Clearing',
			'tasaPesificacion' => 'Tasa Pesificacion',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
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
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tasaPromedio',$this->tasaPromedio,true);
		$criteria->compare('diasClearing',$this->diasClearing);
		$criteria->compare('tasaPesificacion',$this->tasaPesificacion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}