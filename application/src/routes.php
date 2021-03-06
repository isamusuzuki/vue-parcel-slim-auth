<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use Slim\App;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // publicフォルダでspaファイルを探し、あればそれを返す
    $file = '../public/spa/app1/index.html';
    if (file_exists($file)) {
        return $response->write(file_get_contents($file));
    } else {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
});

$app->post('/auth', function (Request $request, Response $response, array $args) {
    # パラメータ取得
    $username = $request->getParsedBodyParam('username');
    $password = $request->getParsedBodyParam('password');
    # パラメータチェック
    if ($username === null || $password === null) {
        $result = ['message' => 'Authentication failure'];
        return $response->withJson($result, 400)->withHeader('Content-Type', 'application/json');
    }
    # ユーザー名でテーブルを検索
    $sql = "SELECT id, password FROM vpsa_users WHERE username = :username;";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!$row) {
        $data = ['message' => 'Authentication failure'];
        return $response->withJson($data, 400)->withHeader('Content-Type', 'application/json');
    }
    # パスワード確認
    if(!password_verify($password, $row['password'])){
        $data = ['message' => 'Authentication failure'];
        return $response->withJson($data, 400)->withHeader('Content-Type', 'application/json');
    }
    # トークン生成(有効期限は24時間分)
    $expires = time() + (60 * 60 * 24);
    $token = JWT::encode(['id' => $row['id'], 'username' => $username, 'exp' => $expires], $this->settings['jwt']['secret'], "HS256");
    # 正常終了
    $data = ['token' => $token];
    return $response->withJson($data, 200)->withHeader('Content-Type', 'application/json');
});

$app->post('/signup', function (Request $request, Response $response, array $args) {
    # パラメータ取得
    $username = $request->getParsedBodyParam('username');
    $password = $request->getParsedBodyParam('password');
    # パラメータチェック
    if ($username === null || $password === null) {
        $result = ['message' => 'required parameters not given'];
        return $response->withJson($result, 400)->withHeader('Content-Type', 'application/json');
    }
    # ユーザー名でテーブルを検索
    $sql = "SELECT id, password FROM vpsa_users WHERE username = :username;";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        $data = ['message' => 'username already exists'];
        return $response->withJson($data, 400)->withHeader('Content-Type', 'application/json');
    }

    # ユーザーを新規登録
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql2 = "INSERT INTO vpsa_users (username, password) VALUES (:username, :pass_hash);";
    $stmt2 = $this->db->prepare($sql2);
    $stmt2->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt2->bindParam(':pass_hash', $pass_hash, PDO::PARAM_STR);
    $stmt2->execute();
    # 正常終了
    $data = ['message' => 'New user created successfully.'];
    return $response->withJson($data, 200)->withHeader('Content-Type', 'application/json');
});


$app->group('/api', function (App $app) {
    $app->get('/user', function (Request $request, Response $response, array $args) {
        sleep(1);  // わざと1秒待機させる
        $payload = $request->getAttribute('decoded_token_data');
        $data = ['payload' => $payload];
        return $response->withJson($data, 200)->withHeader('Content-Type', 'application/json');
    });
});

// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });
