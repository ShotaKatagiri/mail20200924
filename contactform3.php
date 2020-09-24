<?php
require_once 'vendor/autoload.php';

    $query = '';
    $name = '';
    $email = '';
    $detail = '';
    $result = 1;


if (!empty($_POST)) {
    $query = $_POST['query'];
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $email = $_POST['email'];
    $validate = true;
    if($query === ''){
        $queryError = '質問内容を入力してください。';
        $validate = false;
    }
    if($name === ''){
        $nameError = 'お名前を入力してください。';
        $validate = false;
    }
    if($email === ''){
        $emailError = 'メールアドレスを入力してください。';
        $validate = false;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError = 'メールアドレスの記述が違います';
        $validate = false;
    }
    if($detail === ''){
        $detailError = 'お問い合わせを入力してください。';
        $validate = false;
    }
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
    <form action="" method="post">
<?php if($result == 2):?>
<h1>お問い合わせありがとうございました。</h1>
<?php endif ;?>
        <table>
            <tr>
                <th>質問内容</th>
                <td><input type="radio" name="query">
                    <input type="radio" name="query"></td>
            </tr>
            <tr>
                <th>お名前</th>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td><input type="text" name="eamil"></td>
            </tr>
            <tr>
                <th>お問い合わせ</th>
                <td><input type="text" name="detail"></td>
            </tr>

            <tr><td><p><input type="submit" value="送信"></p></td></tr>
        </table>

    </form>

</body>

</html>