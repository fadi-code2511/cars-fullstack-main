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


function updateCar(){
    global $connection;

    if(!isset($_GET["id"])){
        echo ResponseService::response(400, "Missing ID");
        return;
    }

    $id = $_GET["id"];
    $data = json_decode(file_get_contents("php://input"), true);

    if(!$data){
        echo ResponseService::response(400, "No data to update");
        return;
    }

    if(Car::update($connection, $id, $data)){
        echo ResponseService::response(200, "Car updated successfully");
    } else {
        echo ResponseService::response(500, "Failed to update car");
    }
}


function deleteCar(){
    global $connection;

    if(!isset($_GET["id"])){
        echo ResponseService::response(400, "Missing ID");
        return;
    }

    $id = $_GET["id"];

    if(Car::delete($connection, $id)){
        echo ResponseService::response(200, "Car deleted successfully");
    } else {
        echo ResponseService::response(500, "Failed to delete car");
    }
}

function createCar(){
    global $connection;

    $data = json_decode(file_get_contents("php://input"), true);

    if(!$data){
        echo ResponseService::response(400, "No data received");
        return;
    }

    $new_id = Car::create($connection, $data);

    if($new_id){
        echo ResponseService::response(201, "Car added successfully with ID: " . $new_id);
    } else {
        echo ResponseService::response(500, "Failed to add car");
    }
}

createCar();
//getCarById();
// getCars();
// updateCar();


//ToDO: 
//transform getCarByID to getCars()
//if the id is set? then we retrieve the specific car 
// if no ID, then we retrieve all the cars


?>