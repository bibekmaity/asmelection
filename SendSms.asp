<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Send SMS</title>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 6.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<link rel="SHORTCUT ICON" href="http://www.geekworkx.com/favicon.ico" type="image/x-icon">

<script language="javascript">
<!--
function SendSMS(){
if (document.msg.mobilenumber.value==""){
alert("Please Enter your Cell No");
document.msg.mobilenumber.focus();
return false;
}
if (isNaN(document.msg.mobile.value)){
alert("Please Enter valid Cell No with country code");
document.msg.mobile.focus();
return false;
}
if (document.msg.Message.value==""){
alert("Please Enter your Message");
document.msg.Message.focus();
return false;
}

}
//-->
</script>
<body>
<br>
<form method="POST" name=msg target="I1" action="http://bulksms.geekworkx.com/WebServiceSMS.aspx" onSubmit="return SendSMS();" >	
<input type=hidden name="User" value="geekworkx">
<input type=hidden name="passwd" value="smsc">
<input type=hidden name="sid" value="demo">
<input type=hidden name="mtype" value="N">
<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF" bordercolor="#FFFFFF">
			<tr>
						
					<td width="14%">
					<p align="right">
					<font face="Arial" size="2"><b>Mobile No</b></font></td>
					<td width="15%">
					<font face="Arial">
					<input type="text" name="mobilenumber" size="20" maxlength=15   value="91<%=Request.QueryString("mno")%>"  style="border: 5px solid #8AC5FF"></font></td>
					<td width="70%">
					<font face="Arial" size="1">Eg: (919854075901)</font></td>
			</tr>
			<tr>
						
					<td width="14%">&nbsp;
					</td>
					<td colspan="2">
					<font color="#FF0000" face="Arial"><b><blink>Do not enter DND 
					Registered Number here. <br>
					This will be a violation of Govt. of India &amp; TRAI rule.</blink></b></font></td>
			</tr>
			<tr>
						
					<td width="14%">
					<p align="right"><font face="Arial" size="2"><b>Message</b></font></td>
					<td colspan="2">
					<font face="Arial">
					<textarea rows="7" cols="40" name="Message" style="border: 5px solid #8AC5FF"></textarea></font></td>
			</tr>
			<tr>
					<td width="14%">&nbsp;</td>
					<td colspan="2">
					<p>
					  <input type="submit" value="Send SMS" name="sms" style="border: 5px solid #8AC5CC;background-color:#8AC5FF" class=but>
					  &nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp; 
                                                                                                    </p>
					<iframe src="about:blank" name=I1 width="1%" frameborder=0 height=27 scrolling=auto></iframe>
					</td>
</form>					
			</tr>
			<tr>
					<td width="14%">&nbsp;</td>
					<td colspan="2">&nbsp;
					</td>
			</tr>
		</table>
&nbsp;
</body>

</html>