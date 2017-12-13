<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//trabajadores
$app->get('/api/trabajadores', function(Request $request, Response $response){
    
    $sql = "select * from trabajador";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajadores = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajadores);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});