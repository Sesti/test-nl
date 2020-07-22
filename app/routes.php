<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use \Slim\Exception\HttpInternalServerErrorException;

return function (App $app) {


    /**
     *  Display the authencation form by using
     *  a html template.
     */
    $app->get('/', function (Request $request, Response $response) {
      $file = '../templates/index.html';
      
      if (file_exists($file)) 
          $response->getBody()->write(file_get_contents($file));

      return $response;
    });

    /**
     *  Post endpoint to validate user credentials.
     *  Returns a JWT if user has the correct credentials
     */
    $app->post('/authenticate', function(Request $request, Response $response) {
        $response->getBody()->write(json_encode(['authentication' => 'coming soon...']));

        return $response->withHeader('Content-Type', 'application/json');
    });

    /**
     *  Returns the users list in json format.
     */
    $app->get('/users', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode(['users' => 'coming soon...']));

        return $response->withHeader('Content-Type', 'application/json');
    });
    
};
