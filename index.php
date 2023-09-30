<?
    Header("Content-Type: text/html; charset=UTF-8");
?>
<html>
	<link href="style.css" rel="stylesheet" type="text/css"> 
	<head><title>Добавление записи в таблицу</title></head>
	<body>
		<header class = "header"><div class = "container">УЧЕТ ВНЕСЕНИЯ КВАРТПЛАТЫ</div></header>  
		<div class = "container">
		<?php
		
			# Функция вывода списка
			function table($value, $key) {
			?>
			<tr>
				<td><?=$value[1]?></td>
				<td><?=$value[2]?></td>
				<td><?=$value[3]?></td> 
				<td><?=$value[4]?></td> 
				<td><?=$value[5]?></td>
				<td><?=$value[6]?></td>
				<td>
					<div class = "action">
						<input class = "edit_del_field" type="button" name="ed_button" value="Редактировать" OnClick="document.forms.ed.edit.value=<?=$key?>; document.forms.ed.submit()">
						<input class = "edit_del_field" type="button"  name="del_button" value="Удалить" OnClick="document.forms.del.dlt.value=<?=$key?>; document.forms.del.submit()">
					</div>
				</td>
			</tr>		
			<?
			}
			
			$mysqli = mysqli_connect('127.0.0.1', 'mysql' , 'mysql', 'laba3');
         					if($mysqli== true){
         		$J = 0;
               $sql = 'SELECT `id`,`dom`,`kv`,`pl`,`fio`,`tarif`,`month` FROM kvart;';
               $result = mysqli_query($mysqli, $sql);
               while($row = mysqli_fetch_array($result)){
               	$data[$J] = $row['id'] . "|" . $row['dom'] . "|" . $row['kv'] . "|" . $row['pl'] . "|". $row['fio'] . "|" . $row['tarif'] . "|" . $row['month'] . "|";
               	$J = $J + 1;
	            }
	               if($result == true){echo "<div class = goodinfo>ТАБЛИЦА ОБНОВЛЕНА &#10003;</div>";}else{echo "<div class = badinfo>Ошибка запроса</div>";}
	            } else {
	               echo "<div class = badinfo>Ошибка при подключении к базе данных</div>";
	            }     

			##### УДАЛЕНИЕ
			if(!empty($_POST['del_action']) && $_POST['del_action'] == 'delete_user') {
				$temp = $data[$_POST['dlt']];
				$temp = explode("|", $temp);
				$sql = 'DELETE FROM kvart WHERE `id` = ' . $temp[0] . ';';
				unset($data[(int)$_POST['dlt']]);
				if(mysqli_query($mysqli, $sql)){echo "<div class = badinfo>Запись удалена.</div> <div class = badinfo>Для обновления нажмите кнопку 'Отмена запроса'.</div>"; }else{echo "<div class = badinfo>Ошибка запроса</div>";}
				unset($_POST['sort_button']);
				unset($_POST['sort_button1']); 
			}
			
			##### Отменить запрос
			if(isset($_POST['unsort_button'])) {
				unset($_POST['sort_button']);
				unset($_POST['sort_button1']);

			}
			##### РЕДАКТИРОВАНИЕ
			if(!empty($_POST['ed_action']) && $_POST['ed_action'] == 'edit_user') {
				if (!empty($_POST['fio']) && !empty($_POST['name']) && !empty($_POST['date']) && !empty($_POST['date2']) && !empty($_POST['str_value']) && !empty($_POST['str_price'])) 
				{
						#Записываем в файл	
						$idd = $data[$_POST['edit']];
						$idd = explode("|", $idd);
						$sql = 'UPDATE kvart SET `dom` = ' . '"' . $_POST['fio'] . '",`kv` = "' . $_POST['name'] .'",`pl` = "' . $_POST['date'] .'",`fio` = "' . $_POST['date2'] .'",`tarif` = "' . $_POST['str_value'] .'",`month` = "' . $_POST['str_price']  .'" WHERE `id` = '.$idd[0].';';
						if(mysqli_query($mysqli,$sql)){
						echo "<div class = goodinfo>Запись успешно редактирована.</div>";}
						$flag = true;
				}
				$J = 0;
               $sql = 'SELECT `id`,`dom`,`kv`,`pl`,`fio`,`tarif`,`month` FROM kvart;';
               $result = mysqli_query($mysqli, $sql);
               while($row = mysqli_fetch_array($result)){
               	$data[$J] = $row['id'] . "|" . $row['dom'] . "|" . $row['kv'] . "|" . $row['pl'] . "|". $row['fio'] . "|" . $row['tarif'] . "|" . $row['month'] . "|";
               	$J = $J + 1;
	            }
				
				$value = $data[$_POST['edit']];
				$value = explode('|', $value);

				if(!isset($flag)){
					$flag = '';
				}

				if($flag == true) {
					$edit = "";
				} else {


				?><div class = "container">
					<form method='post' name='submit'>
					<table>
						<tr><td>Номер Дома</td>
							<td><input type='number' name='fio' min='1' value='<?=(int)$value[1]?>'></td>
						</tr>
						<tr><td>Номер Квартиры</td>
							<td><input type='number' name='name' min='1' value='<?=(int)$value[2]?>'></td>
						</tr>
						<tr><td>Площадь</td>
							<td><input type='text' name='date' value='<?=$value[3]?>'></td>
						</tr>
						<tr><td>ФИО</td>
							<td><input type='text' name='date2' value='<?=$value[4]?>'></td>
						</tr>
						<tr><td>Тариф за 1 кв. м.</td>
							<td><input type='text' name='str_value' value='<?=$value[5]?>'></td>
						</tr>
						<tr><td>Оплата за 6 месяцев</td>
							<td>
						<input id="radio_1" name='str_price' type="radio" value="Да" required=""/>
						<label for="radio_1">Да</label><br/>
						<input id="radio_2" name='str_price' type="radio" value="Нет" required=""/>
						<label for="radio_2">Нет</label><br/>
							</td>
						</tr>
					</table>
						<input type='hidden' name='ed_action' value='edit_user'>
						<input type='hidden' name='edit' value="<?=$_POST['edit']?>">
						<input type='submit' value='Редактировать'>
					</form>
				</div>
		<?php
		}
				if(!isset($edit)){
					$edit = '';
				}
				echo $edit;
			}
		?>
		</div>

		<div class = "table">
			<div class = "container">
			<table>
						<tr>
							<th>Номер Дома</th>
							<th>Номер Квартиры</th>
							<th>Площадь</th>
							<th>ФИО</th>
							<th>Тариф за 1 кв. м.</th>
							<th>Оплата за 6 месяцев</th>
							<th>Действие</th>
						</tr>
			<?php 
							$J = 0;
               $sql = 'SELECT `id`,`dom`,`kv`,`pl`,`fio`,`tarif`,`month` FROM kvart;';
               $result = mysqli_query($mysqli, $sql);
               while($row = mysqli_fetch_array($result)){
               	$data[$J] = $row['id'] . "|" . $row['dom'] . "|" . $row['kv'] . "|" . $row['pl'] . "|". $row['fio'] . "|" . $row['tarif'] . "|" . $row['month'] . "|";
               	$J = $J + 1;
	            }
				# В цикле обходим массив данных
				$i = 0;
				
				foreach( $data as $key => $value):
					
					# Разбиваем строку по |
					$value = explode( "|", $value );

					# Выводим список, проверяются запросы
					if (isset($_POST['sort_button'])) {
						$str_price = $_POST['str_price1'];
						if($str_price == $value[6])
						{
							table($value, $key);
						}
					} 
					else if (isset($_POST['sort_button1'])) {
						if("Нет" == $value[6] && $i !== 10)
						{
							    $i++;
								table($value, $key);
						}
					} else {
						table($value, $key);
					} 

				endforeach; 
			?>
			</table>
			</div>
			<div class = "container">
				<form method="post" name="add" action = "add.php">
					<div><input type="submit" name="add_button" value="Добавить"></div>
				</form>
			</div>
			<div class = "container">
			<form method="post" name="sort">
					<div class = "zagolovok">ЗАПРОСЫ</div>

					<div class = "list">
							<div class="item">Присутствие периода оплаты за 6 месяцев:</div>
							<div class = "item">
							<input id="radio_1" name='str_price1' type="radio" value="Да" />
							<label for="radio_1">Да</label><br/>
							<input id="radio_2" name='str_price1' type="radio" value="Нет" />
							<label for="radio_2">Нет</label><br/>
							</div>
							<div class="item"><input class = "subm_button" type = "submit" name="sort_button" value = "Вывести список таких жильцов"></div>
					</div>
					<div><input class = "subm_button" type = "submit" name="sort_button1" value = "Десять последних жильцов с задолжностью"></div>
					<div><input class = "subm_button1" type="submit"  name="unsort_button" id="otmena" value="Отмена запроса"class = "add_button"></div>
				</form>
			</div>
			<form method="post" name="del">
			<input type="hidden" name="dlt">
			<input type="hidden" name="del_action" value="delete_user">
		</form>
		<form method="post" name="ed">
			<input type="hidden" name="edit">
			<input type="hidden" name="ed_action" value="edit_user">
		</form>
		</div>
	</body>
</html> 