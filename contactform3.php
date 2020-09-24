<?php
require_once 'vendor/autoload.php';

    $query = '質問';
    $name = '';
    $email = '';
    $detail = '';
    $result = 1;


if (!empty($_POST)) {
    $query = $_POST['query'];
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $email = $_POST['email'];
$isValidated = true;

    if($query === ''){
        $queryError = '質問内容を入力してください。';
$isValidated = false;
    }
    if($name === ''){
        $nameError = 'お名前を入力してください。';
        $isValidated = false;
    }
    if($email === ''){
        $emailError = 'メールアドレスを入力してください。';
        $isValidated = false;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError = 'メールアドレスの記述が違います';
        $isValidated = false;
    }
    if($detail === ''){
        $detailError = 'お問い合わせを入力してください。';
        $isValidated = false;
    }
    if($isValidated == true){

        define('SMTP_HOST','smtp.gmail.com');
        define('SMTP_PORT',587);
        define('SMTP_PROTOCOL','tls');
        define('GMAIL_SITE','tiikiokosi.kata@gmail.com');
        define('GMAIL_APPPASS','osrhsjytembslviq');
        define('MAIL_FROM',['tiikiokosi.kata@gmail.com' => '公式サイト']);
        define('MAIL_TO',[
            'tiikiokosi.kata@gmail.com'  => 'Web担当者様',
        ]);
        define('MAIL_TITLE','お問い合わせありがとうございます。');

        try {
            $transport = new Swift_SmtpTransport(
                SMTP_HOST,
                SMTP_PORT,
                SMTP_PROTOCOL
            );
            $transport->setUsername(GMAIL_SITE);
            $transport->setPassword(GMAIL_APPPASS);
            $mailer = new Swift_Mailer($transport);

            $message = new Swift_Message(MAIL_TITLE);
            $message->setFrom(MAIL_FROM);
            $message->setTo(MAIL_TO);

            $mailBody = <<<EOT
<img src="{$message->embed(Swift_Image::fromPath('logo.png'))}">
<h2>お問い合わせありがとうございます</h2>
<p>この度はお問い合わせいただき誠にありがとうございました。<br>
送信内容を以下の内容で承りました。</p>
----------------------------
<p>質問内容：{$query}</p>
<p>お名前：{$name}</p>
<p>メールアドレス：{$email}</p>
<p>お問い合わせ：{$detail}</p>
----------------------------
EOT;
            $message->setBody($mailBody, 'text/html');
            $result = $mailer->send($message);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }


}

function h($string)
{
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
  th,td {
    border-bottom: 1px dotted #ccc;
    padding: 10px;
  }
  th {
    vertical-align: top;
    text-align: left;
  }
  td {
    padding-bottom: 10px;
  }
  input[type="text"],
  input[type="email"],
  input[type="submit"],
  textarea {
    width: 400px;
    padding: 10px;
  }
  .error {
    font-weight: bold;
    color: #f00;
    font-size: 12px;
    font-weight: bold;
  }
  .error:before {
    content: "※ ";
  }
</style>
    <title>お問い合わせフォーム</title>
</head>

<body>
    <h1>お問い合わせフォーム</h1>
<?php if($result == 2):?>
<h1>お問い合わせありがとうございました。</h1>
<p><a href="contactform3.php">フォームに戻る</a></p>
<?php else:?>
<p>質問項目を選択し、送信ボタンを押してください。</p>
<form action="" method="post" novalidate>
        <table>
            <tr>
                <th>質問内容</th>
                <td>
                    <input type="radio" name="query" value="質問" <?= $query == '質問' ? 'checked' : ''?>>質問
                    <input type="radio" name="query" value="要望" <?= $query == '要望' ? 'checked' : ''?>>要望

                </td>
            </tr>
            <tr>
                <th>お名前</th>
                <td><input type="text" name="name" value="<?= h($name) ?>">
                <?php if(isset($nameError)):?>
                <span class="error"><?= h($nameError) ?></span>
                <?php endif;?>
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td><input type="text" name="email" value="<?=h($email)?>">
                <?php if(isset($emailError)):?>
                <span class="error"><?=h($emailError)?></span>
                <?php endif;?>
                </td>
            </tr>
            <tr>
                <th>お問い合わせ</th>
                <td><input type="text" name="detail" value="<?=h($detail)?>">
                <?php if(isset($detailError)):?>
                <span class="error"><?=h($detailError)?></span>
                <?php endif;?>
                </td>


            </tr>

            <tr><td><p><input type="submit" value="送信"></p></td></tr>
        </table>

    </form>
    <?php endif ;?>
</body>

</html>