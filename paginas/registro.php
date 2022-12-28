<?php
session_start();    //A seção deve ser iniciada em todas as páginas
if (isset($_SESSION['usuarioID'])) 
{       //Verifica se há seções
    die('<script type="text/javascript">window.location.href="inicio";</script>');
}
error_reporting(0);
ini_set(“display_errors”, 0 );
include('../func/database.php');

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

if(isset($_POST['def-rol']))
 $rp=$mysqli->real_escape_string($_POST['def-rol']);
if(isset($_POST['def-mg']))
 $mg=$mysqli->real_escape_string($_POST['def-mg']);
if(isset($_POST['def-matar']))
 $kill=$mysqli->real_escape_string($_POST['def-matar']);
if(isset($_POST['def-fear']))
 $fear=$mysqli->real_escape_string($_POST['def-fear']);
if(isset($_POST['def-ioc']))
 $ioc=$mysqli->real_escape_string($_POST['def-ioc']);
if(isset($_POST['def-pg']))
 $fpg=$mysqli->real_escape_string($_POST['def-pg']);

if(isset($_POST['userName']))
 $login=$mysqli->real_escape_string($_POST['userName']);
if(isset($_POST['persName']))
 $charname=$mysqli->real_escape_string($_POST['persName']);
if(isset($_POST['genero']))
 $genero=$mysqli->real_escape_string($_POST['genero']);
if(isset($_POST['nasc-date']))
 $nascdate=$mysqli->real_escape_string($_POST['nasc-date']);
if(isset($_POST['local-nasc']))
 $localnasc=$mysqli->real_escape_string($_POST['local-nasc']);
if(isset($_POST['hist-pers']))
 $histper=$mysqli->real_escape_string($_POST['hist-pers']);
if(isset($_POST['password']))
 $senha=$mysqli->real_escape_string($_POST['password']);
if(isset($_POST['email']))
 $email=$mysqli->real_escape_string($_POST['email']);

//echo $login;

