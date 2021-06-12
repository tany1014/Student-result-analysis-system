 <!DOCTYPE html>
<html>
<head>
	<title></title>
		<link rel="stylesheet" href="css/stylesheet2.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript">
	function myGraph(){

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light1",
	animationEnabled: false,
	title:{
		text: "Classwise Comparison"
	},
	data: [
	{
		type: "column",
		dataPoints: [
			{ label: title[0],  y: parseFloat(all_sem_subject[0]) },
			{ label: title[1], y: parseFloat(all_sem_subject[1])  },
			{ label: title[2], y: parseFloat(all_sem_subject[2])  },
			{ label: title[3],  y: parseFloat(all_sem_subject[3]) },
			{ label: title[4],  y: parseFloat(all_sem_subject[4])  }
		]
	}
	]
});
chart.render();

}
</script>
</head>
<style>
	.center {
  margin: auto;
  width: 50%;
  border: 5px solid white;
  padding: 10px;
}
table{
	font-size:0.9em;
}
th,td{
	padding:0.2em;
}
.grd{
	font-size: 1.25em;
}
</style>
<body>
<img src="images/print.jpeg" onclick="printFunction()" style="margin-top: 2em;margin-left: 120em; width: 4em ;height: 4em">

<h1 align="center"><font color="white">
	CLASS WISE RESULT ANALYSIS</font>
</h1>
<table border="2" class="center" style="margin-bottom:2em">
	<tr>
		<th><h3>Class</h3></th>
		<TH><h3>Semester</h3></TH>
		<TH><h3>Appeared</h3></TH>
		<TH><h3>Distinction</h3></TH>
		<TH><h3>First class  </h3></TH>
		<TH><h3>Second class</h3></TH>
		<TH><h3>Total pass</h3></TH>
		<TH><h3>Failed</h3></TH>
		<TH><h3>Total Pass %</h3></TH>
	</tr>
