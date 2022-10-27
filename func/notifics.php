<?php
$TotalNotifics = 0;
	
$result = $mysqli->query("SELECT * FROM ucp_notific WHERE ownId='".$_SESSION['usuarioID']."' ORDER BY id DESC LIMIT 5");
$TotalNotifics = $result->num_rows;

$result1 = $mysqli->query("SELECT * FROM ucp_notific WHERE ownId='".$_SESSION['usuarioID']."' AND visto='0' ORDER BY id DESC");
$TotalNovasNotifics = $result1->num_rows;


// CORREÇÃO DA DATA DO SERVIDOR
// SE VOCÊ TIVER UM FUSO-HORÁRIO DIFERENTE, VEJA ESSE LINK
// http://www.codigosnaweb.com/forum/Como-corrigir-o-problema-do-fuso-horario-do-servidor_1_8976.html

function passou($time_stamp)
{
    $time_difference = strtotime('now') - $time_stamp;

    if ($time_difference >= 60 * 60 * 24 * 365.242199)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
         * This means that the time difference is 1 year or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'ano');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
         * This means that the time difference is 1 month or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'mês');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 7)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
         * This means that the time difference is 1 week or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'sem');
    }
    elseif ($time_difference >= 60 * 60 * 24)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day
         * This means that the time difference is 1 day or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24, 'dia');
    }
    elseif ($time_difference >= 60 * 60)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour
         * This means that the time difference is 1 hour or more
         */
        return get_time_ago_string($time_stamp, 60 * 60, 'hora');
    }
    else
    {
        /*
         * 60 seconds/minute
         * This means that the time difference is a matter of minutes
         */
        return get_time_ago_string($time_stamp, 60, 'min');
    }
}
 
function get_time_ago_string($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);
 
    settype($time_units, 'string');
 
    if ($time_units === '0')
    {
        return '1 ' . $time_unit . ' atras';
    }
    elseif ($time_units === '1')
    {
        return '1 ' . $time_unit . ' atras';
    }
    else
    {
        /*
         * More than "1" $time_unit. This is the "plural" message.
         */
        // TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
        return $time_units . ' ' . $time_unit . 's atras';
    }
}
?>
<li class="dropdown">
	<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
		<i class="fa fa-bell" style="color:#46b8da;"></i>  <span class="label label-primary"><?=$TotalNovasNotifics;?></span>
	</a>
	<ul class="dropdown-menu dropdown-alerts"> 	
	<?php
		if($TotalNotifics > 0)
		{
			while($row = $result->fetch_array())
			{
				if($row['visto'] == 0)
					echo "<li style=\"background-color:#46b8da;\">
							<a>
							<div onClick=\"vizualizarnotifs(".$row['id'].")\">
							<i class=\"fa fa-".$row['icon']." \"></i> ".$row['text']."
							<span class=\"pull-right text-muted small\">".passou($row['timestamp'])."</span>
							</div>
							</a>
							</li><li class=\"divider\"></li>";
				
				else
					echo "<li>
						<a>
						<div>
						<i class=\"fa fa-".$row['icon']." \"></i> ".$row['text']."
						<span class=\"pull-right text-muted small\">".passou($row['timestamp'])."</span>
						</div>
						</a>
						</li><li class=\"divider\"></li>";
			}
		}
		else
		{
			echo "<li>
					<a>
					<div>
					<i class=\"fa fa-bell-slash \"></i> Você não tem nenhuma notificação.
					</div>
					</a>
					</li><li class=\"divider\"></li>";
		}
	?>
    <li>
        <div class="text-center link-block">
            <a href="notificacoes">
                <strong>Ver todas as notificações</strong>
                    <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </li>
	</ul>
</li>
                
<script type="text/javascript">
	function vizualizarnotifs(id){
		$.ajax({			//Função AJAX
			url:"func/del_notif.php",			//Arquivo php
			type:"post",				//Método de envio
			data: "id="+id,	//Dados
			success: function (result){	//Sucesso no AJAX
				//alert(result);
			location.reload();
		}
	})
return false;	
}
</script>