<?php
echo $action = $_REQUEST['action'];

parse_str($_REQUEST['dataform'], $hasil); 
echo 'username: ' . $hasil['username']; 
echo 'firstname : ' . $hasil['firstname'];
echo 'lastname  : ' . $hasil['lastname'];
echo 'email  : ' . $hasil['email'];
echo 'address  : ' . $hasil['address'];

if($action == 'create')
	$syntaxsql = "insert into tbl_user values (null,'$hasil[username]','$hasil[firstname]', '$hasil[lastname]', '$hasil[email]', 
	'$hasil[address]',now())";
elseif($action == 'update')
	$syntaxsql = "update tbl_user set username = '$hasil[username]', firstname = '$hasil[firstname]', lastname = '$hasil[lastname]', 
	email = '$hasil[email]', address ='$hasil[adress]'";
elseif($action == 'delete')
	$syntaxsql = "delete from tbl_user where username = '$hasil[username]'";
elseif($action == 'read')
	$syntaxsql = "select * from tbl_user";
	
//eksekusi syntaxsql 
$conn = new mysqli("localhost","root","","coba"); //dbhost, dbuser, dbpass, dbname
if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}else{
  echo "Database connected. ";
}
//create, update, delete query($syntaxsql) -> true false
if ($conn->query($syntaxsql) === TRUE) {
	echo "Query $action with syntax $syntaxsql suceeded !";
}
elseif ($conn->query($syntaxsql) === FALSE){
	echo "Error: $syntaxsql" .$conn->error;
}
//khusus read query($syntaxsql) -> semua associated array
else{
	$result = $conn->query($syntaxsql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		echo "<table id='tresult' class='table table-striped table-bordered'>";
		echo "<thead><th>username</th><th>firstname</th><th>lastname</th><th>email</th><th>address</th></thead>";
		echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>".$row['username']."</td><td>". $row['firstname']."</td><td>". $row['lastname']."</td><td>". $row['email']."</td>
			<td>". $row['address']."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
$conn->close();

?>