if((isset($_POST["userName"])))
{ 
        $hashedPassword = strtoupper(hash( 'whirlpool',$senha));  
        $date1 = date('m/d/Y h:i:s a', time());
        //Consulta no banco de dados 
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $http_client_ip = get_ip();
    
        //Checar dnv se Conta existe
        $result = $mysqli->query("SELECT uNome FROM ucp_users WHERE uNome='".$login."' LIMIT 1");
        $count = $result->num_rows;
        $result->close();
        
        //Checar dnv se o personagem existe
        $result1 = $mysqli->query("SELECT Username FROM accounts WHERE Username='".$charname."' LIMIT 1");
        $count1 = $result1->num_rows;
        $result1->close();
    
        if ($count == 0 && $count1 == 0)
        {
            $result2 = $mysqli->query("INSERT INTO ucp_users (uNome,uSenha,uRegisterDate,uIP,uEmail) VALUES ('".$login."','".$hashedPassword."','".$date1."','".$http_client_ip."','".$email."')");
            $ACCID = $mysqli->insert_id;
            
            $sql_app="INSERT INTO ucp_aplic (ucp_user_owner,def_rol, avaliado) VALUES ('$ACCID','".$rp."','0')";
            $mysqli->query($sql_app);
    
            $sql_app2="UPDATE ucp_aplic SET def_mg='$mg', def_matar='$kill' WHERE ucp_user_owner = '$ACCID'"; 
            $mysqli->query($sql_app2);
            
            $sql_app3="UPDATE ucp_aplic SET def_fear='$fear', def_ioc='$ioc', histpers='$histper' WHERE ucp_user_owner = '$ACCID'"; 
            $mysqli->query($sql_app3);
            
            $sql_app4="UPDATE ucp_aplic SET def_pg='$fpg' WHERE ucp_user_owner = '$ACCID'"; 
            $mysqli->query($sql_app4);
            
            $sql_app6 = "UPDATE ucp_aplic SET Charname='$charname', Gender='$genero', Birthdate='$nascdate' ,Origin='$localnasc' ,CreateDate='$timestamp' ,Skin='$Skin_Registro' WHERE ucp_user_owner = '$ACCID'";
            $mysqli->query($sql_app6);
            
            $timestaaaamp = time();
            $sql_app5="INSERT INTO ucp_notific (OwnId,icon,text,timestamp,visto) VALUES('$ACCID','user','Bem vindo a UCP do PR:RP','$timestaaaamp','0')"; 
            $mysqli->query($sql_app5);
    
            session_start();        //Inicia seção
            //Abrindo seções
            $_SESSION['usuarioID']=$ACCID;      
            $_SESSION['nomeUsuario']=$login;
            die('<script type="text/javascript">window.location.href="inicio";</script>');
            exit;
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
                           <form id="form" name="form" action="registro" class="wizard-big" method="post">
                                <h1>Conta</h1>
                                <fieldset>
                                    <h2>Informações de sua conta</h2>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Usuário *</label>
                                                <input id="userName" name="userName" type="text" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$">
                                            </div>
                                            <div class="form-group">
                                                <label>Senha *</label>
                                                <input id="password" name="password" type="text" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$">
                                            </div>
                                            <div class="form-group">
                                                <label>Repita a senha *</label>
                                                <input id="confirm" name="confirm" type="text" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$">
                                            </div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <div class="form-group">
                                                <label>Email *</label>
                                                <input id="email" name="email" type="text" class="form-control required email" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="text-center">
                                                <div style="margin-top: 20px">
                                                    <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <h1>Questionário</h1>
                                <fieldset>
                                    <h2>Você entende de RolePlay?</h2>
                                    <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                        <div class="text-left">
                                            <label>1. O que é OOC?</label>
                                            <div class="i-checks"><label> <input name="pergunta-1" type="radio" value="1"> <i></i> OOC é quando eu dou tiros em uma gangue rival. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-1" type="radio" value="2"> <i></i> OOC é toda e qualquer conversa que não seja relacionada ao meu personagem IC.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-1" type="radio" value="3"> <i></i> OOC é uma ação impossível de ser feita na vida real, ou quando o player abusa do Roleplay para se favorecer. </label></div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <label>2. Quando eu posso disparar tiros contra outro jogador?</label>
                                            <div class="i-checks"><label> <input name="pergunta-2" type="radio" value="1"> <i></i> Quando o jogador bater no meu carro, e se recusar a pagar o conserto. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-2" type="radio" value="2"> <i></i> Quando eu descobrir que ele é de uma Gang/Máfia Rival.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-2" type="radio" value="3"> <i></i> Quando eu tiver um motívo real, como por exemplo: O outro jogador me ameaça de morte e fica me seguindo. </label></div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <label>3. Você está em seu bairro, na calçada, e percebe um mesmo veículo passando diversas vezes, o que você faz?</label>
                                            <div class="i-checks"><label> <input name="pergunta-3" type="radio" value="1"> <i></i> Atiro contra o veículo e lanço "G-signs" em direção ao mesmo. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-3" type="radio" value="2"> <i></i> Nada, afinal a rua é pública. Por segurança, entro em casa ou vou a outro lugar.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-3" type="radio" value="3"> <i></i> Entro no meu carro e persigo o veículo até ele parar e pergunto o por que estão passando várias vezes no meu bairro. </label></div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <label>4. Você está passando de carro e vê dois players trocando tiros, qual a sua reação?</label>
                                            <div class="i-checks"><label> <input name="pergunta-4" type="radio" value="1"> <i></i> Vou para longe do local e ligo para a policia, informando sobre o incidente. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-4" type="radio" value="2"> <i></i> Paro o carro e fico assistindo para ver quem vai morrer.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-4" type="radio" value="3"> <i></i> Pego uma arma e vou atirar também. </label></div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <label>5. Você está andando de carro, e derrepente passa uma viatura perseguindo outro carro, o que você faz?</label>
                                            <div class="i-checks"><label> <input name="pergunta-5" type="radio" value="1"> <i></i> Sigo os veículos em perseguição para ver o que está acontecendo. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-5" type="radio" value="2"> <i></i> Continuo meu caminho para onde eu estava indo.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-5" type="radio" value="3"> <i></i> Tento bater no carro que está fugindo para ajudar a policia. </label></div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <label>6. Você esta em um bar e começa uma discussão com outro jogador, ele sai do bar, e após alguns segundos, volta com um bastão de baseball, qual a sua reação?</label>
                                            <div class="i-checks"><label> <input name="pergunta-6" type="radio" value="1"> <i></i> Bato nele com socos, afinal ele só está com um bastão. </label></div>
                                            <div class="i-checks"><label> <input name="pergunta-6" type="radio" value="2"> <i></i> Saco uma arma e dou tiros nele até que ele caia ferido no chão.</label></div>
                                            <div class="i-checks"><label> <input name="pergunta-6" type="radio" value="3"> <i></i> Tento amenizar a situação para que não tenha briga, ou corro para meu carro e vou embora. </label></div>
                                            
                                        </div>
                                    
                                </fieldset>

                                <h1>Personagem</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h2>Informações do personagem</h2>
                                            <div class="form-group">
                                                <label>Nome do personagem * <font size="-8">( Nome_Sobrenome )</font></label>
                                                <input id="persName" name="persName" type="text" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$">
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
                                                <textarea id="hist-pers" name="hist-pers" class="form-control required" style="min-height:150px;" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div style="border-bottom:3px solid #E5E5E5; margin-bottom:12px;"></div>
                                            <h2>- Perguntas OOC -</h2>
                                            <div class="form-group">
                                                <label>Defina Roleplay *</label>
                                                <textarea minlength="5" id="def-rol" name="def-rol" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>O que é Metagaming? Dê três exemplos. *</label>
                                                <textarea minlength="5" id="def-mg" name="def-mg" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Quando você pode matar outro jogador? Dê três exemplos. *</label>
                                                <textarea minlength="5" id="def-matar" name="def-matar" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>O que é Fear RP? Dê três exemplos. *</label>
                                                <textarea minlength="5" id="def-fear" name="def-fear" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>O que é Powergaming? Cite três exemplos. *</label>
                                                <textarea minlength="5" id="def-pg" name="def-pg" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>O que é IC e OOC? Cite três exemplos de cada. *</label>
                                                <textarea minlength="5" id="def-ioc" name="def-ioc" class="form-control required" pattern="^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b-]+$"></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </fieldset>

                                <h1>Termos de jogo</h1>
                                <fieldset>
                                    <h2>Termos e condições</h2>
                                    <div class="form-group text-left">
                                        <p>1. Qualquer usuário que infringir normas e/ou regras do servidor, poderá ser banido sem aviso prévio, perdendo todo o progresso de seus personagens.</p>
                                        <p>2. Não temos qualquer tipo de responsabilidade por transtornos que o jogo venha a causar para algum jogador.</p>
                                        <p>3. Não é permitida a interpretação de estupro, canibalismo, pedofilia, necrofilia, mutilação, atentados terroristas, e qualquer tipo de assédio sexual.</p>
                                        <p>4. Não é permitido a divulgação de outro servidor dentro das mediações do PR:RP, seja via fórum ou In Game.</p>
                                        <p>5. Não nos responsabilisamos por usuários que utilizam o jogo falso.</p>
                                        <p>6. Não são permitidas modificações que tragam vantagens ao seu jogo.</p>
                                        <p>7. Não é permitido denigrir a imagem de outros jogadores e servidores nas mediações do PR:RP.</p>
                                        <p>8. Não nos responsabilizamos por exposição da própria imagem na rede.</p>
                                        <p>9. É de nossa responsabilidade a confidencialidade de dados de registro dos usuários(Como senha e email).</p> 
                                        <p>10. Qualquer dinheiro doado do servidor, <b>NÃO TERÁ DIREITO A DEVOLUÇÃO</b> por qualquer que seja o motivo.</p>
                                        <p>11. Todo e qualquer video gravado no servidor, poderá ser utilizado para campanhas de divulgação sem que os direitos de imagem sejam cobrados por quem gravou.</p>
                                        <p>12. Não incentivamos qualquer tipo de violencia. Todos os acontecimentos são causamos por escolhas de quem joga.</p>
                                        <p>13. Não nos responsabilizamos por menores de idade que possam vir a jogar.</p>
                                        <p>14. Não nos responsabilizamos por quem faltar na aula para jogar.</p>
                                        <p>15. Não nos responsabilizamos por ocasionais brigas com a familia por conta de você estar a muito tempo no computador.</p>
                                        
                                    </div>
                                    <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">Eu aceito os termos e condições.</label>
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
            var usuario_existe = 0; 
            var email_existe = 0; 
            var pers_existe = 0; 
            var usuario_comespaco = 0;
            var pers_comespaco = 0;
            var pers_semunder = 0;
            
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex, nvar)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }
                    
                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 13)
                    {
                        return false;
                    }
                    if(newIndex === 2)
                    {
                        var errou = 0;
                        // Variáveis das perguntas
                        var pergunta1=$('input[name=pergunta-1]:checked', '#form').val()
                        var pergunta2=$('input[name=pergunta-2]:checked', '#form').val()
                        var pergunta3=$('input[name=pergunta-3]:checked', '#form').val()
                        var pergunta4=$('input[name=pergunta-4]:checked', '#form').val()
                        var pergunta5=$('input[name=pergunta-5]:checked', '#form').val()
                        var pergunta6=$('input[name=pergunta-6]:checked', '#form').val()

                        if(pergunta1 != 2) errou++;
                        if(pergunta2 != 3) errou++;
                        if(pergunta3 != 2) errou++;
                        if(pergunta4 != 1) errou++;
                        if(pergunta5 != 2) errou++;
                        if(pergunta6 != 3) errou++;
                        
                        if(errou == 1)
                        {
                            swal("Registro", "Você errou "+errou+" resposta! ", "error");
                            return false;
                        }
                        else if(errou > 1)
                        {
                            swal("Registro", "Você errou "+errou+" respostas! ", "error");
                            return false;
                        }
                        else 
                        {
                            swal("Registro!", "Você acertou todas as respostas!.", "success")   
                        }

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
                            if(usuario_existe == 1) 
                            {
                                swal("Registro", "Este nome de usuário já está em uso! ", "error");
                                return false;
                            }
                            else if(email_existe == 1) 
                            {
                                swal("Registro", "Este email já está em uso! ", "error");
                                return false;
                            }
                            else if(usuario_comespaco == 1) 
                            {
                                swal("Registro", "Seu nome de usuário não pode conter espaço! ", "error");
                                return false;
                            }
                            else
                            {
                                return form.valid();
                            }
                        }
                    }
                    else if(newIndex === 3)
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
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 13)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);
                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    //var form = $(this);
                    // Submit form input
                    //form.submit();
                    
                    //Pagina 1
                    var login=$('#userName').val();
                    var senha=$('#password').val();
                    var passconf=$('#confirm').val();
                    var email=$('#email').val();
                    //Pagina 2
                    var charname=$('#persName').val();
                    var localnasc=$('#local-nasc').val();
                    var nascdate=$('#nasc-date').val();
                    var genero=$('#genero').val();
                    var histpers=$('#hist-pers').val();
                    //Confirma dados
                    if(senha != passconf)
                    {
                        swal("Registro", "A senha e a confirmação da senha não coincidem! ", "error");
                        return false;
                    }
                    else if(login == senha)
                    {
                        swal("Registro", "A sua senha não pode ser o seu nome de usuário! ", "error");
                        return false;
                    }
                    else
                    {
                        var form = $(this);
                        form.submit();
                    }
                    
                    
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });

            $('#userName').focusout(function(){     //Ao submeter formulário
                var qnt = 0;
                var campo = document.getElementById("userName");
                var i=0;
                for(i=0;i<campo.value.length;i++)
                {
                    if(campo.value[i] == " ")
                    {
                        qnt++;
                    }
                }   
                if(qnt > 0)
                {
                    swal("Registro", "Seu nome de usuário não pode conter espaço! ", "error");
                    usuario_comespaco = 1;
                }
                else 
                {
                    usuario_comespaco = 0;
                
                    var login=$('#userName').val(); //Pega valor do campo email
                    $.ajax({            //Função AJAX
                        url:"func/ver_user.php",            //Arquivo php
                        type:"post",                //Método de envio
                        data: "login="+login,   //Dados
                        success: function (result){ //Sucesso no AJAX
                            //alert(result);
                            if(result==1)
                            {
                                swal("Registro", "Este nome de usuário já está em uso! ", "error");
                                usuario_existe = 1;
                            }
                            else usuario_existe = 0;
                        }
                    })
                    return false;   //Evita que a página seja atualizada
                }
            });
            $('#email').focusout(function(){    //Ao submeter formulário
                var email=$('#email').val();    //Pega valor do campo email
                $.ajax({            //Função AJAX
                    url:"func/ver_email.php",           //Arquivo php
                    type:"post",                //Método de envio
                    data: "email="+email,   //Dados
                    success: function (result){ //Sucesso no AJAX
                            //alert(result);
                        if(result==1)
                        {
                            swal("Registro", "Este email já está em uso!", "error");
                            email_existe = 1;
                        }
                        else email_existe = 0;
                    }
                })
                return false;   //Evita que a página seja atualizada
            })
            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });
            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
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
       //=======================
    </script>
</body>
</html>
