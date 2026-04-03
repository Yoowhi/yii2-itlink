<?php

namespace app\controllers;

use app\common\StatusCode;
use app\dto\CreateCarDto;
use app\models\CreateCarModel;
use app\models\CreateCarOptionModel;
use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;

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
        $data = Yii::$app->request->post();

        $createCarModel = new CreateCarModel();
        if (!$createCarModel->load($data, '')) {
            throw new HttpException(StatusCode::UNPROCESSABLE_ENTITY);
        }

        if (!$createCarModel->validate()) {
            Yii::$app->response->statusCode = StatusCode::UNPROCESSABLE_ENTITY;
            return ['car' => $createCarModel->getErrors()];
        }

        $createCarOptionModel = null;
        if (!empty($data['options'])) {
            $createCarOptionModel = new CreateCarOptionModel();
            $createCarOptionModel->load($data['options'], ''); // здесь проверка не требуется, $data['options'] не будет null
            if (!$createCarOptionModel->validate()) {
                Yii::$app->response->statusCode = StatusCode::UNPROCESSABLE_ENTITY;
                return ['options' => $createCarOptionModel->getErrors()];
            }
        }

        $createCarDto = $createCarModel->toDto();
        $createCarOptionDto = $createCarOptionModel ? $createCarOptionModel->toDto() : null;
        return;
    }

    public function actionGetOne(int $id) 
    {

    }

    public function actionList() 
    {

    }
}
