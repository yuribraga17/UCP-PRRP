<?php
session_start(); 	//A seção deve ser iniciada em todas as páginas
if (!isset($_SESSION['usuarioID'])) 
{		//Verifica se há seções
	session_destroy();						//Destroi a seção por segurança
	header("Location: login.php"); exit;	//Redireciona o visitante para login
}

include('func/database.php');

function get_ip() 
{
    if ( function_exists( 'apache_request_headers' ) ) 
    {
        $headers = apache_request_headers();
    } else {
        $headers = $_SERVER;
    }
    if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
        $the_ip = $headers['X-Forwarded-For'];
    } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    } else {
        $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
    }
    return $the_ip;
}

if(isset($_POST['persName']))
 $charname=$mysqli->real_escape_string($_POST['persName']);
if(isset($_POST['genero']))
 $genero=$mysqli->real_escape_string($_POST['genero']);
if(isset($_POST['hist-pers']))
 $histper=$mysqli->real_escape_string($_POST['hist-pers']);
 if(isset($_POST['userName']))
 $login=$mysqli->real_escape_string($_POST['userName']);

if((isset($_POST["userName"])))
{ 
        $date1 = date('m/d/Y h:i:s a', time());
        //Consulta no banco de dados 
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $http_client_ip = get_ip();
        
        //Checar dnv se o personagem existe
        $result1 = $mysqli->query("SELECT Username FROM accounts WHERE Username='".$charname."' LIMIT 1");
        $count1 = $result1->num_rows;
        $result1->close();
    
        if ($count == 0 && $count1 == 0)
        {
            
            $sql_app="INSERT INTO ucp_aplic (ucp_user_owner, avaliado) VALUES ('$ACCID','0')";
            $mysqli->query($sql_app);
    
            
            $sql_app2="UPDATE ucp_aplic SET  histpers='$histper' WHERE ucp_user_owner = '$ACCID'"; 
            $mysqli->query($sql_app2);
            
            
            $sql_app3 = "UPDATE ucp_aplic SET Charname='$charname', Gender='$genero', Birthdate='$nascdate', Origin='$localnasc' ,CreateDate='$timestamp' ,Skin='$Skin_Registro' WHERE ucp_user_owner = '$ACCID'";
            $mysqli->query($sql_app3);
            
            $timestaaaamp = time();
            $sql_app4="INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('$ACCID','user','Bem vindo a UCP do PR:RP','$timestaaaamp','0')"; 
            $mysqli->query($sql_app4);
    
        }
    }
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Progressive Roleplay | Register</title>

    <link href="<?=$url_base;?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$url_base;?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=$url_base;?>/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?=$url_base;?>/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="<?=$url_base;?>/css/animate.css" rel="stylesheet">
    <link href="<?=$url_base;?>/css/style.css" rel="stylesheet">
    
     <!-- Sweet Alert -->
    <link href="<?=$url_base;?>/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    
    <link href="<?=$url_base;?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    
    <link href="<?=$url_base;?>/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    
    <style>
    .large-box {
        width:60%;
        margin-left:20%;
        margin-top:30px;
    }
    </style>

</head>

