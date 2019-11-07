<?php

//Write nodes to document
function buildNode($node){
    echo $node; 
};


//Create Nav Menu
function createNavMenu(){

    $nodes = '
    <img alt="BeeJee ToDo list" src="/beejee.png"  width="40" height="40">
    <div class="btn-group" role="group">
        <a href="." class="btn btn-primary">Home</a>';
            
    if($_SESSION['admin'] == "admin"){
        $nodes .='
        <form method="post" action="/">
            <button name="btnsnd" value="out" class="btn btn-primary">Log Out</button>
        </form>';
    } else {
        $nodes .='
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
            Log In
            </button>';
    }
    $nodes .='<!-- Button modal Task -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taskModal">
              Add Task
            </button>';
            
    if ($_SESSION['admin'] == "admin"){
    $nodes .='<!-- Button DBErase -->
            <form method="post" action="/">
                <button name="btnsnd" value="erase" class="btn btn-primary rounded-0">Erase Changes</button>
            </form>';
    }
    $nodes .='</div>';
            
    return $nodes;
}

//Create Modal Info Form
function createModalInfo(){
    global $infoArray;
    $nodes = '
            <!-- Modal Info Form -->
            <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                      <div class="modal-body">
                ';
     for ($i=0; $i<count($infoArray); $i++) {
         $nodes .= $infoArray[$i].'<br>';
     }
                      
    $nodes .= '</div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                </div>
              </div>
            </div>';
    return $nodes;
}

//Create Modal Task Form
function createModalTask(){
    global $oneTaskToEdit;
    if (count($oneTaskToEdit)>0) {
        $taskID = $oneTaskToEdit[0];
        $taskName = $oneTaskToEdit[1];
        $taskEmail = $oneTaskToEdit[2];
        $taskText = $oneTaskToEdit[4];
        $taskModerate = $oneTaskToEdit[5];
        if ($oneTaskToEdit[3]) $taskStatus = 'checked="checked"'; 
        
    } else {
        $taskID = '';
        $taskName = '';
        $taskEmail = '';
        $taskStatus = '';
        $taskText = '';
        $taskModerate = '';
    }
    $nodes = '
            <!-- Modal Task Form -->
            <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" action="/" autocomplete="off">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="userName">Name</label>
                          <input name="username" value="'.$taskName.'" type="text" class="form-control" id="userName" placeholder="Name">
                      </div>
                      <div class="form-group">
                          <label for="Email">Email</label>
                          <input name="email"  value="'.$taskEmail.'" type="text" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                          <label for="tasktextarea">Task</label>
                          <textarea name="tasktextarea" class="form-control" id="tasktextarea" rows="3">'.$taskText.'</textarea>
                      </div>
                      <div class="form-check">
                          <input name="taskstate" '.$taskStatus.'" class="form-check-input" type="checkbox" id="taskCheck">
                          <label class="form-check-label" for="taskCheck">
                            Is the task completed?
                          </label>
                      </div>
                      <input name="taskid" value="'.$taskID.'" type="hidden" id="taskid">
                  </div>
                  <div class="modal-footer">
                    <button name="btnsnd" value="task" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>';
    return $nodes;
    
}

//Create Modal LogIn Form
function createModalLogIn(){
            $nodes = '
            <!-- Modal LogIn Form -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Admin Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" action="" autocomplete="off">
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="login">User</label>
                            <input name="login" type="text" class="form-control" id="login" placeholder="User" value="">
                          </div>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button name="btnsnd" value="login" type="submit" class="btn btn-primary">LogIn</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>';
       return $nodes;
}


