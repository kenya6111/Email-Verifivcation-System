<?php
// session_start(); 
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/..'));
// spl_autoload_extensions(".php");
// spl_autoload_register();
spl_autoload_extensions(".php");
spl_autoload_register();

header("Access-Control-Allow-Origin: *");
require_once "vendor/autoload.php";
require_once "Middleware/MiddlewareHandler.php";
//use Middleware\MiddlewareHandler;
$DEBUG = true;

if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css|html)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}
$method = $_SERVER['REQUEST_METHOD'];
// ルートを読み込みます。
$routes = include('Routing/routes.php');

// リクエストURIを解析してパスだけを取得します。
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, '/');

// ルートにパスが存在するかチェックする
if (isset($routes[$path])) {
     // ルートの取得
     $route = $routes[$path];

    try{
        // instanceof →ある PHP 変数が特定の クラス のオブジェクトのインスタンスであるかどうかを調べます。
        if(!($route instanceof Routing\Route)) throw new InvalidArgumentException("Invalid route type");

        // 配列連結ミドルウェア
        $middlewareRegister = include('Middleware/middleware-register.php');
        $middlewares = array_merge($middlewareRegister['global'], array_map(fn ($routeAlias) => $middlewareRegister['aliases'][$routeAlias], $route->getMiddleware()));

        $middlewareHandler = new \Middleware\MiddlewareHandler(array_map(fn($middlewareClass) => new $middlewareClass(), $middlewares));

        // チェーンの最後のcallableは、HTTPRendererを返す現在の$route callableとなります。
        $renderer = $middlewareHandler->run($route->getCallback());

        // ヘッダーを設定します。
        foreach ($renderer->getFields() as $name => $value) {
            // ヘッダーに対する単純な検証を実行します。
            $sanitized_value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

            if ($sanitized_value && $sanitized_value === $value) {
                header("{$name}: {$sanitized_value}");
            } else {
                // ヘッダー設定に失敗した場合、ログに記録するか処理します。
                // エラー処理によっては、例外をスローするか、デフォルトのまま続行することもできます。
                http_response_code(500);
                if($DEBUG) print("Failed setting header - original: '$value', sanitized: '$sanitized_value'");
                exit;
            }
            
            print($renderer->getContent());
        }
    }
    catch (Exception $e){
        http_response_code(500);
        print("Internal error, please contact the admin.<br>");
        if($DEBUG) print($e->getMessage());
    }
} else {
    // マッチするルートがない場合、404エラーを表示します。
    http_response_code(404);
    echo "404 Not Found: The requested route was not found on this server.";
}