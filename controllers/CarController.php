<?php

namespace app\controllers;

/**
 * 
 * привет, мне катастрофически нужна эта работа
 * 
 */

use app\common\StatusCode;
use app\interfaces\CarServiceInterface;
use app\models\CreateCarModel;
use app\models\CreateCarOptionModel;
use app\models\SearchCarsModel;
use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class CarController extends Controller
{

    public function __construct(
        $id, 
        $module, 
        private CarServiceInterface $carService, 
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

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
        if (isset($data['options'])) {
            $createCarOptionModel = new CreateCarOptionModel();
            $createCarOptionModel->load($data['options'], '');
            if (!$createCarOptionModel->validate()) {
                Yii::$app->response->statusCode = StatusCode::UNPROCESSABLE_ENTITY;
                return ['options' => $createCarOptionModel->getErrors()];
            }
        }

        $createCarDto = $createCarModel->toDto();
        $createCarOptionDto = $createCarOptionModel ? $createCarOptionModel->toDto() : null;
        return $this->carService->createCar($createCarDto, $createCarOptionDto);
    }

    public function actionGetOne(int $id) 
    {
        $result = $this->carService->findOneById($id);
        if (is_null($result)) {
            throw new NotFoundHttpException();
        }
        return $result;
    }

    public function actionList(int $page = 1, int $limit = 10) 
    {
        $model = new SearchCarsModel([
            'page' => $page,
            'limit' => $limit
        ]);
        if (!$model->validate()) {
            Yii::$app->response->statusCode = StatusCode::UNPROCESSABLE_ENTITY;
            return $model->getErrors();
        }
        return $this->carService->findPage($model->toDto());
    }
}
