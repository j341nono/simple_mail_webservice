<?php
// DB接続情報
$dsn = 'mysql:host=db;port=3306;dbname=sample;charset=utf8mb4';
$username = 'root';
$password = 'secret';

try {
    // PDOで接続
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // userテーブルの取得
    $stmt = $pdo->query("SELECT id, name, email FROM user");

    // 1行ずつ配列として取得
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // ユーザ情報表示
        echo "id: " . $user['id'] . ", name: " . $user['name'] . "<br>";

        // メール内容
        $subject = "テストメール";
        $message = "こんにちは " . $user['name'] . " さん";

        // メール送信
        $result = mb_send_mail($user['email'], $subject, $message);

        if ($result) {
            echo "success<br>";
        } else {
            echo "fail<br>";
        }
    }

} catch (PDOException $e) {
    echo "DB接続エラー: " . $e->getMessage();
}
?>
