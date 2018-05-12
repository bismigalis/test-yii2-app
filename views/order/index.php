<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Order;
?>

<nav class="bismi navbar navbar-fixed-top navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Orders</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <ul class="nav nav-tabs p-b">
    <?php foreach ([['title' => 'All orders', 'value' => NULL],
                    ['title' => 'Pending', 'value' => Order::STATUS_PENDING],
                    ['title' => 'In progress', 'value' => Order::STATUS_INPROGRESS],
                    ['title' => 'Completed', 'value' => Order::STATUS_COMPLETED],
                    ['title' => 'Canceled', 'value' => Order::STATUS_CANCELED],
                    ['title' => 'Error', 'value' => Order::STATUS_ERROR]] as $item): ?>
    <li class="<?= (is_null(Yii::$app->request->get('status')) ? NULL : intval(Yii::$app->request->get('status'))) === $item['value'] ? "active" : "" ?>">
      <a href="<?= Url::to(['order/index',
                            'status' => $item['value'],
                            'search' => Yii::$app->request->get('search'),
                            'search_type' => Yii::$app->request->get('search_type')]) ?>"><?= $item['title'] ?></a>
    </li>
    <?php endforeach; ?>

    <li class="pull-right custom-search">
      <form class="form-inline" method="get">
        <input type="hidden" name="r" value="order/index" />      
        <input type="hidden" name="status" value="<?= Yii::$app->request->get('status') ?>" />
        
        <div class="input-group">
          <input type="text" name="search" class="form-control" value="<?= Yii::$app->request->get('search') ?>" placeholder="Search orders">
          <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search_type">
              <option value="1" <?= Yii::$app->request->get('search_type') == '1' ? 'selected' : '' ?>>Order ID</option>
              <option value="2" <?= Yii::$app->request->get('search_type') == '2' ? 'selected' : '' ?>>Link</option>
              <option value="3" <?= Yii::$app->request->get('search_type') == '3' ? 'selected' : '' ?>>Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
      </form>
    </li>
  </ul>
  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Link</th>
      <th>Quantity</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Service
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <?php foreach ($services as $service_id => $service_name): ?>
            <li class="<?= (empty(Yii::$app->request->get('service_id')) ? '' : intval(Yii::$app->request->get('service_id'))) === $service_id ? "active" : "" ?>">
              <a href="<?= Url::to(['order/index',
                          'service_id' => $service_id,
                          'status' => Yii::$app->request->get('status'),
                          'mode' => Yii::$app->request->get('mode'),
                          'search' => Yii::$app->request->get('search'),
                          'search_type' => Yii::$app->request->get('search_type')]) ?>"><span class="label-id"><?= $orders_per_service[$service_id] ?> </span><?= $service_name ?></a>
            </li>
          <?php endforeach; ?>
          </ul>
        </div>
      </th>
      <th>Status</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Mode
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <?php foreach ([['title' => 'All', 'value' => NULL],
                          ['title' => 'Manual', 'value' => Order::MODE_MANUAL],
                          ['title' => 'Auto', 'value' => Order::MODE_AUTO]] as $item): ?>
                  <li class="<?= (is_null(Yii::$app->request->get('mode')) ? NULL : intval(Yii::$app->request->get('mode'))) === $item['value'] ? "active" : "" ?>">
                    <a href="<?= Url::to(['order/index',
                      'mode' => $item['value'],
                      'service_id' => Yii::$app->request->get('service_id'),
                      'status' => Yii::$app->request->get('status'),                      
                      'search' => Yii::$app->request->get('search'),
                      'search_type' => Yii::$app->request->get('search_type')]) ?>"><?= $item['title'] ?></a>
                  </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </th>
      <th>Created</th>
    </tr>
    </thead>
    <tbody>
    
    <?php foreach ($orders as $order): ?>
    <tr>
      <td><?= $order->id ?></td>
      <td><?= $order->user ?></td>
      <td class="link"><?= Html::encode("{$order->link}") ?></td>
      <td><?= $order->quantity ?></td>
      <td class="service">
        <span class="label-id"><?= $orders_per_service[$order->service_id] ?></span><?= $services[$order->service_id] ?>
      </td>
      <td><?= Order::getStatusLabel($order->status) ?></td>
      <td><?= Order::getModeLabel($order->mode) ?></td>
      <td><span class="nowrap"><?= date('Y-m-d', $order->created_at) ?></span>
          <span class="nowrap"><?= date('H:i:s', $order->created_at) ?></span></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <div class="row">
    <div class="col-sm-8">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <div class="col-sm-4 pagination-counters">
    <?php if ($pagination->totalCount > $pagination->pageSize): ?>
    <?= $pagination->page * $pagination->pageSize + 1 ?> to <?= min(($pagination->page + 1) * $pagination->pageSize, $pagination->totalCount) ?> of
    <?php endif; ?>
    <?= $pagination->totalCount ?>
    </div>
  </div>
</div>
