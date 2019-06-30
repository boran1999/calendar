<?php

include "flash.php";

class formclass{

    public $name;
    public $place;
    public $date;
    public $time;
    public $t;
    public $p;
    public $comm;
    public $soglras;
    protected $_pdo;
    public $table='tasks';
    public $pod;

    public $type = [
    1 => 'Дело',
    2 => 'Встреча',
    3 => 'Звонок',
  ];

   public $duration = [
    1 => '5_минут',
    2 => '15_минут',
    3 => '30_минут',
    4 => '1_час',
    5 => '2_час',
    6 => '3_час',
    7 => 'Весь_день',
  ];

    protected $errors = [];

    public function data_insert(){
        if (!empty($_POST)) { 
            $this->name = isset($_POST['name']) ? trim($_POST['name']) : null; 
            $this->place = isset($_POST['place']) ? trim($_POST['place']) : null; 
            $this->date = isset($_POST['date']) ? trim($_POST['date']) : null; 
            $this->time = isset($_POST['time']) ? trim($_POST['time']) : null; 
            $this->t = isset($_POST['type']) ? trim($_POST['type']) : null; 
            $this->p = isset($_POST['duration']) ? trim($_POST['duration']) : null; 
            $this->comm = isset($_POST['comm']) ? trim($_POST['comm']) : null; 
            $this->soglras = isset($_POST['jel']) ? 'yes' : 'no'; 
            $this->pod = isset($_POST['pod']) ? 1 : 0; 
        }
    }

    public function has_errors(){
        return ! empty($this->errors);
    }

    public function validate(){
        if (!empty($_POST)) { 
            if (empty($this->name))
            {
                $this->errors['name'] = 'Не введено имя';
                echo $this->errors['name']."<br>";
            }
            if (empty($this->date))
            {
                $this->errors['date'] = 'Не введена дата';
                echo $this->errors['date']."<br>";
            }
            if (!$this->pod)
            {
                $this->errors['pod'] = 'Данные не подтверждены';
                echo $this->errors['pod']."<br>";
            }
        }
        return ! $this->has_errors();
    }

    public function get_pdo(){
        if (empty($this->_pdo)){
            $this->_pdo = new PDO('mysql:host=localhost;dbname=myform','root',''); 
        }
        return $this->_pdo;
    }

     public function sqlsave(){
        if ($this->validate()){
            $sql = $this->get_pdo()->prepare('INSERT INTO `'.$this->table.'` (`name`,`type`,`place`,`date`,`time`,`duration`,`comment`,`done`) VALUES (?,?,?,?,?,?,?,?);');
            $sql->execute(array($this->name,$this->t,$this->place,$this->date,$this->time,$this->p,$this->comm,$this->soglras));
            return $sql->rowCount() === 1;
        }
        return false;
    }

    public function ins_table(){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'`;');
        $sql->execute();
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

    public function sql_done_tasks($idd){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` WHERE done=?;');
        $sql->execute(array($idd));
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

    public function prosrochka(){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` WHERE (curdate()>`date`) or (curtime()>`time` and curdate()=`date`);');
        $sql->execute();
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

     public function nepr(){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` WHERE (curdate()<`date` and done=?) or (curdate()=`date` and curtime()<`time` and done=?);');
        $sql->execute(array('no','no'));
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

     public function day_tasks($idd){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` WHERE `date`= date_add(curdate(), interval ? day) and done=?;');
        $sql->execute(array($idd, 'no'));
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

     public function tasks_by_day($idd){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` WHERE `date`=? and done=?;');
        $sql->execute(array($idd,'no'));
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }

    public function nw($idd){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'` where year(date) = year(now()+interval ? day) and week(date, 1) = week(now()+interval ? day, 1);');
        $sql->execute(array($idd,$idd));
        while ($object = $sql->fetchObject(static::class)){
            $str=$object->time!='00:00:00' ? $object->time : 'н/y';
            echo "<tr><td>".$object->done."</td><td>".$this->type[$object->type]."</td><td><a href='form.php?id=$object->id'>".$object->name."</a></td><td>".$object->place."</td><td>".$object->date."</td><td>".$str."</td><td>".$object->comment."</td></tr>";
        }
    }


    public function ins_fromdb($idd){
        $sql = $this->get_pdo()->prepare('SELECT * FROM `'.$this->table.'`WHERE `id`='.$idd.';');
        $sql->execute();
        $object = $sql->fetchObject(static::class);
        $_POST['name']=$object->name;
        $_POST['type']=$object->type;
        $_POST['place']=$object->place;
        $_POST['date']=$object->date;
        $_POST['time']=$object->time;
        $_POST['duration']=$object->duration;
        $_POST['comm']=$object->comment;
        $_POST['soglras']=$object->done;      
    }

    public function sqlupd($idd){
            $this->data_insert();
            if($this->validate()){
                $sql = $this->get_pdo()->prepare('UPDATE `'.$this->table.'` set `name`=?, `type`=?, `place`=?, `date`=?, `time`=?, `duration`=?, `comment`=?, `done`=? WHERE `id`=? limit 1;');
                $sql->execute(array($this->name,$this->t,$this->place,$this->date,$this->time,$this->p,$this->comm,$this->soglras,$idd));
                header('Location: /myform');
                return true;
            }
            return false;
    }

}
