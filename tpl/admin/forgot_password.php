
    
    <main id="main" >



        <div class="login_container">
        
            <div class="box login">
                <?=form_open('','  id="enter_form"')?>
                
                <fieldset class="boxBody">
                    <label>Email</label>
                    <input type="text" name="email" tabindex="1" placeholder="Email" id="login">
                    <?=form_error('email');?>
                    <?=$message;?>
                </fieldset>
                <footer>
                   
                    <div class="fgp_button">
                       <button type="submit" class="btnLogin"  id="submit" ><?=lang('forgot_password');?> </button> 
                    </div>
                </footer>
                <?form_close();?>
                </div>
        </div>
    </main>


