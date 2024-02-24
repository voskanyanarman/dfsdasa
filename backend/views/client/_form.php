<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Client $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ '1' => 'Male', '2' => 'Female', ], ['prompt' => 'Select Gender']) ?>

    <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
        'model' => $model,
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>
    <?= $form->field($model, 'clubs')->listBox(
        \yii\helpers\ArrayHelper::map(\common\models\Club::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Club'],
        ['multiple'=>'multiple']

    ) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
