<?php

use yz\admin\helpers\AdminHtml;
use yz\admin\mailer\backend\controllers\MailsController;
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
        <?= $form->field($model, 'receivers_provider')->dropDownList($model->getReceiversProviderValues())->hint(Yii::t('admin/mailer', 'Change of this field will reload current page')) ?>
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
    </div>
</div>


<?php $box->endBody() ?>

<?php $box->actions([
    \yii\helpers\Html::submitButton($model->isNewRecord ? Yii::t('admin/mailer', 'Create & Send!') : Yii::t('admin/mailer', 'Save & Send!'), [
        'class' => 'btn btn-success btn-lg',
        'name' => AdminHtml::ACTION_BUTTON_NAME,
        'value' => MailsController::ACTION_SEND_MAIL,
    ]),
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_STAY, $model->isNewRecord),
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_LEAVE, $model->isNewRecord),
    AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_CREATE, $model->isNewRecord),
]) ?>
<?php ActiveForm::end(); ?>

<?php FormBox::end() ?>
<?php

$id = \yii\helpers\Html::getInputId($model, 'receivers_provider');
$actionName = AdminHtml::ACTION_BUTTON_NAME;
$actionValue = MailsController::ACTION_CHANGE_RECEIVERS_PROVIDER;
$js =<<<JS
(function() {
    $('#{$id}').on('change', function() {
        var _form = $('#{$form->id}');
        _form.append($('<input type="hidden">').attr('name', '{$actionName}').val('{$actionValue}'));
        _form.submit();
    });
})();
JS;
$this->registerJs($js);