//Create Pagination
function createPager($l, $t, $p) {
    $countPages = $l/$t;
    $prevPage = $p-1;
    $nextPage = $p+1;

    if ($prevPage<1) $prevPage =1;
    if ($nextPage > ($l/$t+1)) $nextPage =$p;
       if ($_GET['c']) {
            if (!$_GET["o"]) $_GET["o"] = 0;
            $urlPage = '&c='.$_GET['c'].'&o='.$_GET["o"];
    } 

    $nodes = '
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="/?p='.$prevPage.$urlPage.'">Previous</a></li>';
    
    for ($i = 0; $i < $countPages; $i++) {
        $nodes .= '
                <li class="page-item"><a class="page-link" href="/?p='.($i+1).$urlPage.'">'.($i+1).'</a></li>';
    }
    
    $nodes .='
                <li class="page-item"><a class="page-link" href="/?p='.$nextPage.$urlPage.'">Next</a></li>
            </ul>
        </nav>';
    return $nodes;
}

//Create a tasks list
function createList($data) {
    global $taskOnPage;
    $length = count($data);
    $page = 1;
    $pageStart = 0;
    
    if ($_GET['p']) {
        $page = $_GET['p'];
        $urlPage = '&p='.$page;
    } 
    
    $pageStart = ($page-1) * $taskOnPage; 
    
    $nodes = '<div class="row border rounded-lg border-dark bg-light">
                <div class="col-sm-1">
                   <a href="/?c=1&o=0'.$urlPage.'" class="badge badge-primary">&#9650;</a>
                   ID
                   <a href="/?c=1&o=1'.$urlPage.'" class="badge badge-primary">&#9660;</a>
                </div>
                <div class="col-sm-2">
                   <a href="/?c=2&o=0'.$urlPage.'" class="badge badge-primary">&#9650;</a>
                   Name
                   <a href="/?c=2&o=1'.$urlPage.'" class="badge badge-primary">&#9660;</a>
                </div>
                <div class="col-sm-2">
                   <a href="/?c=3&o=0'.$urlPage.'" class="badge badge-primary">&#9650;</a>
                   E-mail
                   <a href="/?c=3&o=1'.$urlPage.'" class="badge badge-primary">&#9660;</a>
                </div>
                <div class="col-sm-2 ">
                   <a href="/?c=4&o=0'.$urlPage.'" class="badge badge-primary">&#9650;</a>
                   Status &#10004;
                   <a href="/?c=4&o=1'.$urlPage.'" class="badge badge-primary"">&#9660;</a>
                </div>
                <div class="col-sm ">
                    Task
                </div>
            </div><form method="POST" action="/">';
            
    for ($i = $pageStart; $i < $pageStart+$taskOnPage & $i < $length; $i++) {
        $nodes .= '<div class="row border rounded-lg border-primary bg-white">
                <div class="col-sm-1">';
                 
        if($_SESSION['admin'] == "admin"){
            $nodes .='
                    <button name="taskID" value="'.$data[$i][0].'" id="ebtn'.$data[$i][0].'" type="submit" class="btn btn-primary btn-sm">
                      '.$data[$i][0].'
                    </button>';
        } else {
            $nodes .=$data[$i][0];    
        }

        
        $nodes .='
                </div>
                <div class="col-sm-2">
                    '.$data[$i][1].'
                </div>
                <div class="col-sm-2">
                    '.$data[$i][2].'
                </div>
                <div class="col-sm-2 ">
                    ';
                if ($data[$i][3]){
                    $nodes .='&#10004; Done';
                }else{
                    $nodes .='&#9674; To Do';
                }
                if ($data[$i][5]) {
                    $nodes .=' (Moderated)';
                }
                $nodes .='</div>
                <div class="col-sm ">
                    '.$data[$i][4].'
                </div>
            </div>';
    } 
    $nodes .= '</form>';
    //Call pagination creator
    if ($length > $taskOnPage) {
        $nodes .= createPager($length, $taskOnPage, $page);    
    }
    return $nodes;    
}


//Create JS
function createJS() {
    global $infoArray, $modal;
    if (count($infoArray)>0) {
        $nodes = 'setTimeout(function(){$("#infoModal").modal("show")}, 400);';
    } else {
        if ($modal) {
            $nodes = 'setTimeout(function(){$("#'.$modal.'").modal("show")}, 400);';
        }
    } 
    return $nodes;
}

?>