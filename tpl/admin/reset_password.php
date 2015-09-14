    <main id="main" >
        <div class="login_container">
            <div class="box login reset">
				<h1><?php echo lang('reset_password_heading');?></h1>

				<div id="infoMessage"><?=$message;?></div>
					

						<?php echo form_open('admin/auth/reset_password/' . $code);?>

						<fieldset class="boxBody">

							<label for="new_password"><?=sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> 
							<?=form_password('new_password');?>
						    <?=form_error('new_password');?>
							
							<?=lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
							<?=form_password('new_password_confirm');?>
						    <?=form_error('new_password_confirm');?>

						</fieldset>

					    <footer>
					    	<div class="fgp_button">
					    		<?php echo form_submit('submit' ,  lang('reset_password_submit_btn') , 'class="btnLogin"');?>
					    	</div> 
		                    
		                </footer>



						

					<?php echo form_close();?>
				

        </div>
        </div>
    </main>

