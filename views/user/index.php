<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'User Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-5">
            <p><b>Current balance</b> <?php  echo $balance ?> $</p>
            <div>
                <?php if(!empty($dataProvider->getModels()))
                   foreach ($dataProvider->getModels() as $item){
                    if($item->user_id_from == Yii::$app->user->id){
                       echo  '<p class="history red">You sent '.$item->balance.' to '.$item->getUsername($item->user_id_to).' at '.$item->date.' </p>';
                    }else{
                       echo  '<p class="history green">You get '.$item->balance.' from '.$item->getUsername($item->user_id_to).' at '.$item->date.' </p>';
                    }
                   
                    } ?>
            </div>
            
            <?php     
                    echo LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]);
                   ?>
        </div>
        <div class="col-lg-5">
            <?php if (Yii::$app->session->hasFlash('balanceFormSubmitted')): ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Success!</strong> Balance was sent successfully
                </div>
            <?php endif; ?>
            <p>Send balance to another user</p>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'user')->textInput() ?>

            <?= $form->field($model, 'balance') ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>