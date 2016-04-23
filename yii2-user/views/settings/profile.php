<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\select2\Select2;
use swapf\location\models\City;
use yii\web\JsExpression;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
];

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
<?php

$url = "/frontend/web/index.php/location/default/countryautocomplete";

?>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                ]);

                //$model->location = 1;
                $cityname = empty($model->location) ? '' : City::getFullCityName($model->location);

                ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'public_email') ?>

                <?= $form->field($model, 'website') ?>

                <?= $form->field($model, 'location')->widget(Select2::classname(), [
                    'initValueText' => $cityname,
                    'options' => ['placeholder' => 'Укажите город ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => $url,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        ],
                        //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        //'templateResult' => new JsExpression('function(results) { return results.text; }'),
                        //'templateSelection' => new JsExpression('function (results) { return results.text; }'),
                    ],
                ]); ?>

                <?php //$form->field($model, 'location') ?>
                <?php

/*                $form->field($model, 'location')->widget(Select2::classname(),[
                'data' => $data,
                'options' => ['placeholder' => 'Select a color ...', 'multiple' => true, 'id'=>'location_id'],
                'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 4
                ],
                'pluginEvents' => [
                    "change" => "function() { alert(this.placeholder) }"
                ]
                ]);*/

                ?>

                <?= $form->field($model, 'gravatar_email')->hint(\yii\helpers\Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) ?>

                <?= $form->field($model, 'bio')->textarea() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
