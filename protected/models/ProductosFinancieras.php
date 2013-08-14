<?php

/**
 * This is the model class for table "productoctacte".
 *
 * The followings are the available columns in table 'productoctacte':
 * @property string $id
 * @property string $nombreModelo
 * @property string $pkModeloRelacionado
 * @property integer $productoId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Ctacte[] $ctactes
 * @property Productos $producto
 */
class ProductosFinancieras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Productoctacte the static model class
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
		return 'productoctacte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombreModelo, pkModeloRelacionado, productoId, timeStamp', 'required'),
			array('productoId', 'numerical', 'integerOnly'=>true),
			array('nombreModelo', 'length', 'max'=>100),
			array('pkModeloRelacionado', 'length', 'max'=>20),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombreModelo, pkModeloRelacionado, productoId, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'finaciera' => array(self::BELONGS_TO, 'Financieras', 'pkModeloRelacionado'),
			'producto' => array(self::BELONGS_TO, 'Productos', 'productoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombreModelo' => 'Nombre Modelo',
			'pkModeloRelacionado' => 'Pk Modelo Relacionado',
			'productoId' => 'Producto',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nombreModelo',$this->nombreModelo,true);
		$criteria->compare('pkModeloRelacionado',$this->pkModeloRelacionado,true);
		$criteria->compare('productoId',$this->productoId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}