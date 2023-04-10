<?php 
require_once("db-connect.php");
foreach($_POST as $k => $v){
    $_POST[$v] = htmlspecialchars(addslashes($conn->real_escape_string($v)));
}
extract($_POST);
$sql = "INSERT INTO `posts` (`title`, `content`) VALUES ('{$title}', '{$content}')";
$insert = $conn->query($sql);
if($insert){
    echo '<script> alert("Täze habar üstünlikli goşuldy."); location.replace("./") </script>';
}else{
    echo '<script> alert("Gynansakda hatalyk çykdy täzeden synanşyň"); location.replace("./") </script>';
}

$conn->close();
?>