<body class="gray-bg">

    <div class="large-box text-center   animated fadeInDown">
        <div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <center><div class="form-group logo90rp-registro"> </div></center>
                        </div>
                        <div class="ibox-content">
                           <form action="criar" method="post">
                                <h1>Personagem</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h2>Informações do personagem</h2>
                                            <div class="form-group">
                                                <label>Nome do personagem * <font size="-8">( Nome_Sobrenome )</font></label>
                                                <input id="persName" name="persName" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Gênero</label>
                                                
                                                    <select class="form-control m-b" name="genero" id="genero">
                                                        <option value="1">Masculino</option>
                                                        <option value="2">Feminino</option>
                                                    </select>
                                            </div>
                                            <div class="form-group" id="data_1">
                                                <label>Data de Nascimento</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="nasc-date" name="nasc-date" type="text" class="form-control" value="01/01/1975">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Onde seu personagem nasceu? *</label>
                                                <input id="local-nasc" name="local-nasc" type="text" class="form-control required">
                                            </div>
                                            <div class="form-group">
                                                <label>Conte-nos a história de seu personagem. Pelo menos três parágrafos *</label>
                                                <textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;" ></textarea>
                                            </div>
                                            <div align="right">
                                    	        <button type="submit" class="btn btn-primary block m-b">Enviar Aplicação</button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    </div>

                </div>
            </div>
            
            <p class="m-t"> <small>Copyright PR:RP © 2018~2023</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?=$url_base;?>/js/jquery-2.1.1.js"></script>
    <script src="<?=$url_base;?>/js/bootstrap.min.js"></script>
    <script src="<?=$url_base;?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?=$url_base;?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?=$url_base;?>/js/inspinia.js"></script>
    <script src="<?=$url_base;?>/js/plugins/pace/pace.min.js"></script>

    <!-- Steps -->
    <script src="<?=$url_base;?>/js/plugins/staps/jquery.steps.min.js"></script>

    <!-- Jquery Validate -->
    <script src="<?=$url_base;?>/js/plugins/validate/jquery.validate.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="<?=$url_base;?>/js/plugins/sweetalert/sweetalert.min.js"></script>
    
    <!-- iCheck -->
    <script src="<?=$url_base;?>/js/plugins/iCheck/icheck.min.js"></script>
    
    <script src="<?=$url_base;?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <script>
        $(document).ready(function(){
            var pers_existe = 0; 
            var pers_comespaco = 0;
            var pers_semunder = 0;
            
            $("#wizard").steps();
            $("#form").steps(
            {
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex, nvar)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }
                    
                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 1 && Number($("#age").val()) < 13)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    if(newIndex === 1)
                    {
                        if(form.valid() == true)
                        {
                            if(pers_existe == 1) 
                            {
                                swal("Registro", "Este nome de personagem já está em uso! ", "error");
                                return false;
                            }
                            else if(pers_comespaco = 0) 
                            {
                                swal("Registro", "O nome do seu personagem não pode conter espaço! ", "error");
                                return false;
                            }
                            else if(pers_semunder = 0) 
                            {
                                swal("Registro", "O nome do seu personagem deve contar um _  ficando Nome_Sobrenome.", "error");
                                return false;
                            }
                            else
                            {
                                return form.valid();
                            }
                        }
                    }
                    return form.valid();
                    
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);
                    form.submit();
                    
                    //Pagina 1
                    /*var login=$('#userName').val();
                    var senha=$('#password').val();
                    var passconf=$('#confirm').val();
                    var email=$('#email').val();*/
                    //Pagina 2
                    var charname=$('#persName').val();
                    var localnasc=$('#local-nasc').val();
                    var nascdate=$('#nasc-date').val();
                    var genero=$('#genero').val();
                    var histpers=$('#hist-pers').val();
                }
            $('#persName').focusout(function(){     //Ao submeter formulário
                var qnt = 0;
                var qnt1 = 0;
                var campo = document.getElementById("persName");
                var i=0;
                for(i=0;i<campo.value.length;i++)
                {
                    if(campo.value[i] == " ")
                    {
                        qnt++;
                    }
                    if(campo.value[i] == "_")
                    {
                        qnt1++;
                    }
                }   
                if(qnt > 0)
                {
                    swal("Registro", "O nome do seu personagem não pode conter espaço!", "error");
                    pers_comespaco = 1;
                }
                else if(qnt1 != 1)
                {
                    swal("Registro", "O nome do seu personagem deve contar um _ ficando Nome_Sobrenome.", "error");
                    pers_semunder = 1;
                }
                else 
                {
                    pers_comespaco = 0;
                    pers_semunder = 0;
                    var charname=$('#persName').val();  //Pega valor do campo email
                    $.ajax({            //Função AJAX
                        url:"func/ver_pers.php",            //Arquivo php
                        type:"post",                //Método de envio
                        data: "charname="+charname, //Dados
                        success: function (result){ //Sucesso no AJAX
                            //alert(result);
                            if(result==1)
                            {
                                swal("Registro", "Este nome de personagem já está em uso! ", "error");
                                pers_existe = 1;
                            }
                            else pers_existe = 0;
                        }
                    })
                    return false;   //Evita que a página seja atualizada
                }
            });    
       });
    });
       //=======================
    </script>
</body>
</html>
