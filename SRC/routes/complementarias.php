<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{Num_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('Num_control');

    $sql = "SELECT * FROM estudiante WHERE Num_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//agregar estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "INSERT INTO estudiante (Num_control, Nombre_estudiante, Apellido_p_estudiante, Apellido_m_estudiante, Semestre, Carrera_Clave)
                 VALUES (:nocontrol, :nombre, :apellidop, :apellidom, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                Num_control             = :nocontrol,
                Nombre_estudiante       = :nombre,
                Apellido_p_estudiante   = :apellidop,
                Apellido_m_estudiante   = :apellidom,
                Semestre                = :semestre,
                Carrera_Clave           = :carrera_clave
            WHERE Num_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{Num_control}', function(Request $request, Response $response){
    $Num_control = $request->getAttribute('Num_control');

    $sql = "DELETE FROM estudiante WHERE Num_control = $Num_control";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//carrera
$app->get('/api/carreras', function(Request $request, Response $response){
    //echo "Carrera";
    $sql = "select * from carrera";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carreras = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carreras);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});

// Obtener un carrera por clave carrera
$app->get('/api/carreras/{Clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getAttribute('Clave_carrera');

    $sql = "SELECT * FROM carrera WHERE Clave_carrera = $clavecarrera";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carreras = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carreras);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar carrera
$app->post('/api/carreras/add', function(Request $request, Response $response){
    $clavecarrera = $request->getParam('Clave_carrera');
    $nombrecarrera = $request->getParam('Nombre_carrera');
    

    $sql = "INSERT INTO carrera (Clave_carrera, Nombre_carrera) VALUES (:Clave_carrera, :Nombre_carrera)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Clave_carrera',    $clavecarrera);
        $stmt->bindParam(':Nombre_carrera',   $nombrecarrera);
      
        $stmt->execute();

        echo '{"notice": {"text": "Carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar carrera
$app->put('/api/carreras/update/{Clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getParam('Clave_carrera');
    $nombrecarrera = $request->getParam('Nombre_carrera');
  
    $sql = "UPDATE carrera SET
                Clave_carrera        = :Clave_carrera,
                Nombre_carrera       = :Nombre_carrera
              
            WHERE Clave_carrera = $clavecarrera";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Clave_carrera',    $clavecarrera);
        $stmt->bindParam(':Nombre_carrera',   $nombrecarrera);
       

        $stmt->execute();

        echo '{"notice": {"text": "Carrera actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar carrera
$app->delete('/api/carreras/delete/{Clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getAttribute('Clave_carrera');

    $sql = "DELETE FROM carrera WHERE Clave_carrera = $clavecarrera";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//actividad
$app->get('/api/actividad', function(Request $request, Response $response){
    //echo "actividad";
    $sql = "select * from actividad_comp";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});

// Obtener un actividad compl por num actividad
$app->get('/api/actividad/{Num_actividad}', function(Request $request, Response $response){
    $noact = $request->getAttribute('Num_actividad');

    $sql = "SELECT * FROM actividad_comp WHERE Num_actividad = $noact";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar actividad
$app->post('/api/actividad/add', function(Request $request, Response $response){
    $noact = $request->getParam('Num_actividad');
    $nombreact = $request->getParam('Nombre_actividad');
    

    $sql = "INSERT INTO actividad_comp (Num_actividad, Nombre_actividad) VALUES (:Num_actividad, :Nombre_actividad)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Num_actividad',    $noact);
        $stmt->bindParam(':Nombre_actividad',   $nombreact);
      
        $stmt->execute();

        echo '{"notice": {"text": "Actividad complementaria agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar actividad
$app->put('/api/actividad/update/{Num_actividad}', function(Request $request, Response $response){
    $noact = $request->getParam('Num_actividad');
    $nombreact = $request->getParam('Nombre_actividad');
  
    $sql = "UPDATE actividad_comp SET
                Num_actividad        = :Num_actividad,
                Nombre_actividad       = :Nombre_actividad
              
            WHERE Num_actividad = $noact";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Num_actividad',    $noact);
        $stmt->bindParam(':Nombre_actividad',   $nombreact);
       

        $stmt->execute();

        echo '{"notice": {"text": "Actividad compl actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar actividad
$app->delete('/api/actividad/delete/{Num_actividad}', function(Request $request, Response $response){
    $noact = $request->getAttribute('Num_actividad');

    $sql = "DELETE FROM actividad_comp WHERE Num_actividad = $noact";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Actividad complementaria eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//institutos
$app->get('/api/instituto', function(Request $request, Response $response){
    
    $sql = "select * from instituto";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institutos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($institutos);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});

// Obtener un instituto por clave_instituto
$app->get('/api/instituto/{claveinst}', function(Request $request, Response $response){
    $claveinstituto = $request->getAttribute('claveinst');

    $sql = "SELECT * FROM instituto WHERE claveinst = $claveinstituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institutos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($institutos);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar instituto
$app->post('/api/instituto/add', function(Request $request, Response $response){
    $claveinstituto = $request->getParam('claveinst');
    $nombreinstituto = $request->getParam('nombreinst');
    

    $sql = "INSERT INTO instituto (claveinst, nombreinst) VALUES (:claveinst, :nombreinst)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':claveinst',    $claveinstituto);
        $stmt->bindParam(':nombreinst',   $nombreinstituto);
      
        $stmt->execute();

        echo '{"notice": {"text": "Instituto agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar insituto
$app->put('/api/instituto/update/{claveinst}', function(Request $request, Response $response){
    $claveinstituto = $request->getParam('claveinst');
    $nombreinstituto = $request->getParam('nombreinst');
  
    $sql = "UPDATE instituto SET
                claveinst = :claveinst,
                nombreinst = :nombreinst
              
            WHERE claveinst = $claveinstituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':claveinst',    $claveinstituto);
        $stmt->bindParam(':nombreinst',   $nombreinstituto);
       

        $stmt->execute();

        echo '{"notice": {"text": "Instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar instituto
$app->delete('/api/instituto/delete/{claveinst}', function(Request $request, Response $response){
    $claveinstituto = $request->getAttribute('claveinst');

    $sql = "DELETE FROM instituto WHERE claveinst = $claveinstituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Actividad complementaria eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//departamentos
$app->get('/api/dep', function(Request $request, Response $response){
    
    $sql = "select * from departamento";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $dep = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($dep);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});

// Obtener un departamento por clave departemento
$app->get('/api/dep/{Clave_departamento}', function(Request $request, Response $response){
    $clavedep = $request->getAttribute('Clave_departamento');

    $sql = "SELECT * FROM departamento WHERE Clave_departamento = $clavedep";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $dep = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($dep);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar departamento
$app->post('/api/dep/add', function(Request $request, Response $response){
    $clavedep = $request->getParam('Clave_departamento');
    $nombredep = $request->getParam('nombre_departamento');
    $trabajadorfc = $request->getParam('trabajador_RFC_trabajador');
    

    $sql = "INSERT INTO departamento (Clave_departamento, nombre_departamento, trabajador_RFC_trabajador) 
                VALUES (:Clave_departamento, :nombre_departamento, :trabajador_RFC_trabajador)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Clave_departamento',    $clavedep);
        $stmt->bindParam(':nombre_departamento',   $nombredep);
        $stmt->bindParam(':trabajador_RFC_trabajador',   $trabajadorfc);
      
        $stmt->execute();

        echo '{"notice": {"text": "Departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar insituto
$app->put('/api/dep/update/{Clave_departamento}', function(Request $request, Response $response){
    $clavedep = $request->getParam('Clave_departamento');
    $nombredep = $request->getParam('nombre_departamento');
    $trabajadorfc = $request->getParam('trabajador_RFC_trabajador');
  
    $sql = "UPDATE departamento SET
                Clave_departamento = :Clave_departamento,
                nombre_departamento = :nombre_departamento,
                trabajador_RFC_trabajador = :trabajador_RFC_trabajador
              
            WHERE Clave_departamento = $clavedep";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Clave_departamento',    $clavedep);
        $stmt->bindParam(':nombre_departamento',   $nombredep);
        $stmt->bindParam(':trabajador_RFC_trabajador',   $trabajadorfc);
       

        $stmt->execute();

        echo '{"notice": {"text": "Departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar departamento
$app->delete('/api/dep/delete/{Clave_departamento}', function(Request $request, Response $response){
    $clavedep = $request->getAttribute('Clave_departamento');

    $sql = "DELETE FROM departamento WHERE Clave_departamento = $clavedep";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//solicitud
$app->get('/api/sol', function(Request $request, Response $response){
    //echo "Solicitud";
    $sql = "select * from solicitud";

    try{
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $sol = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($sol);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}'; 
    }
});

// Obtener solicitud por folio
$app->get('/api/sol/{Folio}', function(Request $request, Response $response){
    $folio = $request->getAttribute('Folio');

    $sql = "SELECT * FROM solicitud WHERE Folio = $folio";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $sol = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($sol);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//agregar solicitud
$app->post('/api/sol/add', function(Request $request, Response $response){
    $folio = $request->getParam('Folio');
    $asunto = $request->getParam('Asunto');
    $lugar = $request->getParam('Lugar');
    $fecha = $request->getParam('Fecha');
    $estudiantenumerodecontrol = $request->getParam('Estudiante_Num_control');
    $instructorrfc = $request->getParam('Instructor_RFC');
    $departamentoclave = $request->getParam('Departamento_Clave');
    $institutoclave = $request->getParam('Instituto_Clave');

    $sql = "INSERT INTO solicitud (Folio, Asunto, Lugar, Fecha, Estudiante_Num_control, Instructor_RFC, Departamento_Clave, Instituto_Clave)
                 VALUES (:Folio, :Asunto, :Lugar, :Fecha, :Estudiante_Num_control, :Instructor_RFC, :Departamento_Clave, :Instituto_Clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Folio',                      $folio);
        $stmt->bindParam(':Asunto',                     $asunto);
        $stmt->bindParam(':Lugar',                      $lugar);
        $stmt->bindParam(':Fecha',                      $fecha);
        $stmt->bindParam(':Estudiante_Num_control',     $estudiantenumerodecontrol);
        $stmt->bindParam(':Instructor_RFC',             $instructorrfc);
        $stmt->bindParam(':Departamento_Clave',         $departamentoclave);
        $stmt->bindParam(':Instituto_Clave',            $institutoclave);

        $stmt->execute();

        echo '{"notice": {"text": "Solicitud agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar solicitud
$app->put('/api/sol/update/{Folio}', function(Request $request, Response $response){
    $folio = $request->getParam('Folio');
    $asunto = $request->getParam('Asunto');
    $lugar = $request->getParam('Lugar');
    $fecha = $request->getParam('Fecha');
    $estudiantenumerodecontrol = $request->getParam('Estudiante_Num_control');
    $instructorrfc = $request->getParam('Instructor_RFC');
    $departamentoclave = $request->getParam('Departamento_Clave');
    $institutoclave = $request->getParam('Instituto_Clave');

    $sql = "UPDATE solicitud SET
                Folio                   = :Folio,
                Asunto                  = :Asunto,
                Lugar                   = :Lugar,
                Fecha                   = :Fecha,
                Estudiante_Num_control  = :Estudiante_Num_control,
                Instructor_RFC          = :Instructor_RFC,
                Departamento_Clave      = :Departamento_Clave,
                Instituto_Clave         = :Instituto_Clave
           
                     WHERE Folio = $folio";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':Folio',                      $folio);
        $stmt->bindParam(':Asunto',                     $asunto);
        $stmt->bindParam(':Lugar',                      $lugar);
        $stmt->bindParam(':Fecha',                      $fecha);
        $stmt->bindParam(':Estudiante_Num_control',     $estudiantenumerodecontrol);
        $stmt->bindParam(':Instructor_RFC',             $instructorrfc);
        $stmt->bindParam(':Departamento_Clave',         $departamentoclave);
        $stmt->bindParam(':Instituto_Clave',            $institutoclave);

        $stmt->execute();

        echo '{"notice": {"text": "Solicitud actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar solicitud
$app->delete('/api/sol/delete/{Folio}', function(Request $request, Response $response){
    $folio = $request->getAttribute('Folio');

    $sql = "DELETE FROM solicitud WHERE Folio = $folio";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Solicitud eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
