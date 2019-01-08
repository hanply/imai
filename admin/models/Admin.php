<?php
namespace admin\models;

use Yii;
use admin\modules\rbac\models\Role;
use admin\modules\rbac\models\AdminRole;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $account
 * @property string $nickname
 * @property string $realname
 * @property string $mobile
 * @property string $email
 * @property string $headimg
 * @property string $passwd
 * @property string $department_id
 * @property integer $sex
 * @property string $intro
 * @property integer $status
 * @property string $aid
 * @property string $updated_at
 * @property string $created_at
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'realname', 'passwd', 'aid', 'updated_at', 'created_at'], 'required'],
            [['department_id', 'sex', 'status', 'aid', 'updated_at', 'created_at'], 'integer'],
            [['account', 'nickname', 'realname'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 50],
            [['headimg'], 'string', 'max' => 255],
            [['passwd'], 'string', 'max' => 60],
            [['intro'], 'string', 'max' => 300],
            [['account'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => 'Account',
            'nickname' => 'Nickname',
            'realname' => 'Realname',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'headimg' => 'Headimg',
            'passwd' => 'Passwd',
            'department_id' => 'Department ID',
            'sex' => 'Sex',
            'intro' => 'Intro',
            'status' => 'Status',
            'aid' => 'Aid',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'aid',
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'aid',
                ],
                'value' => function ($event) {
                    return Yii::$app->user->id;
                },
            ],
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'passwd',
                ],
                'value' => function ($event) {
                    return Yii::$app->security->generatePasswordHash(Yii::$app->params['default_passwd']);
                },
            ],
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'account',
                ],
                'value' => function ($event) {
                    $lastAccount = self::find()->select('account')->orderBy('id desc')->asArray()->one();
                    if ((int)$lastAccount['account']==0) {
                        return '10001';
                    }
                    return (string)($lastAccount['account'] + 1);
                },
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['login'] = ['account', 'passwd', 'rememberMe'];
        $scenarios['changePasswd'] = ['passwd'];
        $scenarios['changeStatus'] = [];
        $scenarios['add'] = ['realname', 'mobile'];
        $scenarios['edit'] = ['nickname', 'status', 'phone', 'email', 'gender', 'intro'];
        
        return $scenarios;
    }

    public function getRbacAdminRole()
    {
        return $this->hasMany(AdminRole::className(), ['admin_id' => 'id'])->onCondition(['rbac_admin_role.status' => 1]);
    }

    public function getRbacRole()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])
            ->via('rbacAdminRole')->onCondition(['rbac_role.status' => 1]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
