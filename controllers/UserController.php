<?php
/**
 * yii2-pluto
 * ----------
 * User management module for Yii2 framework
 * Version 1.0.0
 * Copyright (c) 2019
 * Sjaak Priester, Amsterdam
 * MIT License
 * https://github.com/wsidebottom/yii2-pluto
 */

namespace wsidebottom\pluto\controllers;

use wsidebottom\pluto\Module;
use Yii;
use wsidebottom\pluto\models\User;
use wsidebottom\pluto\models\UserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'permissions' => ['manageUsers'],
                    ],
                ],
                'denyCallback' => [ 'wsidebottom\pluto\Module', 'accessDenied' ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['username' => SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'defaultRoles' => $this->getDefaultRoles(),
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        /* @var $module Module */
        $module = $this->module;

        $roles = $module->defaultRole;
        if (empty($roles)) $roles = [];
        if (is_string($roles)) $roles = [$roles];
        $model = new User([
            'scenario' => 'create',
            'status' => User::STATUS_ACTIVE,
            'roles' => $roles
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $this->getRoles(),
            'defaultRoles' => $this->getDefaultRoles(),
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findAndCheckModel($id, 'update');
        if (! $model) return $this->redirect(['index']);

        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
            // if error, updated_at may be 'GETDATE()', which DetailView doesn't understand
            $model->updated_at = $model->getOldAttribute('updated_at');
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $this->getRoles(),
            'defaultRoles' => $this->getDefaultRoles(),
        ]);
    }

    /**
     * @return array of Role name => Role name
     */
    protected function getRoles()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
    }

    /**
     * @return array of Role name
     */
    protected function getDefaultRoles()
    {
        /* @var $auth yii\rbac\BaseManager */
        $auth = Yii::$app->authManager;
        return $auth->getDefaultRoles();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findAndCheckModel($id, 'delete');
        if ($model) $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $verb
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findAndCheckModel($id, $verb)
    {
        $longName = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->lastname;
        $model = $this->findModel($id);
        if (! Yii::$app->user->can('updateUser', $model)) {
            Yii::$app->session->setFlash('danger', 'Sorry '.$longName.', you\'re not allowed to '.$verb.' <strong>'.$model->username.'</strong>\'s user data.');
            return null;
        }
        return $model;
    }

    /**
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested User does not exist.');
    }
}
