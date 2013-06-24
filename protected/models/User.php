<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $sucursalId
 * @property integer $perfilId
 *
 * The followings are the available model relations:
 * @property Operadores[] $operadores
 * @property Sucursales $sucursal
 * @property Perfiles $perfil
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, sucursalId, perfilId', 'required'),
			array('sucursalId, perfilId', 'numerical', 'integerOnly'=>true),
                        array('username','unique'),
			array('username', 'length', 'max'=>45),
			array('password', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, sucursalId, perfilId', 'safe', 'on'=>'search'),
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
			'operadores' => array(self::HAS_ONE, 'Operadores', 'usuarioId'),
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
			'perfil' => array(self::BELONGS_TO, 'Perfiles', 'perfilId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'sucursalId' => 'Sucursal',
			'perfilId' => 'Perfil',
		);
	}

	protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
		$this->sucursalId = Yii::app()->user->model->sucursalId;
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('sucursalId',$this->sucursalId);
		$criteria->compare('perfilId',$this->perfilId);

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