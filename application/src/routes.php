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

$app->group('/api', function (App $app) {
    $app->get('/user', function (Request $request, Response $response, array $args) {
        sleep(1);
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
