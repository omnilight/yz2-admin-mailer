<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yz\admin\widgets\ActiveForm $form
 * @var \yz\admin\mailer\common\models\ManualReceiverProvider $provider
 * @var \yz\admin\mailer\common\models\Mail $mail
 */
?>
<div class="row">
    <div class="col-md-8 col-md-offset-1">
        <?= $form->field($provider, 'to')->input('email') ?>
    </div>
</div>