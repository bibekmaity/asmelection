<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Parliament Election 2014, Main Menu(NIC ,Nalbari)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
    
 $.ajaxSetup ({   
        cache: false  
 });   
 
//alert('Document Loaded');
//var ajax_load = "<img src='image/ashoka.jpg' alt='loading...' />";   
var ajax_load = "Please Wait, Loading";   
      
//  load() functions   
var loadUrl = "test.php";   
 //$("#res1").click(function(){   
 //$("#myid").html.load(ajax_load).load(loadUrl);   
 //});  

$(window).unload(function() {
  $.ajax({
  url: 'logout.php',async : false
  });
return false;
}); //unload

}); //Ready Function
</script> 



<frameset rows="87%,13%" frameborder="NO" border="1" framespacing="0">
  <frame src="IndexPage.php" name="mainFrame">
  <frameset cols="80%,20%" frameborder="No" border="1" framespacing="0">
  <frameset cols="25%,75%" frameborder="No" border="1" framespacing="0">
   <frame src="left.php" name="leftbottomFrame" scrolling="No" >
  <frame src="footer.php" name="bottomFrame" scrolling="NO" noresize>
 </frameset>
 <frame src="right.php" name="rightbottomFrame" scrolling="yes" >
</frameset>
</frameset>
<noframes>
<body>
<?php
session_start();

 $_SESSION['error']=true;
 $_SESSION['firstlogin']="Y";
 $_SESSION['district']="Nalbari";
 
 
 
 ?>    
    <div id="myid"></div>    
</body></noframes>
</html>
