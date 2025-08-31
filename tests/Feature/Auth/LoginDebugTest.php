<?php

test('debug all routes', function () {
    // List all available routes during testing
    $routes = app('router')->getRoutes();
    $routeNames = [];
    
    foreach ($routes as $route) {
        $routeNames[] = [
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'methods' => $route->methods(),
            'middleware' => $route->middleware()
        ];
    }
    
    dump('Available routes:');
    foreach ($routeNames as $route) {
        if (str_contains($route['uri'], 'login') || str_contains($route['name'] ?? '', 'login')) {
            dump($route);
        }
    }
    
    // Test the actual request
    $response = $this->get('/login');
    dump('Response status: ' . $response->status());
    
    $this->assertTrue(true); // Just pass for now
});
