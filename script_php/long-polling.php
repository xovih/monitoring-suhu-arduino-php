<?php

ignore_user_abort(false);
set_time_limit(40);
date_default_timezone_set("Asia/Jakarta");

try {

	include_once 'config.php';

	while (true) {

		// select new rows
		// $result = $mysqli -> query("SELECT suhu, kelembapan, waktu FROM suhuku ORDER BY LIMIT 1");
		$result = $mysqli -> query("SELECT t.ID, t.suhu, t.kelembapan, t.waktu FROM suhuku t INNER JOIN agentku a ON a.kode_agent = t.kode_agent WHERE t.waktu>a.last_seen");

		$lastId = "";
		$today = date('Y-m-d');
		$high = $mysqli->query("SELECT max(suhu) as max_suhu, max(kelembapan) as max_lembap FROM suhuku WHERE DATE(waktu)='$today' AND kode_agent='ardu-tik-jeff'");
		$high_temp = [];
		if ($reshigh = $high->fetch_assoc()) {
			$high_temp['suhu'] = $reshigh['max_suhu'];
			$high_temp['lembap'] = $reshigh['max_lembap'];
		}

		// check whether there were new rows in above query
		if ($result && $result -> num_rows) {
			//if yes, makes the output
			$output = [];

			foreach ($result as $row) {
				$output[] = [
					'content' => "Suhu : ".$row['suhu'] ." &deg;C &nbsp;&nbsp; Kelembapan : ".$row['kelembapan']." %RH", 
					'time' => date('H:i:s',strtotime($row['waktu'])),
					'suhu' => $row['suhu'],
					'kelembapan' => $row['kelembapan'],
					'max_suhu' => $high_temp['suhu'],
					'max_lembap' => $high_temp['lembap']
				];
				// echo $row['waktu'];exit;
				$lastId = $row['waktu'];
				$mysqli->query("UPDATE agentku SET last_seen ='$lastId' WHERE kode_agent = 'ardu-tik-jeff'");
			}
			

			echo json_encode([
				'status' => true,
				'data' => $output
			]);
			exit;
		}

		

		// db queries are heavy. So 2 seconds
		sleep(1);
	}

} catch (Exception $e) {

	exit(
		json_encode(
			array (
				'status' => false,
				'error' => $e -> getMessage()
			)
		)
	);

}