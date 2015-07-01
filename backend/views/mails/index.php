<?php

use yii\helpers\Html;
use yz\admin\widgets\Box;
use yz\admin\grid\GridView;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yz\admin\mailer\backend\models\MailSearch $searchModel
 * @var array $columns
 */

$this->title = yz\admin\mailer\common\models\Mail::modelTitlePlural();
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<?php $box = Box::begin(['cssClass' => 'mail-index box-primary']) ?>
    <div class="text-right">
        <?php echo ActionButtons::widget([
            'order' => [['create', 'delete', 'return']],
            'gridId' => 'mail-grid',
            'searchModel' => $searchModel,
            'modelClass' => 'yz\admin\mailer\common\models\Mail',
        ]) ?>
    </div>

    <?= GridView::widget([
        'id' => 'mail-grid',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => array_merge([
            ['class' => 'yii\grid\CheckboxColumn'],
        ], $columns, [
            [
                'class' => 'yz\admin\widgets\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ]),
    ]); ?>
<?php Box::end() ?>
