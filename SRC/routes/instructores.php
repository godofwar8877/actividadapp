<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//instructores
$app->get('/api/instructores', function(Request $request, Response $response){
    
    $sql = "select * from instructor";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructores = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instructores);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});
