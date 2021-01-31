<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

if (isset($success)) {
    if ($success) {
        echo "
        <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr>
            <td align=center>
            <br><br><br>Your message has been sent. Thank you!
			<br><br>Return to the <a href=\"/\">homepage</a>.
            </td></tr>
        </table>";
    }
    else {
        echo "
        <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr>
            <td align=center>
            <br><br><br>Something went wrong and your message was not sent.
            </td></tr>
        </table>";
    }
}
elseif ($model->hasErrors()) {
    echo "
        <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
            <tr>
            <td align=center>
            <br><br><br>Something went wrong and your message was not sent.
            </td></tr>
        </table>";

}
else {
    $form = ActiveForm::begin(); ?>

<table width=85% align="center" cellpadding="0" cellspacing="0" border=0>
    <tr><td>
            <table width="70%" cellpadding=3 cellspacing="1" border=0 align="center">
                <tr style="height:30px;"></tr>
                <tr align=center>
                    <td border=0 colspan=2>
                        We would love to hear any comments, suggestions, or feedback.<br>
                        Please enter your message in the box below: <br><br>
                        <?= $form->field($model, 'contacttext', ['template'=> "{input}"])
                                 ->textArea(['style' => "background-color: #eee; width: 400px; height: 200px"]) ?>
                    </td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td align="right">Name:</td>
                    <td>
                        <?= $form->field($model, 'name', ['template'=> "{input} {error}"]) ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">Email address:</td>
                    <td>
                        <?= $form->field($model, 'email', ['template'=> "{input} {error}"]) ?>
                    </td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr align=center>
                    <td colspan=2>
                        <?= $form->field($model, 'verifyCode', ['template'=> "{input} {error}"])
                            ->widget(Captcha::class, ['captchaAction' => '/front/index/captcha',
                                                           'template' => "{image}<br>Enter the captcha shown:<br> {input}"
                                ])
                        ?>
                    </td>
                </tr>
            </table>
        </td></tr>
    <tr height=15></tr>
    <tr>
        <td colspan=2 align="center">
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </td>
    </tr>
</table>

<?php ActiveForm::end();
}
?>
