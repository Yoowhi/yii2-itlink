<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\filters\VerbFilter;

class CarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'get-one' => ['get'],
                    'list' => ['get'],
                ],
            ],
        ];
    }

    public function actionCreate() 
    {

    }

    public function actionGetOne(int $id) 
    {

    }

    public function actionList() 
    {

    }
}
