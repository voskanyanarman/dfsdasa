<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\multiselect\MultiSelect;



/** @var yii\web\View $this */
/** @var common\models\Client $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ '1' => 'Male', '2' => 'Female', ], ['prompt' => 'Select Gender']) ?>

    <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter birth date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd'
        ]
    ])?>
    <?= $form->field($model, 'clubs_list')->widget(Select2::classname(), ['data' => ArrayHelper::map(\common\models\Club::find()->all(),'id',"name"),
            'options' => ['placeholder' => 'Select a clubs ...'],
            'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
        ],
    ])
   ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
