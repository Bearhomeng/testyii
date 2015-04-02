<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $create_datetime
 * @property string $create_user_id
 * @property string $update_datetime
 * @property string $update_user_id
 *
 * @property Issue[] $issues
 * @property User $createUser
 * @property User $updateUser
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['create_datetime', 'update_datetime'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '项目名称',
            'description' => '项目描述',
            'create_datetime' => '创建时间',
            'create_user_id' => '创建用户',
            'update_datetime' => '更新时间',
            'update_user_id' => '更新用户',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'update_user_id']);
    }
	
	public function beforeSave($insert)
	{
    	if (parent::beforeSave($insert)) {
    		if($this->isNewRecord){
    			$this->create_datetime = date("Y-m-d H-i-s");
				$this->create_user_id = Yii::$app->user->getId();
    		}
			$this->update_datetime = date("Y-m-d H-i-s");
			$this->update_user_id = Yii::$app->user->getId();
        	return true;
    	} else {
        	return false;
    	}
	}
}
