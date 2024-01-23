<?php

namespace backend\modules\admin\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\filters\AccessControl;

class AppAdminController extends Controller
{
    public function behaviors()
    {


        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true, // shu class dan extends olgan class lar ga
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'], // authorization otmaganlarga login singnup
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'], // authorization otkanlarga logout
                    ],
                ],
            ],
        ];
    }
}