<head>
<script type="text/javascript" src="Validation.js"></script>

<script language=javascript>
<!--
function go()
{
if(StringValid('Uid',1))
{
myform.action="downloadN.php";
myform.submit();
}
else
alert('Enter Name of District');
}
</script>

<body>
 <?php 
session_start();
 ?> 

<form name="myform" method=post >
Enter Name of Election District&nbsp;<input type=text size=20 maxlength=30 name=Uid id="Uid">
<input type=button name=save onclick=go() value="Proceed" >
</form>
