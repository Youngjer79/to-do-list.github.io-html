<?php
  $errors = "";

  // connect to the database
  $db = mysqli_connect('localhost', 'root', '', 'todo');

  if(isset($_POST['submit'])){
    $task = $_POST['task']; 
    if(empty($task)) {
      $errors = "You must fill in to-do section";
    } else {
      mysqli_query($db, "INSERT INTO tasks(task) VALUES ('$task')");
      header('location: index.php');
    }
  }

  // delete task
  if(isset($_GET['del_task'])){
    $task = $_GET['del_task'];
    mysqli_query($db, "DELETE FROM tasks WHERE task=$task");
    header('location: index.php');
  }
  $tasks = mysqli_query($db, "SELECT * FROM tasks");
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>To-Do List</title>
	<link rel="stylesheet" href="../assets/css/todo.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div id="container">
  <h1>To-Do List <i class="fas fa-plus"></i></h1>
  <form action="index.php" method="POST">
    <div>
      <input type="text" name="task" placeholder="Add New To-Do" class="task">
      <button type="submit" class="add_btn" name="submit">Add Task</button>
    </div>
    <ul class="items">
       <li class="task"><span><i class="fa fa-trash-alt"></i></span>Do refresher on php</li>
       <li class="task"><span><i class="fa fa-trash-alt"></i></span>Go grocery shopping</li>
    <?php while ($row = mysqli_fetch_array($tasks)){ ?>
        <li class="task done" style="list-style:none;"><span><i class="fa fa-trash-alt delete"><a href="index.php?del_task=<?php echo $row['task'];?>"></a></i></span><?php echo $row['task'];?></li>
    <?php
     } ?>
    </ul> 
  </form>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="assets/js/todos.js"></script>
  
	<script>
	//Check Off Specific Todos By Clicking
$("ul").on("click", "li", "task", function(){
	$(this).toggleClass("completed");
});
//Click on X ro delete Todo
$("ul").on("click", "span", "task", function(event){
	$(this).parent().fadeOut(500,function(){
		$(this).remove();
	});
	event.stopPropagation();
});
$("input[type='text']").keypress(function(event){
	if(event.which === 13){
		//grabbing new todo text from input
		var todoText = $(this).val();
		$(this).val("");
		//create a new li and add to ul
		$("ul").append("<li><span><i class='fa fa-trash-alt'></i></span> " + todoText + "</li>")
	}
});
$(".fa-plus").click(function(){
	$("input[type='text']").fadeToggle();
})
	</script>
</body>
</html>
