
    <!-- end-of-header -->
    <main id="main" >
        <div class="login_container">
            <div class="box login">
                <?=form_open('','  id="enter_form"')?>
                <fieldset class="boxBody">   
                <?=$message;?>
                
                    <label><?=lang('login');?></label>
                    <input type="text" name="username" tabindex="1" placeholder="<?=lang('login');?>" id="login">
                    <?=form_error('username');?>
                    <label><?=lang('password');?></label>
                    <input type="password" name="password" tabindex="2" id="password">
                    <?=form_error('password');?>
                </fieldset>
                <span>
                <a href="<?=site_url('admin/forgot_password');?>"><?=lang('forgot_password');?></a></span>
                <footer>
                    <button type="submit" class="btnLogin"  id="submit" ><?=lang('enter');?></button>
                </footer>
                <?form_close();?>
                
            </div>
        </div>
    </main>




