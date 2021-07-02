<?php


namespace app\controllers;


use app\models\Country;
use app\models\EntryForm;
use yii\web\Controller;
use app\components\TestAction;
use yii\web\Response;
use yii\widgets\ActiveForm;

class TestController extends BaseController
{
//    public $foo = 'variable';
    public $layout = 'test';


    public function actions()
    {
        return [
            // my test action
            'test' => ['class' => 'app\components\TestAction'],

        ];
    }

    public function actionIndex()
    {
        \Yii::$app->view->title = 'testIndex';

        $model = new EntryForm();

        $model->load(\Yii::$app->request->post());
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->validate()) {

                return ['message' => 'ok'];
            } else {
                return ActiveForm::validate($model);
            }
            //return ActiveForm::validateMultiple($model);
        }


        /*if($model->load(\Yii::$app->request->post()) && $model->validate())
        {
            if(\Yii::$app->request->isPjax)
            {
                \Yii::$app->session->setFlash('success', 'data accepted with Pjax');
                $model = new EntryForm();
            }else
            {
                \Yii::$app->session->setFlash('success', 'data taken as standard');
                return $this->refresh();
            }



        }*/
        return $this->render('index', compact('model'));
    }

    public function actionView()
    {
        $model = new Country();
        $this->view->title = 'work with models';

        //$countries = Country::find()->where("population < 100000000 AND code <> 'AU'")->all();

        //for safe query
        //$countries = Country::find()->where("population < :population AND code <> :code", [':code' => 'AU', ':population' => 100000000])->all();

//        $countries = Country::find()->where([
//            'code' => ['DE', 'FR', 'GB'],
//            'status' => 1,
//        ])->all();

        //$countries = Country::find()->where(['like', 'name', 'uni'])->all();

        $countries = Country::find()->orderBy('population', 'DESC')->all();



        return $this->render('view', compact('countries'));
    }

}