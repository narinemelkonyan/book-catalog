<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return 'user';
    }

    /** @inheritdoc */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /** @inheritdoc */
    public function rules(): array
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
            [['status'], 'integer'],
        ];
    }

    /** @inheritdoc */
    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return null;
    }

    /**
     * Finds user by username.
     */
    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username, 'status' => 1]);
    }

    /** @inheritdoc */
    public function getId(): int
    {
        return $this->id;
    }

    /** @inheritdoc */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password.
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash.
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates auth key.
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}