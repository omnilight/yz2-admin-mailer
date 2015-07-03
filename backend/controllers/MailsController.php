<?php

namespace yz\admin\mailer\backend\controllers;

use backend\base\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yz\admin\actions\ExportAction;
use yz\admin\helpers\AdminHtml;
use yz\admin\mailer\backend\models\MailSearch;
use yz\admin\mailer\common\models\Mail;
use yz\Yz;

/**
 * MailsController implements the CRUD actions for Mail model.
 */
class MailsController extends Controller
{
    const ACTION_CHANGE_RECEIVERS_PROVIDER = 'changeReceiversProvider';
    const ACTION_SEND_MAIL = 'sendMail';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'export' => [
                'class' => ExportAction::className(),
                'dataProvider' => function ($params) {
                    $searchModel = new MailSearch;
                    $dataProvider = $searchModel->search($params);
                    return $dataProvider;
                },
            ]
        ]);
    }

    /**
     * Lists all Mail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'columns' => $this->getGridColumns(),
        ]);
    }

    public function getGridColumns()
    {
        return [
            'id',
            [
                'attribute' => 'status',
                'titles' => Mail::getStatusValues()
            ],
            [
                'attribute' => 'receivers_provider',
                'value' => function (Mail $data) {
                    return $data->getMailingList()->listTitle();
                }
            ],
//			'from',
            'from_name',
            'subject',
//			 'body_html:ntext',
//			 'boxy_text:ntext',
            'created_at:datetime',
            'last_sent_at:datetime',
        ];
    }

    /**
     * Creates a new Mail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mail;

        if ($model->loadAll(Yii::$app->request->post())) {
            if (Yii::$app->request->post(AdminHtml::ACTION_BUTTON_NAME) != self::ACTION_CHANGE_RECEIVERS_PROVIDER && $model->saveAll()) {
                \Yii::$app->session->setFlash(Yz::FLASH_SUCCESS, \Yii::t('admin/t', 'Record was successfully created'));
                return $this->getCreateUpdateResponse($model, [
                    self::ACTION_SEND_MAIL => function () use ($model) {
                        $model->waitForSending();
                        Yii::$app->session->setFlash(Yz::FLASH_INFO, Yii::t('admin/mailer', 'Mails are placed in the queue and will be sent soon'));
                        return $this->redirect(['index']);
                    }
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (
            $model->loadAll(Yii::$app->request->post()) &&
            Yii::$app->request->post(AdminHtml::ACTION_BUTTON_NAME) != self::ACTION_CHANGE_RECEIVERS_PROVIDER &&
            $model->saveAll()
        ) {
            \Yii::$app->session->setFlash(Yz::FLASH_SUCCESS, \Yii::t('admin/t', 'Record was successfully updated'));

            return $this->getCreateUpdateResponse($model, [
                self::ACTION_SEND_MAIL => [$this, 'updateMailStatus']
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Mail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Mail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(array $id)
    {
        $message = is_array($id) ?
            \Yii::t('admin/t', 'Records were successfully deleted') : \Yii::t('admin/t', 'Record was successfully deleted');
        $id = (array)$id;

        foreach ($id as $id_)
            $this->findModel($id_)->delete();

        \Yii::$app->session->setFlash(Yz::FLASH_SUCCESS, $message);

        return $this->redirect(['index']);
    }
}
