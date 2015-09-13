       <div class="form_wrapper">
       <?=form_open('','  class="login"');?>
			
               <h4 style="color: red;"><?=$error_login;?></h4>
				<h3>Вход на сайт</h3>
      
                <?php  $e_user =  form_error('user'); ?>
                <?php $e_pass =  form_error('pass'); ?>
				<div class="field_cont  <?=empty($e_user)?'"':'no_valid"';?>">
					<label for="person_mail" class="field"><?=lang('user');?>:<span>*</span></label>
					<input type="text" name="user" value="<?php echo set_value('user'); ?>" id="person_mail"/>
					<span class="error"><?=$e_user;?></span>
                    
				</div>
				<div <?=empty($e_pass)?'':'class="no_valid"';?> >
                	<a href="/forum/ucp.php?mode=sendpassword" class="forgot">Забыли пароль?</a>
                    <div class="clear"></div>
					<label for="person_passwd" class="field"><?=lang('pass');?>:<span>*</span></label>
					<input type="password" name="pass" id="person_passwd"/>
					<span class="error"><?=$e_pass;?></span>
                    
                </div>
				<div class="bottom">
					<div class="check">
						<div class="remember">
							<input type="checkbox" id="remember_me"/>
							<label for="remember_me">Запомнить меня</label>
						</div>
                    </div>
                 	<input type="submit" value="<?=lang('enter');?>" />
                    <a href="/forum/ucp.php?mode=register" rel="login" class="linkform">Не зарегистрированы? Регистрация здесь</a>
					<div class="clear"></div>
				</div>
			<?=form_close();?>
         </div>  