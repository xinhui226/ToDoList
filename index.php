<?php

$database = new PDO(
    'mysql:host=devkinsta_db;
    dbname=TODO_List',
    'root',
    'cD4FYhCb9HPk9bc0'
);

$query = $database->prepare('SELECT * FROM todolists');
$query->execute();

$todolists = $query->fetchAll();

if($_SERVER['REQUEST_METHOD']==='POST'){
    
    if($_POST['action']==='add'){
        $statement=$database->prepare("INSERT INTO todolists (`task`) VALUES (:thetask) ");
        $statement->execute([
            'thetask'=> $_POST['addtask']
        ]);

        header('Location:/');
        exit;
    }

    elseif($_POST['action']==='delete'){
        $statement=$database->prepare("DELETE FROM todolists where id=:tid");
        $statement->execute([
           'tid'=>$_POST['taskid']
        ]);

        header('Location:/');
        exit;
    }

    elseif($_POST['action']==='update'){

      if($_POST['is_complete']==0){
        $statement=$database->prepare("UPDATE todolists SET `is_complete`=1 where id=:tid");
      }elseif($_POST['is_complete']==1){
        $statement=$database->prepare("UPDATE todolists SET `is_complete`=0 where id=:tid");
      }

        $statement->execute([
          'tid'=>$_POST['taskid']
        ]);

        header('Location:/');
        exit;
    }
}

// var_dump($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TODO App</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
/* 
      .strike{
        color:lightgrey;
        text-decoration: line-through;
      } */
    </style>
  </head>
  <body>
    <div
      class="card rounded shadow-sm"
      style="max-width: 500px; margin: 60px auto;"
    >
      <div class="card-body">
        <h3 class="card-title mb-3">My Todo List</h3>
        <ul class="list-group">
            <?php foreach($todolists as $tasks):?>
                <li
            class="list-group-item d-flex justify-content-between align-items-center"
          >

          <?php
        //   if($tasks['is_complete']) {
        //     echo "<h1>complete</h1>";
        //   }else {
        //     echo "<h1>incomplete</h1>";
        //   }
          
          ?>
            <div>
              <div class="d-inline-block">
              <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']?>">
              <input type="hidden" name="action" value="update">
               <input type="hidden" name="taskid" value="<?php echo $tasks['id'] ;?>">
                <input type="hidden" name="is_complete" value="<?php echo $tasks['is_complete'] ;?>">
             <?php if($tasks['is_complete']==1) :?>
              <button class="btn btn-sm btn-success">
                <i class="bi bi-check-square"></i>
              </button>
              <?php else: ?>
                <button class="btn btn-sm btn-light">
                  <i class="bi bi-square"></i>
                  <?php endif;?>    
              </form>
            </div>
            <span class="ms-2">
             <?php echo $tasks['task']; ?>
              </span>
            </div>
            <div>
                <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="taskid" value="<?php echo $tasks['id'] ;?>">
                    <button class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
          </li>
                <?php endforeach;?>
          
          <!-- <li
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            <div>
              <button class="btn btn-sm btn-light">
                <i class="bi bi-square"></i>
              </button>
              <span class="ms-2 text-decoration-line-through">Task 2</span>
            </div>
            <div>
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </li>
          <li
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            <div>
              <button class="btn btn-sm btn-light">
                <i class="bi bi-square"></i>
              </button>
              <span class="ms-2 text-decoration-line-through">Task 3</span>
            </div>
            <div>
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </li> -->
        </ul>
        <div class="mt-4">
          <form class="d-flex justify-content-between align-items-center" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>">
            <input
              type="text"
              class="form-control"
              name="addtask"
              placeholder="Add new item..."
              required
            />
            <input type="hidden" name="action" value="add">
            <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
          </form>
        </div>
      </div>
    </div>

    <!-- <script>
       let check = document.getElementById('checked');
       let list = document.getElementById('deco');

       check.onclick=function(e){
        alert('1');
        console.log(list)
         if(check.checked) {list.style.text-decoration = 'line-through'}
         else if(!check.checked) {list.style.text-decoration = 'none'}
       }
    </script> -->

    <!-- <script>
        let checks = document.getElementsByClassName("check");

        for(let check of checks){
            check.onclick=function(e){
              e.target.parentElement.submit()
            }
        }
    </script> -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
