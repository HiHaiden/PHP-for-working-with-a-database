<?
    Header("Content-Type: text/html; charset=UTF-8");
?>

<html>
    <link href="style.css" rel="stylesheet" type="text/css">    
    <head><title>Добавление записи в таблицу</title></head>
    <body>
            <header class = "header"><div class = "container">ДОБАВЛЕНИЕ ЗАПИСИ В ТАБЛИЦУ</div></header>
        <div class = "table">
            <form method='post'>
            <div class = "container">

                <table>
                
                    <tr>
                        <th>Номер Дома</th>
                        <th>Номер Квартиры</th>
                        <th>Площадь</th>
                        <th>ФИО</th>
                        <th>Тариф за 1 кв. м.</th>
                        <th>Оплата за 6 месяцев</th>
                    </tr>
                    
                    <tr>
                        <td><div><input class = "short" type = "number" min = '1' name = 'fio'></div></td>
                        <td><div><input class = "short" type = "number" min = '1' name = 'name'></div></td>
                        <td><div><input class = "short" type = "text" name = 'date1'></div></td>
                        <td><div><input class = "short" type = "text" name = 'date2'></div></td>
                        <td><div><input class = "short" type = "text" name = 'str_value'></div></td>
                        <td><div><input id="radio_1" name='str_price' type="radio" value="Да" required=""/>
                        <label for="radio_1">Да</label><br/>
                        <input id="radio_2" name='str_price' type="radio" value="Нет" required=""/>
                        <label for="radio_2">Нет</label><br /></div></td>
                    </tr>
                    
                </table>
            </div>
            <div class = "container">
                <input type='submit' name = 'add' value='Добавить'>
            </form>
            <?php
                # Добавление записи в таблицу
                if(!empty($_POST['add'])){
                    $check = true;

                    if($_POST['fio'] <= 0){echo "<div class = badinfo>Без пустых домов.</div>";$check = false;}
                    if($_POST['name'] <= 0){echo "<div class = badinfo>Без пустых квартир.</div>";$check = false;}
                    if($_POST['str_price'] == ''){echo "<div class = badinfo>Надо нажать кнопку.</div>";$check = false;}
                    if($_POST['date1'] == ''){echo "<div class = badinfo>По нормальному площадь.</div>";$check = false;}
                    if($_POST['date2'] == ''){echo "<div class = badinfo>Имеем имя.</div>";$check = false;}
                    if($_POST['str_value'] == ''){echo "<div class = badinfo>Имеем тариф.</div>";$check = false;}

                    if($check == true){
								$mysqli = mysqli_connect('127.0.0.1', 'mysql' , 'mysql', 'laba3');
                        if($mysqli == true){
                            $sql = 'INSERT INTO kvart (`dom`,`kv`,`pl`,`fio`,`tarif`,`month`) VALUES ("' . $_POST['fio'] . '","' . $_POST['name'] . '","' . $_POST['date1'] . '","' . $_POST['date2'].'","' . $_POST['str_value'] . '","' . $_POST['str_price'] . '")';
                            $result = mysqli_query($mysqli,$sql);
                            if($result == true){echo "<div class = goodinfo>Запись успешно добавлена</div>";}else{echo "<div class = badinfo>Ошибка запроса</div>";}
                        }
                        else{
                            echo "<div class = badinfo>Ошибка при подключении к базе данных</div>";
                        }
                           
                    }     
                }
?>
			</div>
            <div class = "container"><a class = "return" href="index.php">Вернуться назад</a></div>
        </div>
    </body>
</html>