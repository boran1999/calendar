<?php
  include "formclass.php";
  $base = new formclass;
 ?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <h1 align ="center"><font color="darkblue">Мой календарь</font></h1>
  <title>calender</title>
  <style>
    table.til{
    margin: 0 auto;
  }
  .til td{
    width: 5%;
    text-align:center;
    border: 1px solid;
  }
  a{color: black; text-decoration: none;}
  </style>
 </head>
 <body background="back.png">
  <h2 align="center">Список задач</h2>
  <div align="center"><form >
    <button><a href="/myform">Все задачи</a></button>
    <button><a href="/myform?time=npr">Текущие задачи</a></button> 
    <button><a href="/myform?done=yes">Выполненные задачи</a></button> 
    <button><a href="/myform?done=no">Невыполненные задачи</a></button> 
    <button><a href="/myform?time=pr">Просроченные задачи</a></button> 
    <button><a href="/myform?time=today">Задачи на сегодня</a></button> 
    <button><a href="/myform?time=tomorrow">Задачи на завтра</a></button> 
    <button><a href="/myform?time=tw">Задачи на эту неделю</a></button>
    <button><a href="/myform?time=nw">Задачи на следующую неделю</a></button>
   <input type="date" name="datei" value="<?= isset($_POST['datei']) ? $_POST['datei']:''?>">&nbsp<input type="submit" value="получить задачи на эту дату"></form>
    </div>
  </p>
  <table class="til td" border = 1 align="center" width=100%> <tr> 
    <th width=2px><font face="CALIBRI">Выполнил</font></th> 
    <th><font face="CALIBRI">Тип</font></th> 
    <th><font face="CALIBRI">Задача</font></th> 
    <th><font face="CALIBRI">Место</font></th> 
    <th width=100px><font face="CALIBRI">Дата</font></th>
    <th width=100px><font face="CALIBRI">Время</font></th> 
    <th><font face="CALIBRI">Комментарий</font></th> 
  </tr>
  <?php
  if(!empty($_GET)){
    if(isset($_GET['done'])){
      if($_GET['done']=='yes')
        $base->sql_done_tasks($_GET['done']);
      if($_GET['done']=='no')
        $base->sql_done_tasks($_GET['done']);
    }
    if(isset($_GET['time'])){
      if($_GET['time']=='pr')
        $base->prosrochka();
      if($_GET['time']=='npr')
        $base->nepr();
      if($_GET['time']=='today')
        $base->day_tasks(0);
      if($_GET['time']=='tomorrow')
        $base->day_tasks(1);
      if($_GET['time']=='tw')
        $base->nw(0);
      if($_GET['time']=='nw')
        $base->nw(7);
    }
    if(isset($_GET['datei'])){
        $base->tasks_by_day($_GET['datei']);
    }
  }
  if(empty($_GET))
    $base->ins_table();
  ?>
</table>
  <form action="form.php" method="POST">
   <p align="center"><input type="submit" value="Добавить задачу"></p>
  </form>
<div>
</div>
</body>
</html>
