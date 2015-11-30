<?php
ini_set('display_errors', 1);
error_reporting(-1);

include_once '/var/www/html/hack/lib/sql.php';

function RGBToHex($r, $g, $b) {
	//String padding bug found and the solution put forth by Pete Williams (http://snipplr.com/users/PeteW)
	$hex = "";
	$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
	$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
	$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

	return strtoupper($hex);
}

if(isset($_GET['activity'])){
	$key = $_GET['activity'];
	$reqBase = Sql::request("SELECT `key`, AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",(time()-30)*1000,$key);
	$reqBase30 = Sql::request("SELECT `key`, AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",(time()-90)*1000,$key);
	?>
	<table class="table" style="max-width:100%;">
		<tbody>
			<?php
			$data = Sql::getData($reqBase);
			$dataBase = Sql::getData($reqBase30);
			echo '<tr>';
				echo '<td style="padding-left:20px;">Activity</td>';
				if($dataBase['st']!=0)
					if(abs($data['st']-$dataBase['st'])*100/$dataBase['st'] <= 100){
						echo '<td style="text-align:center;">'.floor(abs($data['st']-$dataBase['st'])*100/$dataBase['st']).'%</td>';
					}
					else{
						echo '<td>100%</td>';
					}
				
			echo '</tr>';
			?>
		</tbody>
	</table>
	<?php
}

else if(isset($_GET['color'])){
	$key = $_GET['color'];
	$reqBase = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key` = ?",(time()-30)*1000,$key);
	$reqBase30 = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key` = ?",(time()-90)*1000,$key);
	$data = Sql::getData($reqBase);
	$dataBase = Sql::getData($reqBase30);
	
	if($dataBase['st']!=0){
		$activity = abs($data['st']-$dataBase['st'])*100/$dataBase['st']<=100?abs($data['st']-$dataBase['st'])*100/$dataBase['st']:100;
		
		$r = (floor(255*$activity/100));
		$g = (floor(255*(1- $activity/100)));
		
		echo RGBToHex($r,$g,0);
	}
}

else if(isset($_GET['positions'])){
	$req = Sql::request("SELECT * FROM toilet");
	$data = array();
	while($d = Sql::getData($req)){
		$key = $d['key'];
		$reqBase = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key` = ?",(time()-30)*1000,$key);
		$reqBase30 = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key` = ?",(time()-90)*1000,$key);
		$dataBase = Sql::getData($reqBase);
		$dataBase30 = Sql::getData($reqBase30);
		
		if($dataBase30['st']!=0){
			$activity = abs($dataBase['st']-$dataBase30['st'])*100/$dataBase30['st']<=100?abs($dataBase['st']-$dataBase30['st'])*100/$dataBase30['st']:100;
			
			$r = (floor(255*$activity/100));
			$g = (floor(255*(1- $activity/100)));
			
			$d['color'] = RGBToHex($r,$g,0);
		}
		else
			$d['color'] = '000000';
		array_push($data,$d);
	}
	
	echo json_encode($data);
}

else if(isset($_GET['info'])){
	$key = $_GET['info'];
	$response = array();
	$req1 = Sql::request("SELECT name FROM toilet WHERE `key` = ?",$key);
	if($name = Sql::getData($req1)){
		$response['name'] = $name['name'];
		
		$history = array();
		$histDuration = 2*3600;
		$currentTime = time();
	
		for($i=$currentTime-$histDuration;$i<$currentTime;$i+=30){
			$reqHist = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",($i-30)*1000,$key);
			$reqHist90 = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",($i-90)*1000,$key);
			$data = Sql::getData($reqHist);
			$dataBase = Sql::getData($reqHist90);
			$activity = (abs($data['st']-$dataBase['st'])*100/($dataBase['st']!=0?:1));
			
			array_push($history,array($i,$activity<=100?$activity:100));
		}
		
		$response['history'] = $history;
		
		$reqBase = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",(time()-30)*1000,$key);
		$reqBase30 = Sql::request("SELECT AVG(value) AS av, STDDEV(value) AS st FROM data WHERE `date` > ? AND `key`=?",(time()-90)*1000,$key);
		$data = Sql::getData($reqBase);
		$dataBase = Sql::getData($reqBase30);
		
		$response['info'] = '<table class="table" style="max-width:100%;">';
		$response['info'] .= '<tbody>';
		$response['info'] .= '<tr>';
		$response['info'] .= '<td style="padding-left:20px;">Activity</td>';
		if($dataBase['st']!=0)
			if(abs($data['st']-$dataBase['st'])*100/$dataBase['st'] <= 100){
				$response['info'] .= '<td style="text-align:center;">'.floor(abs($data['st']-$dataBase['st'])*100/$dataBase['st']).'%</td>';
			}
			else{
				$response['info'] .= '<td>100%</td>';
			}
		$response['info'] .= '</tr>';
		$response['info'] .= '</tbody>';
		$response['info'] .= '</table>';
	}
	else{
		$response['name'] = 'Error';
		$response['info'] = 'No data found';
	}
	
	echo json_encode($response);
}
?>