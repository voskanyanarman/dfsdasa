<?php

namespace common\models;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $full_name
 * @property int $gender
 * @property int $birthday
 * @property int $created_at
 * @property int $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property ClientClub[] $clientClubs
 * @property Club[] $clubs
 * @property User $createdBy
 */
class Client extends \yii\db\ActiveRecord
{
    public $clubs_list;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'gender', 'birthday'], 'required'],
            [['gender', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
            ['clubs_list', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                    ActiveRecord::EVENT_BEFORE_DELETE => 'deleted_by',
                ],
                'value' => function ($event) {
                    return \Yii::$app->user->id;
                },
        ],
        'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_DELETE => ['deleted_at'],
                ],

            ],
        ];
    }
    /**
     * Gets query for [[ClientClubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientClubs()
    {
        return $this->hasMany(ClientClub::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Clubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClubs()
    {
        return $this->hasMany(Club::class, ['id' => 'club_id'])->viaTable('client_club', ['client_id' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
    public function getClubName()
    {
        return $this->club ? $this->club->name : null;
    }
//    public function beforeDelete()
//    {
//        if (!parent::beforeDelete()) {
//            $this->deleted_at = new Expression('NOW()');
//            $this->deleted_by = \Yii::$app->user->id;
//            Helper::pr($this);
//            $this->save();
//            return false;
//        } else {
//            return false;
//        }
//    }

    public function saveClubs($clientId,$clubId)
    {
        return \Yii::$app->db->createCommand()->batchInsert('client_club', ['client_id', 'club_id'], [[$clientId, $clubId]],)->execute();

    }
    public function deleteClubs($clientId)
    {
        return \Yii::$app->db->createCommand()->delete('client_club', ['client_id'=>$clientId])->execute();

    }

}
