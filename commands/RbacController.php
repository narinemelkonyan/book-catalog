<?php

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    /**
     * Initialize RBAC roles and create test user.
     */
    public function actionInit(): int
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $user = $auth->createRole('user');
        $user->description = 'Authenticated user with CRUD access';
        $auth->add($user);

        $model = new User();
        $model->username = 'admin';
        $model->email = 'admin@mail.ru';
        $model->setPassword('admin123');
        $model->generateAuthKey();
        $model->status = 1;

        if ($model->save()) {
            $auth->assign($user, $model->id);
            $this->stdout("User 'admin' created and assigned role 'user.'");
        } else {
            $this->stdout("Failed to create user.");
        }

        $this->stdout("RBAC initialized successfully.");

        return ExitCode::OK;
    }
}