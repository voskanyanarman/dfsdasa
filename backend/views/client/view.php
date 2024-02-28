<?php

use backend\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            [
                    'attribute' => 'gender',
                    'value' => $model->gender == 1 ? 'Male' : 'Female',
            ],
            'birthday',
            'created_at:datetime',
            [
                    'attribute'=>'created_by',
                    'value'=> \backend\components\Helper::getUsername($model->created_by),
            ],
            'updated_at:datetime',
            [
                    'attribute'=>'updated_by',
                    'value'=> \backend\components\Helper::getUsername($model->updated_by),
            ],
            'deleted_at:datetime',
            [
                    'attribute'=>'deleted_by',
                    'value'=> \backend\components\Helper::getUsername($model->deleted_by),
            ],
            [
                'attribute'=>'Clubs',
                'value'=>function ($data) {
                    return implode(', ', $data->getClubsList());
                }
            ],
        ],
    ]) ?>

</div>
