<?php
include_once 'config.php';

$data = $mysqli->query("SELECT * FROM suhuku WHERE kode_agent='ardu-tik-jeff' ORDER BY waktu DESC LIMIT 5");
// var_dump($data);exit;
$suhu = [];
$lembap = [];
$label = [];
while ($res = $data->fetch_assoc()) {
    $suhu[] = $res['suhu'];
    $lembap[] = $res['kelembapan'];
    $label[] = date('H:i:s',strtotime($res['waktu']));
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Suhu Master</title>
    <style>
        .blinking{
            animation:blinkingText 0.9s infinite;
        }
        @keyframes blinkingText{
            0%{     color: #000;    }
            49%{    color: transparent; }
            50%{    color: transparent; }
            70%{    color: transparent; }
            88%{    color: #000;  }
            97%{    color: #000;  }
            100%{   color: #000;    }
        }
        body {
            padding-top: 3.5rem;
            min-height: 100vh;
            position: relative;
            margin: 0;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
  </head>
  <body class="bg-warning">
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">suhulembab.com</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active mr-2" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link mr-2" href="#">Pilih Sensor</a>
                <a class="nav-item nav-link mr-2" href="#">History Sensor</a>
                <a class="nav-item nav-link mr-2" href="#">Laporkan Gangguan</a>
                <button class="btn btn-warning">Sign In</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card my-2">
                    <div class="card-body">
                        <h1>Statistik Perhitungan Suhu</h1>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center my-2" style="min-height:185px;">
                    <div class="card-body">
                        <h4>Current Temperature</h4>
                        <h1 id="suhuku" class="mt-4 blinking">28 &deg;C</h1>
                    </div>
                </div>
                <div class="card text-center my-2" style="min-height:185px;">
                    <div class="card-body">
                        <h4>Our Current Humidity</h4>
                        <h1 id="lembapku" class="mt-4 blinking">50 %RH</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center my-2" style="min-height:185px;">
                    <div class="card-body">
                        <h4>Highest Temp. Today</h4>
                        <h1 id="suhukut" class="mt-4 blinking">28 &deg;C</h1>
                    </div>
                </div>
                <div class="card text-center my-2" style="min-height:185px;">
                    <div class="card-body">
                        <h4>Highest Hum. Today</h4>
                        <h1 id="lembapkut" class="mt-4 blinking">50 %RH</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <footer class="bg-primary text-center">
        <div class="container">
            <p class="pt-4">&copy;2019. By Orang Ganteng Se Antero PT. Pindad</p>
        </div>    
    </footer>

    </body>

    <!-- Main JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        let suhu = <?=json_encode($suhu)?>;
        let lembap = <?=json_encode($lembap)?>;
        let labelku = <?=json_encode($label)?>;
        let ctx = document.getElementById('myChart').getContext('2d');
        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: labelku,
                datasets: [{
                    label: 'Temperatur',
                    // backgroundColor: 'rgb(0, 99, 132)',
                    borderColor: 'rgb(0, 99, 132)',
                    data: suhu
                }, {
                    label: 'Kelembapan',
                    // backgroundColor: 'rgb(0, 200, 132)',
                    borderColor: 'rgb(0, 200, 132)',
                    data: lembap
                }]
            },

            // Configuration options go here
            options: {}
        });
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script type="text/javascript">
	
	function poll() {
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState === 4 && this.status === 200) {
				if (this.status === 200) {
					try {
						var json = JSON.parse(this.responseText);
					} catch {
						poll();return;
					}
					

					if (json.status !== true) {
						alert(json.error);return;
					}

					var data = json.data;
					for (var i = 0, len = data.length; i < len; i++) {
						var x = data[i];

                        chart.data.datasets[0].data.shift();
                        chart.data.datasets[0].data.push(x.suhu);
                        chart.data.datasets[1].data.shift();
                        chart.data.datasets[1].data.push(x.kelembapan);
                        chart.data.labels.shift();
                        chart.data.labels.push(x.time);
                        chart.update();

                        document.getElementById("lembapku").innerHTML = x.kelembapan+ '%RH';
                        document.getElementById("suhuku").innerHTML = x.suhu+ '&deg;C';
                        document.getElementById("lembapkut").innerHTML = x.max_lembap+ '%RH';
                        document.getElementById("suhukut").innerHTML = x.max_suhu+ '&deg;C';
						
					}

					


					poll();
				} else {
					poll();
				}

			}
		}
		ajax.open('GET', 'long-polling.php', true);
		ajax.send();


	}
	
	poll();

</script>


</html>