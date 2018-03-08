<?php 
	//Include Koneksi
	include "koneksi.php";

	//Membuat Query
	
	
	
	
	
	$k=$konek->query("SELECT
trans15menit.tanggal,
trans15menit.jam,
((SELECT sum((min+max)/2000) AS test FROM trans15menit WHERE ID_SENSOR='12' OR ID_SENSOR='13' OR ID_SENSOR='14' LIMIT 1 )
/

((SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='25' OR ID_SENSOR='26' OR ID_SENSOR='27' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='38' OR ID_SENSOR='39' OR ID_SENSOR='40' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='75' OR ID_SENSOR='76' OR ID_SENSOR='77' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='51' OR ID_SENSOR='52' OR ID_SENSOR='53' LIMIT 1 ) 

+ (SELECT (sum((rata)/1000)*3) AS test FROM trans15menit WHERE ID_SENSOR='88'  LIMIT 1 )
)

) as rata
FROM
trans15menit
INNER JOIN sensor ON trans15menit.ID_SENSOR = sensor.ID_SENSOR
WHERE LEFT(sensor.KODEALAT,7)='Listrik' GROUP BY trans15menit.tanggal");

	$q=$konek->query("SELECT
trans15menit.tanggal,
trans15menit.jam,
((SELECT sum((min+max)/2000) AS test FROM trans15menit WHERE ID_SENSOR='12' OR ID_SENSOR='13' OR ID_SENSOR='14' LIMIT 1 )
/

((SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='25' OR ID_SENSOR='26' OR ID_SENSOR='27' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='38' OR ID_SENSOR='39' OR ID_SENSOR='40' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='75' OR ID_SENSOR='76' OR ID_SENSOR='77' LIMIT 1 ) 

+ (SELECT sum((rata)/1000) AS test FROM trans15menit WHERE ID_SENSOR='51' OR ID_SENSOR='52' OR ID_SENSOR='53' LIMIT 1 ) 

+ (SELECT (sum((rata)/1000)*3) AS test FROM trans15menit WHERE ID_SENSOR='88'  LIMIT 1 )
)

) as rata
FROM
trans15menit
INNER JOIN sensor ON trans15menit.ID_SENSOR = sensor.ID_SENSOR
WHERE LEFT(sensor.KODEALAT,7)='Listrik' GROUP BY trans15menit.tanggal");
?>

<!-- File yang diperlukan dalam membuat chart -->
<script src="js/jquery.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
    
<script type="text/javascript">
$(function () {
    $('#view').highcharts({
	 chart: {
                zoomType: 'x'
            },
        title: {
            text: 'PUE',
            x: -20 //center
        },
        subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
		
        xAxis: {
            categories: [<?php while($r=$q->fetch_array()){ echo "'".$r["tanggal"]."',";}?>]
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Nilai PUE ',
            data: [<?php while($t=$k->fetch_array()){ echo $t["rata"].",";}?>]
        }]
    });
});
</script>

<div id="view" style="min-width: 310px; height: 400px; margin: 0 auto"></div>