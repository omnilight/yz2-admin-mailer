<?php

use yz\admin\helpers\AdminHtml;
use yz\admin\widgets\ActiveForm;
use yz\admin\widgets\FormBox;

/**
 * @var yii\web\View $this
 * @var yz\admin\mailer\common\models\Mail $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<?php $box = FormBox::begin(['cssClass' => 'mail-form box-primary', 'title' => '']) ?>
<?php $form = ActiveForm::begin(['layout' => 'default']); ?>

<?php $box->beginBody() ?>
<div class="row">
    <div class="col-md-8 col-md-offset-1">
        <?= $form->field($model, 'receivers_provider')->dropDownList($model->getReceiversProviderValues())->hint('Change of this field will reload current page') ?>
    </div>
</div>
<?php echo $this->render($model->receiversProvider->backendFormView(), [
    'form' => $form,
    'mail' => $model,
    'provider' => $model->receiversProvider,
]) ?>
<div class="row">
    <div class="col-md-3  col-md-offset-1">
        <?= $form->field($model, 'from')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'from_name')->textInput(['maxlength' => 255]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-1">
        <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'body_html')->tinyMce(['rows' => 6]) ?>
        <?= $form->field($model, 'boxy_text')->textarea(['rows' => 4])->hint(Yii::t('admin/mailer', 'If you leave this field empty, it will be automatically generated from HTML version')) ?>
    </div>
</div>


<?php $box->endBody() ?>

<?php $box->actions([
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_STAY, $model->isNewRecord),
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_LEAVE, $model->isNewRecord),
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_CREATE, $model->isNewRecord),
]) ?>
<?php ActiveForm::end(); ?>

<?php FormBox::end() ?>
