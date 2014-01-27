<?php

use Exception\ExceptionHandler;
use Exception\HttpException;
use Routing\Route;
use View\TemplateEngineInterface;

class App
{
    const GET = 'GET';

    const POST = 'POST';

    const PUT = 'PUT';

    const DELETE = 'DELETE';

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var TemplateEngineInterface
     */
    private $templateEngine;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var statusCode
     */
    private $statusCode;

    public function __construct(TemplateEngineInterface $templateEngine, $debug = false)
    {
        $this->templateEngine = $templateEngine;
        $this->debug = $debug;

        $exceptionHandler = new ExceptionHandler($templateEngine, $this->debug);
        set_exception_handler(array($exceptionHandler, 'handle'));
    }

    /**
     * @param string $template
     * @param arrayx $parameters
     * @param int $statusCode
     *
     * @return string
     */
    public function render($template, array $parameters = array(), $statusCode = 200)
    {
        $this->statusCode = $statusCode;

        return $this->templateEngine->render($template, $parameters);
    }

    /** URIs REST Compliant validé par Le yoda du PHP
     *  GET /tweets
     *  GET /tweets/id
     *  POST /tweets
     *  DELETE /tweets/id
     */

    /**
     * @param string $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function get($pattern, $callable)
    {
        $this->registerRoute(self::GET, $pattern, $callable);

        return $this;
    }

    /**
     * @param string $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function post($pattern, $callable)
    {
        $this->registerRoute(self::POST, $pattern, $callable);

        return $this;
    }

    /**
     * @param string $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function put($pattern, $callable)
    {
        $this->registerRoute(self::PUT, $pattern, $callable);

        return $this;
    }

    /**
     * @param string $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function delete($pattern, $callable)
    {
        $this->registerRoute(self::DELETE, $pattern, $callable);

        return $this;
    }

    public function run()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {
                return $this->process($route);
            }
        }

        throw new HttpException(404, 'Page Not Found');
    }

    /**
     * @param Route $route
     */
    private function process(Route $route)
    {
        try {
            http_response_code($this->statusCode);
            echo call_user_func_array($route->getCallable(), $route->getArguments());
        } catch (HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new HttpException(500, NULL, $e);
        }
    }

    /**
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     */
    private function registerRoute($method, $pattern, $callable)
    {
        $route = new Route($method, $pattern, $callable);
        $this->routes[] = $route;
    }
}
