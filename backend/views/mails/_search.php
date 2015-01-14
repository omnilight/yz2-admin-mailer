<?php

use yii\helpers\Html;
use yz\admin\widgets\ActiveForm;
use yz\admin\widgets\FormBox;

/**
 * @var yii\web\View $this
 * @var yz\admin\mailer\backend\models\MailSearch $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<div class="mail-search hidden" id="filter-search">
    <?php $box = FormBox::begin() ?>
    <?php $box->beginBody() ?>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-3', 'input' => 'col-sm-5', 'offset' => 'col-sm-offset-3 col-sm-5'],
        ],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'status') ?>
    <?= $form->field($model, 'receivers_provider') ?>
    <?= $form->field($model, 'receivers_provider_data') ?>
    <?= $form->field($model, 'from') ?>
    <?php /* echo $form->field($model, 'from_name') */ ?>
    <?php /* echo $form->field($model, 'subject') */ ?>
    <?php /* echo $form->field($model, 'body_html') */ ?>
    <?php /* echo $form->field($model, 'boxy_text') */ ?>
    <?php /* echo $form->field($model, 'created_at') */ ?>
        <?php  $box->endBody() ?>
        <?php  $box->beginFooter() ?>
            <?= Html::submitButton(\Yii::t('admin/t','Search'), ['class' => 'btn btn-primary']) ?>
        <?php  $box->endFooter() ?>

    <?php ActiveForm::end(); ?>
    <?php  FormBox::end() ?>
</div>
