<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
    	<h2>FAQ — Frequently Asked Questions</h2>
       	<ol class="breadcrumb">
        	<li>
            	<a href="inicio">Início</a>
            </li>
            <li class="active">
            	<strong>Perguntas Frequentes</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
    	<div class="wrapper wrapper-content animated fadeInRight">
        	<div class="ibox-content m-b-sm border-bottom">
            	<div class="text-center p-lg">
                	<h2>Clique sobre a pergunta para exibir a resposta!</h2>
                </div>
            </div>
			<?php
			$result = $mysqli->query("SELECT * FROM `ucp_faq`");
			while($row = $result->fetch_array()){
			?>
            	<div class="faq-item">
                	<div class="row">
                    	<div class="col-md-7">
                        	<a data-toggle="collapse" href="#faq<?=$row['id'];?>" class="faq-question"><?php echo utf8_encode($row['pergunta']); ?></a>
                        </div>
                    </div>
                 	<div class="row">
                    	<div class="col-lg-12">
                        	<div id="faq<?=$row['id'];?>" class="panel-collapse collapse ">
                            	<div class="faq-answer">
                                	<p>
                                   		<?=nl2br($row['resposta']);?>
                                    </p>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
                <?php
			}
				?>
		</div>
	</div>
    <?php include('ads.php'); ?>
</div>
<div class="footer">
	<div>
    	<?=$footer;?>
    </div>
</div>

    
