<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/stylesheet2">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
.center {
	margin: auto;
	width: 50%;
	border: 5px solid white;
	padding: 10px;
}

th{
	background-color: #804ba6;
}
table{
	font-size:0.9em;
}
#back_button{
	margin-left:50em;
}

</style>
<body>
<img src="images/print.jpeg" onclick="printFunction()" style="margin-top: 2em;margin-left: 90em; width: 4em ;height: 4em">
<!-- <table border="1" class="center">
	<tr>
		<th><h3>Subject</h3></th>
		<th><h3>Appeared</h3></th>
		<th><h3>Above 48</h3></th>
		<th><h3>Btw 32 n 48</h3></th>
		<th><h3>Pass</h3></th>
		<th><h3>Fail</h3></th>
		<th><h3>Percentage</h3></th>

	</tr> -->
	<?php
	$br="";
	$sem="";
	$shft="";
	$date="";
	if (isset($_POST['submit']))
	{
		$br=$_POST['branch'];
		$sem=$_POST['semester'];
		$shft=$_POST['shift'];
		$date=$_POST['e_date'];

	}

	$conn=mysqli_connect("localhost","root", "","project");

	if($conn -> connect_error)
	{
		die("Connection error".$conn -> connect_error);
	};

	$initial_check="SELECT S1WMS FROM project WHERE BRANCH='$br' AND SEMESTER='$sem' AND SHIFT='$shft'and NOT S1WMS='ABS' AND E_DATE='$date' ";
	$initial_res=$conn-> query($initial_check);
	$var1=$initial_res->num_rows;
	if($var1==0)
	{
		echo "<h3 style='color:white;' align='center'>NO RESULT FOR THE SELECTED OPTIONS<BR>TRY AGAIN WITH VALID OPTIONS</h3>";
		echo "<a href='html/start.html' id='back_button'><button type='button' class='btn btn-secondary'>Go Back</button></a>";
	}

else
{
	echo "<table border='1' class='center'>";
	echo "<tr><th><h3>Subject</h3></th>";
	echo "<th><h3>Appeared</h3></th>";
	echo "<th><h3>Above 48</h3></th>";
	echo "<th><h3>Btw 32 n 48</h3></th>";
	echo "<th><h3>Pass</h3></th>";
	echo "<th><h3>Fail</h3></th>";
	echo "<th><h3>Percentage</h3></th></tr>";





	$i=0;

	$sub=1;
	while($sub<=5)
	{
		$above_48=0;
		$pass=0;
		$fail=0;
		$bet32_48=0;
		$sub_array[6][5];
		unset($sub_array);
		echo "<tr>";
	 //displaying subject name
		if($br=="T")
		{
			$sub_array= array(
				array("AM3","LD","DSA","DBMS","PC"),
				array("AM4","CN","OS","COA","AT"),
				array("MEP","IP","ADMT","CNS","DLOPT1"),
				array("SEPM","DMBI","CCS","DLOPT2"),
				array("END","IS","AI","DLOPT3","ILOPT1"),
				array("BGA","IOE","DPOPT4","ILOPT2","N/A")

			);
			$br_name="THE DEPARTMENT OF INFORMATION AND TECHNOLOGY ENGINEERING";
		}

		  elseif($br=="C")
		{
			$sub_array= array(
				array("AM3","DLD","DM","ECCF","DS"),
				array("AM4","AOA","COA","CG","OS"),
				array("MP","DBMS","CN","TCS","DLOPT1"),
				array("SE","SPCC","DWM","CSS","DLOPT2"),
				array("DSIP","MCC","AISC","DLOPT3","ILOPT1"),
				array("HMI","DC","DLPOPT4","ILOPT2","N/A")

			);
			$br_name="THE DEPARTMENT OF COMPUTER SCIENCE ENGINEERING";

		}

		elseif($br=="I")
		{
			$sub_array= array(
				array("AM3","AE","T1","DE","ENM"),
				array("AM4","T2","FCS","AI","SCSD","ASP"),
				array("SNS","AOM","CSD","CSC","DLOPT1"),
				array("PIS","IDC","EMD","DSP","ACS"),
				array("IPC","BI","IA","DLOPT3","ILOPT1"),
				array("INSTRU PROJ","N/A","N/A","N/A","N/A")

			);
			$br_name="THE DEPARTMENT OF INSTRUMENTATION ENGINEERING";

		}



		elseif($br=="X")
		{
			$sub_array= array(
				array("AM3","EDC1","DSD","CTN","EIC"),
				array("AM4","EDC2","LIC","SNS","PC"),
				array("MPI","DC","EE","DTSP","DLOPT1"),
				array("MCA","CCN","ARW","IPMV","DLOPT2"),
				array("ME","MCS","OC","DLOPT3","ILOPT1"),
				array("RFD","WN","DLOPT4","ILOPT2","N/A")

			);
			$br_name="THE DEPARTMENT OF ELECTRONICS AND TELECOMMUNICATION ENGINEERING";

		}

		elseif($br=="E")
		{
			$sub_array= array(
				array("AM3","EDC1","DCD","ENAS","EIM"),
				array("AM4","EDC2","MA","DSD","PC"),
				array("MCA","DC","EE","DLIC","BCE","DLOPT1"),
				array("ES","CCN","VLSI","SNS","DLOPT2"),
				array("ISD","PE","DSP","DLOPT3","ILOPT1"),
				array("IOT","AMVLSI","DLOPT4","ILOPT2","N/A")

			);
			$br_name="THE DEPARTMENT OF ELECTRONICS ENGINEERING";

		}

		if($sub==1)
		echo "<h3 align='center'><font color='white'>$br_name</font></h3><br>";
		$arr_sem=$sem-3;
		$arr_sub=$sub-1;
		echo "<td>".$sub_array[$arr_sem][$arr_sub]."</td>";



		$attribute="S".$sub."WMS";

		$sql1="SELECT $attribute FROM project where BRANCH='$br' AND SEMESTER='$sem' AND SHIFT='$shft'and NOT $attribute='ABS' and E_DATE='$date' ";
		$res1=$conn-> query($sql1);

		//res1 is the name of the result of the sql query
		echo "<td>$res1->num_rows</td>";
		//marks above 48
		while ($row=$res1->fetch_assoc()) {
			$cell=$row["$attribute"];
			$marks=0;
			for($i=0;$i<=strlen($cell);$i++)
			{
				if (is_numeric($cell[$i])) {
					$dig=(int)$cell[$i];
					$marks=$marks*10+$dig;
				}
				else
				{
					break;
				}
			}
			if ($marks>48)
			{
				$above_48+=1;
			}
			elseif ($marks>32 && $marks<=48)
			{
				$bet32_48+=1;
			}
			if ($marks>=32) {
				$pass+=1;
			}

		}
		$fail=$res1->num_rows-$pass;
		$pass_percent=($pass/$res1->num_rows)*100;

		echo "<td>$above_48</td>";
		echo "<td>$bet32_48</td>";
		//no of pass students
		echo "<td>$pass</td>";
		echo "<td>$fail</td><td>";
		printf("%.2f",$pass_percent);

		echo "%</td></tr>";
		$sub++;

	}
}

	?>


</table>
<br><br><br>

<div>
<div style="float:left;">
<h3 style="color:white; margin-left:2em">
RESULT ANALYSIS CO-ORDINATOR
</h3>
</div>
<div style="float:right;">
<h3 style="color:white; margin-right:2em">
HEAD OF DEPARTMENT
</h3>
</div>
</div>

</body>
<script>
	function printFunction() {

		window.print();

	}
	</script>
</html>
