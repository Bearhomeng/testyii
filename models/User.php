<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password_hash
 * @property string $authKey
 * @property string $password_reset_token
 * @property string $create_datetime 
 * @property string $update_datetime 
 *
 * @property Issue[] $issues
 * @property Project[] $projects
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['username', 'password_hash'], 'string', 'max' => 32],
            [['authKey', 'password_reset_token'], 'string', 'max' => 255],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'username' => '用户账号',
            'password_hash' => '用户密码',
            'authKey' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'create_datetime' => '创建时间',
            'update_datetime' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['update_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['update_user_id' => 'id']);
    }
	
	public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['password_reset_token' => $token]);
    }
	
	public static function findByUsername($username){
		return User::findOne(['username' => $username]);
	}

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

	public function beforeSave($insert)
	{
	    if (parent::beforeSave($insert)) {
	    	$this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
	        if ($this->isNewRecord) {
	            $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString();
				$this->create_datetime = date("Y-m-d H-i-s");
	        }
			$this->update_datetime = date("Y-m-d H-i-s");
	        return true;
	    }
	    return false;
	}
	
	public function validatePassword($password){
		return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
	}
}
