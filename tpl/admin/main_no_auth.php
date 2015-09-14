<!DOCTYPE HTML>
<html lang="ru">
<head>
<title>Webcapitan Admin panel</title>
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
            <a href="<?=site_url('admin');?>">
                <img src="/img/admin/WebCapitan.png" alt="" width="150" height="30">
            </a>
        </div>
    </header>
 
<?=$content;?>

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


