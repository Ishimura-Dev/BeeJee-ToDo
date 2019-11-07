<?php
//Initiate validators
$users = 'admin';
$pass = '202cb962ac59075b964b07152d234b70'; //123
$infoArray = []; //Data holder for Notification

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Login Validation
  if ($_POST["btnsnd"] == "login") {  
    if (empty($_POST["login"])) {
        array_push($infoArray, 'User must be filled'); 
    }

    if (empty($_POST["password"])) {
        array_push($infoArray, 'Password must be filled'); 
    } 
  
    if($users == $_POST['login'] AND $pass == md5($_POST['password']))
    {
        $_SESSION['admin'] = $users;
    }else {
        array_push($infoArray, 'Invalid login or password');        
    }
  }
  
  //Log Out session abort
  if ($_POST["btnsnd"] == "out") {
        $_SESSION['admin'] = '';    
  }
  
  //Task Validation
  if ($_POST["btnsnd"] == "task") {
    if (empty($_POST["username"])) {
        array_push($infoArray, 'Username must be filled');
    } 

    if (empty($_POST["email"])) {
        array_push($infoArray, 'Email must be filled');
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        array_push($infoArray, 'Email entered incorrectly');
    }
    
    if (empty($_POST["tasktextarea"])) {
        array_push($infoArray, 'Task must be filled');
    }

    if (empty($_POST["taskid"])) {
        $_POST["taskid"] = "new";
    }
    
    if (empty($_POST["taskstate"])) {
        $_POST["taskstate"] = "0";
    }
    
    //If task Validation is OK, give control to model.php by addTask(...)
    if (count($infoArray)==0) {
        if (($_SESSION['admin'] != "admin") && ($_POST["taskid"]!="new")) {    
            $modal = 'loginModal';
        } else {
            if (addTask($_POST["taskid"], $_POST["username"], $_POST["email"], $_POST["taskstate"], htmlentities($_POST["tasktextarea"], ENT_NOQUOTES,"UTF-8"))){
               array_push($infoArray, 'Task list was Updating');     
            }else {
               array_push($infoArray, 'Database not available');
            }
        }
    } 
  }
  
  //Erase all DB Changes
  if ($_POST["btnsnd"] == "erase") {
        if (eraseDB()) {
            array_push($infoArray, 'Database was Updating <br> Refresh page (F5)');    
        }else {
           array_push($infoArray, 'Database not available');
        }
            
  }
  
  
  
  //triger Tasks Modal window to SHOW on task editing
  if ($_POST["taskID"]) {
    if ($_SESSION['admin'] == "admin"){
        $modal = 'taskModal';  
        getTaskById($_POST["taskID"]);
    } else {
        $modal = 'loginModal';  
    }    
  } 

}

//Pagination "GET" controler "c=" Column in DB; "o=" Order by ASC/DESC;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["c"]) {
        if (!$_GET["o"]) $_GET["o"] = 0;   
        getTasksSorted( $_GET["c"], $_GET["o"]);
    } 
}
?>







