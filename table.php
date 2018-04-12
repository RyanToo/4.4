<?php
$connect = mysqli_connect("localhost", "login", "root", "I_I");

if (isset($_GET['into'])) {
	$table = $_GET['into'];
}

if (!empty($_POST)) {
 foreach ($_POST as $key => $value) {
  if ($key[0] === 'd' && $value !== '') {
	$i = substr($key, 1);
		mysqli_query($connect, 'alter table '.$table.' drop column '.$i);
		header('Location: table.php?into='.$table);
		}
		  if ($key != 'type' && $key[0] === 't' && $value != '' && $_POST['type'] != '') {
			$i = substr($key, 1);
			mysqli_query($connect, 'alter table '.$table.' modify '.$i.' '.$_POST['type'].' not_null');
			header('Location: table.php?into='.$table);
		}

		if ($key !== 'new_name' && $key[0] === 'n' && $value != '' && $_POST['new_name'] != '') {
			$i = substr($key, 1);
			$types = explode("&", $i);
			mysqli_query($connect, 'alter table '.$table.' change '.$types[0].' '.$_POST['new_name'].' '.$types[1]);
		}
	}
}
$type_list = ['INT', 'VARCHAR(255)', 'TEXT'];

$sql = 'describe '.$table;
$res = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Таблица <?php echo $table ?></title>
	<style>
		table {
			margin-top: 5px;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			border: 1px solid grey;
		}
	</style>
</head>
<body>
 <h1>Таблица <?php echo $table ?></h1>
  <form action="" method="post">
	<table>
	 <tr style="background-color: #eeeeee">
		<td>Название</td>
		<td>Тип</td>
	 </tr>
<?php while ($data = mysqli_fetch_array($res)) { ?>
 <tr>
 <td><?php echo $data['Field'] ?></td>
 <td><?php echo $data['Type'] ?></td>
 <td style="border: none"><input type="submit" name="<?= 'd'.$data['Field']; ?>" value="Удалить"></td>
 <td style="border: none">
	<form action="" method="post">
		<select name="type">
		 <option></option>
<?php for ($i = 0; $i < count($type_list); $i++) { ?>
		<option><?php echo $type_list[$i]; ?></option>
		 <?php } ?>
		 </select>
			<br>
			<input type="submit" name="<?= 't'.$data['Field']; ?>" value="Изменить тип">
			</form>
		</td>
			<td style="border: none">
				<form action="" method="post">
				<input type="text" name="new_name"><br>
				<input type="submit" name="<?= 'n'.$data['Field'].'&'.$data['Type']; ?>" value="Изменить название">
				</form>
				</td>
			</tr>
			<?php } ?>
		</table>
	</form>
	<a href="index.php">Вернуться к списку таблиц</a>
</body>
</html>