<?php

use common\models\Client;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\ClientSearch $searchModel */



$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'full_name',
            [
                'attribute'=> 'gender',
                'value' => function ($data) {

                    if ($data->gender == 1){
                        return 'Male' ;
                    }
                    else {
                        return 'Female' ;
                    }
                },
                'filter' => array( 1 => "Male",2=>"Female"),
            ],
            [
                "attribute" => "birthday",
                'value' => function ($model) {
                    if (extension_loaded('')) {
                        return Yii::t('app', '{0, date, MMMM dd, YYYY}', [$model->birthday]);
                    } else {
                        return $model->birthday;
                    }
                },
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'name'=>'birthday',
                    'convertFormat'=>true,
                    'includeMonthsFilter'=>true,
                    'attribute' => 'birthday_range',
                    'model' => $searchModel,
                    'pluginOptions' => ['locale' => ['format' => 'Y-m-d']],
                    'options' => ['placeholder' => 'Select Date']
                ])
            ],
            [
                // the attribute
                'attribute'=>"created_at",
                'value' => function ($model) {
                    if (extension_loaded('')) {
                        return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                    } else {
                        return date('Y-m-d H:i:s', $model->created_at);
                    }
                },
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'name'=>'created_at',
                    'convertFormat'=>true,
                    'includeMonthsFilter'=>true,
                    'attribute' => 'created_at_range',
                    'model' => $searchModel,
                    'pluginOptions' => ['locale' => ['format' => 'Y-m-d']],
                    'options' => ['placeholder' => 'Select Date']
                ])
            ],

            [
                'attribute'=>'created_by',
                'value'=> function ($model) {
                    return $model->createdBy->username;
                },
            ],
            [
                'label'=>"Club",
                'attribute'=>'club',
                'value'=>function ($data) {
                    return implode(', ', $data->getClubsList());
                },
                'filter'=> ArrayHelper::map(\common\models\Club::find()->all(), 'id', 'name'),
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
