<html>
<head>
<style type="text/css">
body {
	font-size: .9em;
}

td {
	font-size: .9em;
}
</style>
</head>
<body bgcolor="#cccccc">

<table border="0" width="100%" rowspacing="0" colspacing="0">
<tr>
<td align="left" valign="top">

<?php

define("LF","\r\n");
$myData = $_GET['info'];

echo "<b>Time :</b>".date("H:i:s").LF;
echo "<br>".LF;

$decodedData = base64_decode($myData);
$Data = unserialize($decodedData);
	
if (is_array($Data)>0)
{
		
	echo "<b>Template :</b>".$Data['TemplateName'].LF;
	echo "<br>".LF;
	echo "<b>TemplateDir :</b>".$Data['TemplateDir'].LF;
	echo '</td><td align="left" valign="top">'.LF;
		
	echo '<table border="0">'.LF;
		
		
	foreach ($Data['BackTrace'] as $btData)
	{
		echo "<tr>".LF;
		echo "<td>".$btData['File']."</td>".LF;
		echo "<td><b>Function :</b>".$btData['Function']."</td>".LF;
		echo "<td><b>Line :</b>".$btData['Line']."</td>".LF;
		echo "</tr>".LF;
	}
		
	echo "</table>.LF";
}
?>

</td>
</tr>
</table>


</body>

</html>
