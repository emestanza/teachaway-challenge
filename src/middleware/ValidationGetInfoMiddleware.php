<?php

class ValidationGetInfoMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $route = $request->getAttribute('route');
        $args = $route->getArguments();
        
        $v = new Valitron\Validator($args);
        $v->rule('required', 'name');
        $v->rule('in', 'type', ['vehicle', 'starship']);
    
        if(!$v->validate()) {
            return $response->withJson([
                "error" => [
                    $v->errors(),
                ]], 400);
        }

        $response = $next($request, $response);
        return $response;
    }
}