<?php


require __DIR__ . '/../vendor/autoload.php';

// 实例化服务容器
// 此时的服务容器完全为空
$app = new Illuminate\Container\Container;
// 注册事件\路由提供者
// 此处with为了优雅的链式调用
with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();

$manager = new \Illuminate\Database\Capsule\Manager();
$manager->addConnection(require __DIR__ . '/../config/database.php');

// 启动模块
$manager->bootEloquent();


// 视图模块
$app->instance('config', new \Illuminate\Support\Fluent());

// 视图路径设置
$app['config']['view.compiled'] = __DIR__ . '/../storage/framework/views';
$app['config']['view.paths'] = [__DIR__ . '/../resources/views'];

// 注册视图提供者
with(new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

// 实例化Http请求,分发给路由
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

// 向浏览器发送响应
$response->send();


