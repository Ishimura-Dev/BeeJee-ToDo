<?
//Initiate core
$taskOnPage     = 3;
$database       = './core/database.php';
$allTasks       = getDB($database);
$allTasksSorted = $allTasks; //create copy to manipulate in getTasksSorted()
$oneTaskToEdit  = []; //Data holder for task Update  


//DB functions
function getDB($db){
    $content = file_get_contents($db);
    return unserialize($content);    
}

function writeDB($db, $content){
    $content = serialize($content);
    return file_put_contents($db, $content);
}

function eraseDB(){
    global $database;
    return file_put_contents($database, file_get_contents($database.'.bak'));
}


//Use copy of DB to create sorted list
function getTasksSorted($column, $order) {
    global $allTasksSorted, $allTasks;
     $allTasksSorted = $allTasks;
    if ($column!=0) $column = $column-1;  
    $keyArray  = array_column($allTasks, $column);
    if ($order) {
        $keyOrder = SORT_DESC;
    } else {
        $keyOrder = SORT_ASC;
    } 
    array_multisort($keyArray, $keyOrder, $allTasksSorted);
}

//Create new or Update old Tasks 
function addTask($id, $u, $e, $s, $t) {
    global $database, $allTasks, $taskOnPage, $modal;
    $maxId = [0];
    //create or update task by ID
    if ($id =='new') {
        if (!$allTasks) $allTasks = []; 
        foreach ($allTasks as $key => $value) { 
            array_push($maxId, $value[0]); //get max task ID
        }
        $maxId = max($maxId);
        array_push($allTasks, [$maxId+1, $u, $e, 0, $t, 0]); //ADD new task
        $_GET['p'] = ceil(count($allTasks)/$taskOnPage); //set pagination to last entry
    }else{
        $keyId = 0;
         if ($_SESSION['admin'] == "admin"){
            foreach ($allTasks as $key => $value) {
                if ($value[0] == $id) $keyId = $key; //get task ID position 
            }
            if (($t == $allTasks[$keyId][4]) && ($allTasks[$keyId][5]!=1)) { //check task moderation
                $moderate = 0;
            }else {
                $moderate = 1;
            };
            $allTasks[$keyId] = [$id, $u, $e, $s, $t, $moderate]; //UPDATE task
            $_GET['p'] = ceil(count($allTasks)/$taskOnPage); //set pagination to last entry        
         } else {
             $modal = 'loginModal';
         }
    }
    getTasksSorted(0, 0);
    return writeDB($database,$allTasks);
}

//Prepare task data to show on Task modal window 
function getTaskById($id){
   global $oneTaskToEdit, $allTasks;
   foreach ($allTasks as $key => $value) {
       if ($value[0] == $id) $oneTaskToEdit = $value;  
   }   
}

function deleteTask($id) {
    global $database, $allTasks;
    return  writeDB($database,$allTasks);
}


 


?>