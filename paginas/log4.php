<?php
error_reporting(0);
ini_set(“display_errors”, 0 );
include('func/database.php');

$sql = 'SELECT * 
		FROM droparmas';
		

?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
       		<h2>Refundos Administrativos</h2>
            <ol class="breadcrumb">
                <li>
                	<a href="inicio">Home</a>
                </li><li>
                    Administração
                </li><li class="active">
                    <strong>Armas no servidor</strong>
                </li>
            </ol>
         </div>
         <div class="col-lg-2">

         </div>
    </div>
<html>
<head>
	<title>Progressive Roleplay</title>
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
			padding: 0px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #337ab7;
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
    
	<h1>Armamentos</h1>
	<center><table class="data-table">
	    <hr>
		<thead>
			<tr>
				<th>Arma ID</th>
				<th>Comprada por</th>
				<th>Comprada em</th>
				<th>Numeracão</th>
				<th>Dropada</th>
				<th>Posição X</th>
				<th>Posição Y</th>
				<th>Posição Z</th>
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
					<td>'.$row['ArmaID'].'</td>
					<td>'.$row['CompradaPor'].'</td>
					<td>'.$row['CompradaData'].'</td>
					<td>'.$row['Numeracao'].'</td>
					<td>'.$row['NoChao'].'</td>
					<td>'.$row['ArmaX'].'</td>
					<td>'.$row['ArmaY'].'</td>
				    <td>'.$row['ArmaZ'].'</td>
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

   
