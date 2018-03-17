<?php

require_once("libs/class.Conexion.BD.php");

function time_elapsed($secs) {
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
    );

    foreach ($bit as $k => $v)
        if ($v > 0)
            $ret[] = $v . $k;

    return join(' ', $ret);
}

function cargarEspecies($conn) {

    $sql = "select * from especies order by nombre asc";
    $conn->consulta($sql);
    $especies = $conn->restantesRegistros();



    return $especies;
}

function cargarBarrios($conn) {

    $sql = "select * from barrios order by nombre asc";
    $conn->consulta($sql);
    $barrios = $conn->restantesRegistros();

    return $barrios;
}

function cargarPaginacionSinFiltro($conn, $pagina, $elementosPorPagina) {


    $sql = "select count(*) as cantidad from publicaciones";

    $conn->consulta($sql);

    $res = $conn->siguienteRegistro();

    $cantidadPaginas = (int) $res["cantidad"];

    $cantidadPaginas = ceil($cantidadPaginas / $elementosPorPagina);


    $anterior = $pagina - 1 < 1 ? 1 : $pagina - 1;
    $siguiente = $pagina + 1 > $cantidadPaginas ? $cantidadPaginas : $pagina + 1;



    $sql = "select * from publicaciones order by id desc limit :offset, :cantidad";

    $param = array(
        array("offset", ($pagina - 1) * $elementosPorPagina, "int"),
        array("cantidad", $elementosPorPagina, "int"),
    );

    $conn->consulta($sql, $param);

    $publicaciones = $conn->restantesRegistros();



    $paginacion = array();

    $paginacion[] = array("p" => 1, "texto" => "&lt;&lt;");
    $paginacion[] = array("p" => $anterior, "texto" => "&lt;");

    for ($i = 1; $i <= $cantidadPaginas; $i++) {
        $paginacion[] = array("p" => $i, "texto" => "" . $i, "sel" => ($pagina == $i));
    }

    $paginacion[] = array("p" => $siguiente, "texto" => "&gt;");
    $paginacion[] = array("p" => $cantidadPaginas, "texto" => "&gt;&gt;");

    $resultado = array();
    $resultado['paginacion'] = $paginacion;
    $resultado['publicaciones'] = $publicaciones;


    return $resultado;
}

function getRazasPorEspecie($conn, $especieId) {
    $sql = "select * from razas where especie_id = :especie_id";

    $param = array(
        array("especie_id", $especieId, "int"),
    );

    $conn->consulta($sql, $param);
    $razas = $conn->restantesRegistros();
    return $razas;
}

function cargarPaginacionConFiltro($conn, $pagina, $elementosPorPagina, $filtros) {
    

    $conditions = "";
    $hasOneAdded = false;
    if ($filtros['tipo'] !== "0") {
        $hasOneAdded = true;
        $conditions .= " tipo = '" . $filtros['tipo']."'";
    }
    if ($filtros['especie'] !== "0") {
        if ($hasOneAdded) {
            $conditions .= " AND ";
        } else {
            $hasOneAdded = true;
        }
        $conditions .= " especie_id = " . $filtros['especie'];
    }
    if ($filtros['barrio'] !== "0") {
        if ($hasOneAdded) {
            $conditions .= " AND ";
        } else {
            $hasOneAdded = true;
        }
        $conditions .= " barrio_id = " . $filtros['barrio'];
    }
    if ($filtros['raza'] !== "0") {
        if ($hasOneAdded) {
            $conditions .= " AND ";
        } else {
            $hasOneAdded = true;
        }
        $conditions .= " raza_id = " . $filtros['raza'];
    }
    if ($filtros['palabras'] !== "") {
        if ($hasOneAdded) {
            $conditions .= " AND ";
        } else {
            $hasOneAdded = true;
        }
        $conditions .= " ( titulo LIKE '%" . $filtros['palabras']. "%' OR descripcion LIKE '%". $filtros['palabras']. "%')";
    }

    
    if ($conditions!== ""){
        $sql = "select count(*) as cantidad from publicaciones where " . $conditions;
    }else{
        $sql = "select count(*) as cantidad from publicaciones ";
    }
    
    



    $conn->consulta($sql);

    $res = $conn->siguienteRegistro();

    $cantidadPaginas = (int) $res["cantidad"];

    $cantidadPaginas = ceil($cantidadPaginas / $elementosPorPagina);


    $anterior = $pagina - 1 < 1 ? 1 : $pagina - 1;
    $siguiente = $pagina + 1 > $cantidadPaginas ? $cantidadPaginas : $pagina + 1;


    if ($conditions!=""){
        $sql = "select * from publicaciones where " . $conditions . " order by id desc limit :offset, :cantidad";
    }else{
        $sql = "select * from publicaciones order by id desc limit :offset, :cantidad";
    }

    $param = array(
        array("offset", ($pagina - 1) * $elementosPorPagina, "int"),
        array("cantidad", $elementosPorPagina, "int"),
    );

    $conn->consulta($sql, $param);

    $publicaciones = $conn->restantesRegistros();



    $paginacion = array();

    $paginacion[] = array("p" => 1, "texto" => "&lt;&lt;");
    $paginacion[] = array("p" => $anterior, "texto" => "&lt;");

    for ($i = 1; $i <= $cantidadPaginas; $i++) {
        $paginacion[] = array("p" => $i, "texto" => "" . $i, "sel" => ($pagina == $i));
    }

    $paginacion[] = array("p" => $siguiente, "texto" => "&gt;");
    $paginacion[] = array("p" => $cantidadPaginas, "texto" => "&gt;&gt;");

    $resultado = array();
    $resultado['paginacion'] = $paginacion;
    $resultado['publicaciones'] = $publicaciones;


    return $resultado;
}

