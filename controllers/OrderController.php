<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Order;
use app\models\Service;
use yii\helpers\VarDumper;


class OrderController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($status = NULL, $mode = NULL, $service_id = '', $search = NULL, $search_type = NULL)
    {
        $search_fields = [
            '1' => 'id',
            '2' => 'link',
            '3' => 'user'
        ];

        $query = Order::find();
        
        if (!is_null($status)) {
            $query = $query->andWhere(['status' => $status]);
        }

        if ($service_id) {
            $query = $query->andWhere(['service_id' => $service_id]);
        }

        if (!is_null($mode)) {
            $query = $query->andWhere(['mode' => $mode]);
        }

        if (!is_null($search) && !is_null($search_type)) {
            $query = $query->andWhere(['LIKE', $search_fields[$search_type], $search]);
        }

        $pagination = new Pagination([
            'pageSize' => 100,
            'totalCount' => $query->count(),
        ]);

        $orders = $query
            ->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $services = Service::find()
            ->orderBy('id')
            ->all();
        $all_services = new \stdClass();
        $all_services->id = NULL;
        $all_services->name = 'All';
        array_unshift($services, $all_services);
        $services_by_id = [];
        foreach ($services as $service) {
            $services_by_id[$service->id] = $service->name;
        }

        $items = (new \yii\db\Query())
            ->select(['service_id', 'COUNT(*) AS amount'])
            ->from('orders')
            ->groupBy('service_id')
            ->all();

        $orders_per_service = [];
        $all_amount = 0;
        foreach ($items as $item) {
            $orders_per_service[$item['service_id']] = $item['amount'];
            $all_amount = $all_amount + $item['amount'];
        }
        $orders_per_service[NULL] = $all_amount;

        //VarDumper::dump($service_id); exit;
        
        return $this->render('index', [
            'services' => $services_by_id,
            'orders_per_service' => $orders_per_service,
            'orders' => $orders,
            'pagination' => $pagination
        ]);
    }
}