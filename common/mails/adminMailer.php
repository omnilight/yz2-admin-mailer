<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\mail\BaseMessage $message instance of newly created mail message
 * @var \yz\admin\mailer\common\models\Mail $mail
 * @var string $subject
 * @var string $body
 */
$message->setSubject($subject);
?>

<?= $body ?>