function nuevaPregunta($conn, $idPublicacion, $texto) {
    $conn->conectar();

    $param = array(
        array("id_publicacion", $idPublicacion, "int"),
        array("texto", $texto, "string"),
        array("usuario_id", $_SESSION['user']['id_usuario'], "int"),
    );

    $sql = "insert into preguntas(id_publicacion, texto, usuario_id) values(:id_publicacion, :texto, :usuario_id)";

    $conn->consulta($sql, $param);

    if ($conn->ultimoIdInsert() > 0) {
        $respuesta['status'] = "ok";
        echo json_encode($respuesta);
    } else {
        $mensaje = "No se pudo guardar la pregunta";
    }

    $conn->desconectar();
}


function nuevaPublicacion($conn, $tipo, $especieId, $razaId, $barrioId, $titulo, $descripcion){
    $conn->conectar();

    $param = array(
        array("tipo", $tipo, "string"),
        array("especie_id", $especieId, "int"),
        array("raza_id", $razaId, "int"),
        array("barrio_id", $barrioId, "int"),
        array("titulo", $titulo, "string"),
        array("abierto", 1, "bool"),
        array("descripcion", $descripcion, "string"),
        array("usuario_id", $_SESSION['user']['id_usuario'], "int"),
    );

    $sql = "insert into publicaciones(tipo, especie_id, raza_id, barrio_id, titulo, abierto, descripcion, usuario_id) values(:tipo, :especie_id, :raza_id, :barrio_id, :titulo, :abierto, :descripcion, :usuario_id)";

    $conn->consulta($sql, $param);

    if ($conn->ultimoIdInsert() > 0) {
        $respuesta['status'] = "ok";
        echo json_encode($respuesta);
    } else {
        $mensaje = "No se pudo guardar la pregunta";
    }

    $conn->desconectar();
}

function cargarPublicacionesPorEspecie($conn) {

    $sql = "SELECT e.nombre, count(e.id) as cantidad from especies e, publicaciones p where p.especie_id = e.id group by p.especie_id ";
    $conn->consulta($sql);
    $publicacionesPorEspecie = $conn->restantesRegistros();

    return $publicacionesPorEspecie;
}


function cargarPublicacionesPorAbierto($conn) {

    $resultado = array();
    
    $sql = "SELECT COUNT( * ) AS cantidad FROM publicaciones WHERE abierto =1 ";
    $conn->consulta($sql);
    $publicacionesPorAbierto = $conn->restantesRegistros();
    
    while (list($clave, $valor) = each($publicacionesPorAbierto)) {
           $resultado['abierto'] = $publicacionesPorAbierto[$clave]['cantidad'];
    }
    reset($publicacionesPorAbierto);
    $sql = "SELECT COUNT( * ) AS cantidad FROM publicaciones WHERE abierto = 0";
    $conn->consulta($sql);
    $publicacionesCerrado = $conn->restantesRegistros();
    while (list($clave, $valor) = each($publicacionesCerrado)) {
           $resultado['cerrado'] = $publicacionesCerrado[$clave]['cantidad'];
    }
    reset($publicacionesCerrado);
    
    
    return $resultado;
}

function cargarPublicacionesPorExitoso($conn) {

    $resultado = array();
    
    $sql = "SELECT COUNT( * ) AS cantidad FROM publicaciones WHERE exitoso =1 ";
    $conn->consulta($sql);
    $publicacionesPorExitoso = $conn->restantesRegistros();
    
    while (list($clave, $valor) = each($publicacionesPorExitoso)) {
           $resultado['exitosas'] = $publicacionesPorExitoso[$clave]['cantidad'];
    }
    reset($publicacionesPorExitoso);
    $sql = "SELECT COUNT( * ) AS cantidad FROM publicaciones WHERE exitoso is NULL";
    $conn->consulta($sql);
    $publicacionesNoExitosas = $conn->restantesRegistros();
    while (list($clave, $valor) = each($publicacionesNoExitosas)) {
           $resultado['noExitosas'] = $publicacionesNoExitosas[$clave]['cantidad'];
    }
    reset($publicacionesNoExitosas);
    
    
    return $resultado;
}


