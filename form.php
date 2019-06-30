<?php
  function selected( $value, $remember ){
      return $value == $remember ? 'selected' : null;
  }
  include "formclass.php";
  $base = new formclass;
  if(empty($_GET) and !empty($_POST)){
    $base->data_insert();
    if ($base->sqlsave()){
      header('Location: /myform'); 
    }
  }
  if(!empty($_GET) and empty($_POST)){
    $base->ins_fromdb($_GET['id']);
    $base->data_insert();
  }
  if(!empty($_GET) and !empty($_POST)){
    if(isset($_POST['pod'])){
        $base->sqlupd($_GET['id']);
    }
  }
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <h1 align><font color="darkblue">Мой календарь</font></h1>
  <title>task</title>
  <style>
    .inp{
      position: absolute;
      left: 170px;
      width: 20%; 
      background: #E9EFF6; 
    }
    .dat{
      position: absolute;
      left: 170px;
      width: 9%; 
      background: #E9EFF6; 
    }
    .comm{
      position: absolute;
      left: 170px;
      width: 20%; 
      height: 10%;
      background: #E9EFF6; 
    }
    .sub{  
      margin-top: 80px;  
    }
  </style>
 </head>
 <body background="back.png">
  <h2>Новая задача</h2>
  <form action="<?= $_SERVER['REQUEST_URI'];?>" method="POST">
  <p>Название: <input class="inp" placeholder="Название" name="name" value="<?= isset($_POST['name']) ? $_POST['name']:''?>"></p>
  <p>Тип: <select class="inp" name="type" value="<?= isset($_POST['type']) ? $_POST['type']:''?>">
    <optgroup label="Тип">
      <option value="1" <?=selected(1, isset($_POST['type']) ? $_POST['type']:'')?> name="del">Дело</option>
      <option value="2" <?=selected(2, isset($_POST['type']) ? $_POST['type']:'')?> name="meet">Встреча</option>
      <option value="3" <?=selected(3, isset($_POST['type']) ? $_POST['type']:'')?> name="call">Звонок</option>
    </optgroup>
    </select>
  </p>
  <p>Место: <input class="inp" placeholder="место" name="place" value="<?= isset($_POST['place']) ? $_POST['place']:''?>"></p>
  <p>Дата и время: <input class="dat" type="date" name="date" value="<?= isset($_POST['date']) ? $_POST['date']:''?>">  <input class="dat" style="position: absolute; left: 315px" type="time" name="time" value="<?= isset($_POST['time']) ? $_POST['time']:''?>"></p>
  <p>Продолжительность: <select class="inp" name="duration" >
    <optgroup label="Продолжительность">
      <option value="1" <?=selected(1, isset($_POST['duration']) ? $_POST['duration']:'')?> name="min5">5 минут</option>
      <option value="2" <?=selected(2, isset($_POST['duration']) ? $_POST['duration']:'')?> name="min15">15 минут</option>
      <option value="3" <?=selected(3, isset($_POST['duration']) ? $_POST['duration']:'')?> name="min30">30 минут</option>
      <option value="4" <?=selected(4, isset($_POST['duration']) ? $_POST['duration']:'')?> name="hour1">1 час</option>
      <option value="5" <?=selected(5, isset($_POST['duration']) ? $_POST['duration']:'')?> name="hour2">2 часа</option>
      <option value="6" <?=selected(6, isset($_POST['duration']) ? $_POST['duration']:'')?> name="hour3">3 часа</option>
      <option value="7" <?=selected(7, isset($_POST['duration']) ? $_POST['duration']:'')?> name="day">Весь день</option>
    </optgroup>
    </select>
  </p>
  <p>Комментарий: <textarea class="comm" placeholder="комментарий" name="comm"><?= isset($_POST['comm']) ? $_POST['comm']:''?></textarea></p>
  <p>Выполнил: <input class="sub" type="checkbox" name="jel" value="yes" <?= isset($_POST['soglras']) ? ($_POST['soglras']=='yes' ? 'checked':'') : ''?>></p>
  <p>Подтверждение: <input type="checkbox" name="pod" value="yes"> <input type="submit" value="Cохранить задачу"></p>
  </form>
<div>
</div>
</body>
</html>
