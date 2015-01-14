<?php

use yii\helpers\Html;
use yz\admin\widgets\Box;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var yz\admin\mailer\common\models\Mail $model
 */
$this->title = \Yii::t('admin/t', 'Update {item}', ['item' => yz\admin\mailer\common\models\Mail::modelTitle()]);
$this->params['breadcrumbs'][] = ['label' => yz\admin\mailer\common\models\Mail::modelTitlePlural(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<div class="mail-update">

    <div class="text-right">
        <?php  Box::begin() ?>
        <?=  ActionButtons::widget([
            'order' => [['index', 'update', 'return']],
            'addReturnUrl' => false,
        ]) ?>
        <?php  Box::end() ?>
    </div>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
