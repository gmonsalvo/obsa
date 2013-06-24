<?php
class UserIdentity extends CUserIdentity
{
 
    private $id;
    private $model;
 
    public function getId()
    {
        return $this->id;
    }
 
    public function getModel()
    {
        return $this->model;
    }
 
 
    public function authenticate()
    {
        $user= User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
 
        if($user === null)
        {
            $this->errorCode= CBaseUserIdentity::ERROR_UNKNOWN_IDENTITY;
        }
        elseif($user->password !== $this->password)
        {
            $this->errorCode= CBaseUserIdentity::ERROR_PASSWORD_INVALID;
        }
        else
        {
            $this->model= $user;
            $this->id= $user->id;
            $this->username= $user->username;
            $this->errorCode= self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
}    
  
