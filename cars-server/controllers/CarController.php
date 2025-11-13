<?php
include("../models/Car.php");
include("../connection/connection.php");
include("../services/ResponseService.php");

function getCarByID(){
    global $connection;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        echo ResponseService::response(500, "ID is missing");
        return;
    }

    $car = Car::find($connection, $id);
    echo ResponseService::response(200, $car->toArray());
    return;
}

function getCars(){
    global $connection;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $id);

        if($car){
            echo ResponseService::response(200, $car->toArray());
        }else{
            echo ResponseService::response(404, "Car not found");
        }
    } else {
        $cars = Car::findAll($connection);
        $cars_array = [];

        for ($i = 0; $i < count($cars); $i++) {
            $cars_array[] = $cars[$i]->toArray();
            }

        echo ResponseService::response(200, $cars_array);
    }
}



//getCarById();
getCars();

//ToDO: 
//transform getCarByID to getCars()
//if the id is set? then we retrieve the specific car 
// if no ID, then we retrieve all the cars


?>