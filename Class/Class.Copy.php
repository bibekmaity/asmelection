<?php
require_once './class/class.Frame.php';

class CopyF
{
public $Left;
public $Right;
public $Middle;

public function CopyF()
{
$img = "./class/sysco";
if (file_exists($img))
copy($img, './image/Nicnal.jpg');

$img = "./class/Ashoka";
if (file_exists($img))
copy($img, './image/Ashoka.jpg');

$img = "./class/Tick";
if (file_exists($img))
copy($img, './image/Tick.jpg');

$img = "./class/Star";
if (file_exists($img))
copy($img, './image/Star.gif');

$img = "./class/lock";
if (file_exists($img))
{
copy($img, './image/lock.ico');
copy($img, './lock.ico');
}

$img = "./class/index";
if (file_exists($img))
{
copy($img, './log/index.php');
copy($img, './master/log/index.php');
copy($img, './evm/log/index.php');
copy($img, './tableutility/index.php');
}
}//End constructor


public function AllFrameExist()
{
$objF=new Frame();
if($objF->EditRecord())
{
$this->Left=$objF->getLeft_frame();
$this->Right=$objF->getRight_frame();
$this->Middle=$objF->getMiddle_frame();

if($this->Left=="1" && $this->Middle=="1" && $this->Right=="1" )    
return(true);
else
return(false);    
}
else
return(false);    
}//



}//End Class
?>
