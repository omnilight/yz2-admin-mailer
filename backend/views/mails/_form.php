<?php

use yii\helpers\Html;
use yz\admin\helpers\AdminHtml;
use yz\admin\widgets\Box;
use yz\admin\widgets\FormBox;
use yz\admin\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yz\admin\mailer\common\models\Mail $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<?php  $box = FormBox::begin(['cssClass' => 'mail-form box-primary', 'title' => '']) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?php $box->beginBody() ?>
    <?= $form->field($model, 'body_html')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'boxy_text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'receivers_provider')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'from')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'from_name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>
    <?php $box->endBody() ?>

    <?php $box->actions([
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_STAY, $model->isNewRecord),
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_LEAVE, $model->isNewRecord),
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_CREATE, $model->isNewRecord),
    ]) ?>
    <?php ActiveForm::end(); ?>

<?php  FormBox::end() ?>
