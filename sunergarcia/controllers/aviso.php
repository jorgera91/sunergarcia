<?php
include_once('../models/class.Aviso.php');

function getInformationAviso($param){
    $Aviso = new Aviso($param);
    $response = $Aviso->getList();
    //print_r($response); die();
    return $response;
}

function getAviso($param){
    $aviso = new Aviso($param['id']);
    return $aviso;
}

function updateAviso($param){
    $aviso = new Aviso($param['id']);
    $aviso -> titulo = $param['titulo'];
    $aviso -> contenido = $param['contenido'];
    $response = $aviso->update();
    return $response;
}

function insertAviso($param){
    $aviso = new Aviso(NULL);
    $aviso -> titulo = $param['titulo'];
    $aviso -> contenido = $param['contenido'];
    $response = $aviso->insert();
    return $response;
}

function deleteAviso($param){
    $aviso = new Aviso($param['id']);
    $response = $aviso->delete();
    return $response;
}

if (isset($_POST["method"])) {
    if (!class_exists('SSWebService')) {
        include_once('../models/class.sswebservice.php');
    }
    $server = new SSWebService;
    $server->initialize();

    $server->register("getInformationAviso");
    $server->register("getAviso");
    $server->register("updateAviso");
    $server->register("deleteAviso");
    $server->register("insertAviso");


    $method = isset($_POST["method"]) ? $_POST["method"] : "";
    $param = isset($_POST["param"]) ? $_POST["param"] : "";
    $stripSlashes = isset($_POST["stripSlashes"]) ? $_POST["stripSlashes"] : true;

    $server->serve($method, $param, $stripSlashes);
}