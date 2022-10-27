<?php
$db_host = '198.50.187.244'; // Server Name
$db_user = 'yurib_6948'; // Username
$db_pass = 'wGfWG501d2'; // Password
$db_name = 'yurib_6948'; // Database Name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}

$sql = 'SELECT * 
		FROM a_banrecord';
		
$query = mysqli_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
       		<h2>Logs Administrativos</h2>
            <ol class="breadcrumb">
                <li>
                	<a href="inicio">Home</a>
                </li><li>
                    Administração
                </li><li class="active">
                    <strong>Ajail log</strong>
                </li>
            </ol>
         </div>
         <div class="col-lg-2">

         </div>
    </div>
<html>
<head>
	<title>São Paulo Roleplay</title>
	<style type="text/css">
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
			}

		h1 {
			margin: 10px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 15px;
			min-width: 437px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			text-align: center;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #3b6f77;
			text-align: center;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
		    text-align: center;
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: center;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
    
	<h1>Ban log's</h1>
	<center><table class="data-table">
	    <hr>
		<thead>
			<tr>
				<th>ID ban</th>
				<th>Player</th>
				<th>Motivo</th>
				<th>Data</th>
				<th>Admin</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 9999;
		while ($row = mysqli_fetch_array($query))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$row['banrec'].'</td>
					<td>'.$row['PlayerNome'].'</td>
					<td>'.$row['Motivo'].'</td>
					<td>'.$row['Data'].'</td>
					<td>'.$row['Admin'].'</td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}?>
		</tbody>
		<tfoot>
		</tfoot>
	</table></center>
</body>
</html>
<hr>
<?php include('ads.php'); ?>

   
