<!DOCTYPE HTML>
<html lang="ru">
<head>
<title>Вход в панель управления сайтом</title>
<meta charset="UTF-8" />

<link rel="stylesheet" type="text/css" href="/css/admin/reset.css">
<link rel="stylesheet" type="text/css" href="/css/admin/admin.css">
<!--[if IE]>
    <link rel="stylesheet" type="text/css"  href="/css/admin/style_ie.css" /> 
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body class="login_page">

    <!-- header -->
    <header id="header">
        <div class="logo">
            <a href="">
                <img src="/img/WebCapitan.png" alt="" width="150" height="30">
            </a>
        </div>
    </header>
    <?=$messages;?>
    <main id="main" >
        <div class="login_container">
        
            <div class="box login">
                <?=form_open('','  id="enter_form"')?>
                <?=lang('forgot_password');?>
                <fieldset class="boxBody">
                    <label>Email</label>
                    <input type="text" name="email" tabindex="1" placeholder="Email" id="login">
                    <?=form_error('email');?>
                </fieldset>
                <footer>
                    <button type="submit" class="btnLogin"  id="submit" >Enter</button>
                </footer>
                <?form_close();?>
                </div>
        </div>
    </main>

    <!-- footer -->
    <footer id="footer">
        <div id="copiright_web">
            <p>Разработано <a href="http://www.webcapitan.com/">Webcapitan.com</a> 2012-2014</p>
        </div>
    </footer>
    <!-- end-of-footer -->
<script type="text/javascript" src="/js/admin/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/admin/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/js/admin/scripts.js"></script>
</body>
</html>


