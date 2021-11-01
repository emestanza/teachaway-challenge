<?php

class ValidationPutIncDecMiddleware
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

        $v = new Valitron\Validator(array_merge($args, $request->getParams()));
        $v->rule('required', 'quantity');
        $v->rule('required', 'id');
        $v->rule('integer', 'quantity', true);
        $v->rule('min', 'quantity', 1);
        $v->rule('integer', 'id', true);
        $v->rule('min', 'id', 1);
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