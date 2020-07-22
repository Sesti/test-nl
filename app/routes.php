<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

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
        
        // Gather the username and password from the form
        if (!empty($request->getBody()->getContents())) {
            $creds = json_decode($request->getBody()->getContents());
        } else {
            return json_encode('{"status":"error"}');
        }

        // Hash the password
        $creds->password = hash('sha256', $creds->password);        

        // Instanciate Database helper object
        // @Todo switch to OOP
        require_once(__DIR__ . "/Database.php");
        $settings = include_once(__DIR__ . '/../config/config.php');
        $conn = $settings['settings']['connection'];
        $db = new mysqli(
                    $conn['host'] . ":" . $conn['port'], 
                    $conn['user'], 
                    $conn['pwd'],
                    $conn['name'] 
                );
        if ($db === false) {
            die("Could not connect.");
        }

        // Create query and compare credentials with database
        $query = $db->prepare("SELECT username FROM Users WHERE username = ? AND password = ?");
        $query->bind_param("ss", $creds->username, $creds->password);        
        $query->execute();
        $users = $query->fetch();
        $query->close();

        // Return token if user exists or return error if else
        if($users) {
            $response->getBody()->write(json_encode(['status' => 'success', 'token' => 'coming soon...']));
        } else {
            $response->getBody()->write(json_encode(['status' => 'failed']));
        }                

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
