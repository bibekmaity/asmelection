<html>
	<title>Date Picker</title>
	<script language="JavaScript" src="htmlDatePicker.js" type="text/javascript"></script>
	
<link href="htmlDatePicker.css" rel="stylesheet">
<body>
<form name="frmDatepicker" method="post">
	<input type="text" value="" name="SelectedDate" id="SelectedDate" readonly ><img src="images/calendar.png" align="absmiddle" width="25" height="25" onClick="GetDate(SelectedDate);" alt="Click Here to Pick Date">
	<input type="text" value="" name="SelectedDate1" id="SelectedDate1" readonly >
	DAY1&nbsp;<input type=text size=10 name="Trgdate1" id="Trgdate1"  style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Trgdate1',1)"  onblur="ChangeColor('Trgdate1',2)">
<img src="images/calendar.png" align="absmiddle" width="25" height="25" onClick="GetDate(Trgdate1);" alt="Click Here to Pick Date">

	<input type="submit" name="submit">
</form>
</body>
</html>
<?php
if(isset($_POST['submit'])){
	echo "Picked Date: ".$_POST['SelectedDate'];
}
?>