<?php
	error_reporting(0);

		if(isset($_POST['submit']))
	{
		$br=$_POST["branch"];
		$e_date=$_POST["e_date"];
	}
	$conn=mysqli_connect("localhost","root","","project");
	// $graph_array[6];
	$graph_array_count=0;
	if ($conn ->connect_error)
	{
		die("connection error".$conn ->connect_error);
	}

		if ($br=='T' || $br=='I')
		{
			$shift=1;
			$span=3;
		}
		elseif ($br=='C' || $br=='E' || $br=='X') {
			$shift=2;
			$span=6;
		}

		if(strpos($e_date,"MAY") !== false)
		{
			$sem_array=array(4,6,8);
		}
		else
		{
			$sem_array=array(3,5,7);
		}

		// -----------------------------------------------------
		if($br=="T")
		{
			$br_name="THE DEPARTMENT OF INFORMATION AND TECHNOLOGY ENGINEERING";
		}

		  elseif($br=="C")
		{
			$br_name="THE DEPARTMENT OF COMPUTER SCIENCE ENGINEERING";

		}
		elseif($br=="I")
		{
			$br_name="THE DEPARTMENT OF INSTRUMENTATION ENGINEERING";

		}



		elseif($br=="X")
		{
			$br_name="THE DEPARTMENT OF ELECTRONICS AND TELECOMMUNICATION ENGINEERING";

		}

		elseif($br=="E")
		{
			$br_name="THE DEPARTMENT OF ELECTRONICS ENGINEERING";

		}


		echo "<h3 align='center'><font color='white'>$br_name</font></h3><br>";
		// ------------------------------------------------------


		function sub_wise($conn,$br,$e_date,$func_sem,$func_shift)
	{
		$sql1="SELECT C_SG_TOTAL FROM project where BRANCH='$br' and E_DATE='$e_date' and SEMESTER='$func_sem' and shift='$func_shift'";
		if($func_sem=="7" || $func_sem=="8")
		{
			$sql1="SELECT TOTAL FROM final_year WHERE SHIFT ='$func_shift' AND SEMESTER='$func_sem' " ;
		}
		$res1=$conn-> query($sql1);
		$appeared=$res1->num_rows;
		$grade_o=0;
		$grade_a=0;
		$grade_b=0;
		$grade_c=0;
		$grade_d=0;
		$grade_e=0;
		$passed=0;

		switch($func_sem)
		{
			case 3:
			$sem_str="III";
			break;

			case 4:
			$sem_str="IV";
			break;

			case 5:
			$sem_str="V";
			break;

			case 6:
			$sem_str="VI";
			break;

			case 7:
			$sem_str="VII";
			break;

			case 8:
			$sem_str="VIII";
			break;
			default:
			$sem_str="INVALID";

		}

		if ($func_shift==1)
		{
			$shift_str="First Shift";
		}
		else
		{
			$shift_str="Second Shift";
		}



		while ($row=$res1->fetch_assoc()) {
			$cell=$row["C_SG_TOTAL"];
			if($func_sem=='7' || $func_sem=='8')
			{$cell=$row["TOTAL"];}
			$marks=0;
			for($i=0;$i<strlen($cell);$i++)
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


			#formula to find CGPA------------#
			$cgpi=(($marks*100/750)-11)/7.25;
			if($cgpi>=9.5)
				{$grade_o+=1;}
			if($cgpi>=8.5 and $cgpi<9.5)
				{$grade_a+=1;}
			if($cgpi>=7.5 and $cgpi<8.5)
				{$grade_b+=1;}
			if($cgpi>=6.5 and $cgpi<7.5)
				{$grade_c+=1;}
			if($cgpi>=5.5 and $cgpi<6.5)
				{$grade_d+=1;}
			if($cgpi>=4.5 and $cgpi<5.5)
				{$grade_e+=1;}

		}



		$sql2="SELECT REMARKS FROM project where BRANCH='$br' and E_DATE='$e_date' and SEMESTER='$func_sem' and shift='$func_shift' ";
		if($func_sem=="7" || $func_sem=="8")
		{
			$sql2="SELECT REMARK from final_year where SHIFT='$func_shift' AND SEMESTER='$func_sem' ";
		}

		$res2=$conn->query($sql2);

		while($row2=$res2->fetch_assoc())
		{
			$cell2=$row2['REMARKS'];
			if($func_sem=="7" || $func_sem=="8")
				{$cell2=$row2['REMARK'];}
			if($cell2=='P')
				$passed++;
		}
		$fail=$appeared-$passed;
		$pass_percent=$passed*100/$appeared;



			echo "<td rowspan='3'>($sem_str)$shift_str</td>";
			echo "<td rowspan='3'>$appeared</td>";
			echo "<td class='grd'>Grade O:$grade_o</td>";
			echo "<td class='grd' rowspan='3'>Grade C:$grade_c</td>";
			echo "<td class='grd'>Grade D:$grade_d</td>";
			echo "<td cl rowspan='3'>$passed</td>";
			echo "<td rowspan='3'>$fail</td>";

			#empty cell for %pass percent
			echo "<td rowspan='3'>";
			printf("%0.2f",$pass_percent);
			echo"</td></tr>";

			echo "<tr><td class='grd'>Grade A:$grade_a</td>";
			echo "<td class='grd'>Grade E:$grade_e</td></tr>";
			echo "<tr><td class='grd'>Grade B:$grade_b</td>";
			echo "<td></td></tr>";
			$pass_percent=number_format($pass_percent,2,".","");
			return $pass_percent;
	}
	echo "<tr><td rowspan='$span'>Second Year</td>";

	$graph_array[$graph_array_count++]= sub_wise($conn,$br,$e_date,$sem_array[0],1);
	if($shift==2)
	$graph_array[$graph_array_count++]= sub_wise($conn,$br,$e_date,$sem_array[0],2);

	echo"<tr><td rowspan='$span'>Third Year</td>";

	$graph_array[$graph_array_count++]= sub_wise($conn,$br,$e_date,$sem_array[1],1);
	if($shift==2)
	$graph_array[$graph_array_count++]= sub_wise($conn,$br,$e_date,$sem_array[1],2);

	echo"<tr><td rowspan='6'>Fourth Year</td>";

	$graph_array[$graph_array_count++]=sub_wise($conn,$br,$e_date,$sem_array[2],1);
	if($shift==2)
	$graph_array[$graph_array_count++]=sub_wise($conn,$br,$e_date,$sem_array[2],2);
	for($j=0;$j<$graph_array_count;$j++)
	{
		echo"$graph_array[$j] ";
	}

if ($br=="I" || $br=="T")
{
	$num_shift=2;
}
else{
	$num_shift=1;
}
if (strpos($e_date,"MAY")!== false){
	$sem_=2;
}
else{
$sem_=1;
}

if($num_shift==1 && $sem_==1){
	$res_array=array("Sem3-First shift","Sem3-Second shift","Sem5-First shift","Sem5-Second shift","Sem7-First shift","Sem7-Second shift");
}
else if($num_shift==1 && $sem_==2){
	$res_array=array("Sem4-First shift","Sem4-Second shift","Sem6-First shift","Sem6-Second shift","Sem8-First shift","Sem8-Second shift");
}
else if ($num_shift==2 && $sem_==1){
		$res_array=array("Sem3-First shift","Sem5-First shift","Sem7-First shift");}
else if($num_shift==2 && $sem_==2){
		$res_array=array("Sem4-First shift","Sem6-First shift","Sem8-First shift");
}



?>




</table>
<br><br><br>
<button class="btn btn-primary set2" type="submit" onclick="myGraph()" style="margin-left:50%;">Get Graph</button>
<div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</div>
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
	var all_sem_subject= <?php  echo json_encode($graph_array); ?>;
	console.log(all_sem_subject);
	var title=<?php echo json_encode($res_array); ?>;
	console.log(title)





	</script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js">
	</script>
</html>
