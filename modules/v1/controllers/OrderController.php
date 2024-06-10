<?php

namespace app\modules\v1\controllers;

use app\models\Order;
use app\models\OrderSearch;
use Yii;
use yii\db\Exception;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class OrderController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create' => ['POST'],
                'index' => ['GET']
            ]
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /**
     * @return array - возвращает массив пациентов.
     *                 Где ключ 'count' указывает на количество пациентов
     *                 а 'data' - сами пациенты
     */
    public function actionIndex(): array
    {
        $params = Yii::$app->request->get();
        $model = new OrderSearch();
        $dataProvider = $model->restSearch($params);

        return ['count' => $dataProvider->count,'data' => $dataProvider];
    }

    /**
     * @return array - Возвращает массив с id созданного пациента
     *
     * @throws BadRequestHttpException|ServerErrorHttpException|ForbiddenHttpException
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $order = new Order();

        if (
            $order->load(Yii::$app->request->post(), '')
        ) {

            if ($order->save()) {
                Yii::$app->response->statusCode = 201;
                return ['OrderID' => $order->id];
            } elseif (empty($order->getErrors())) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
        throw new BadRequestHttpException($order->getReadableErrors());
    }
}
