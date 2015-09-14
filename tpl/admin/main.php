<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> WebCapitan admin </title>
  <link href="/css/admin/reset.css" rel="stylesheet" type="text/css">
  <?php foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
  <?php endforeach; ?>
  <link href="/css/admin/glyphicons.css" rel="stylesheet" type="text/css">
  <link href="/css/admin/font-awesome.css" rel="stylesheet" type="text/css">
  <link href="/css/admin/select2.css" rel="stylesheet" type="text/css">
  <link href="/css/admin/chosen.css" rel="stylesheet" type="text/css">
  <link href="/css/admin/ion.checkRadio.css" rel="stylesheet" type="text/css">
  <link href="/css/admin/admin.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/js/admin/jquery-1.11.1.min.js"></script>
  <?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
  <?php endforeach; ?>
  

  <script type="text/javascript" src="/js/admin/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="/js/admin/chosen.jquery.min.js"></script> 
  <script type="text/javascript" src="/js/admin/select2.min.js"></script>
  <script type="text/javascript" src="/js/admin/ion.checkRadio.min.js"></script> 
  <script type="text/javascript" src="/js/admin/js.js"></script>
  <script type="text/javascript" src="/js/admin/admin_script.js"></script> 
  <!--[if IE]>
    <link rel="stylesheet" type="text/css"  href="/css/admin/style_ie.css" /> 
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
  
  <!-- header -->
  <header id="header">
    <div class="logo">
      <a href="<?=site_url();?>">
        <img src="/img/admin/WebCapitan.png" alt="" width="150" height="30">
      </a>
    </div>
    <div class="btn_group pull-right">
      <div class="login_nfo">
        
          <img src="<?=image_thumb('upls/users/'.$user->img,50,50);?>" width="30" height="30">

          <span> <?=$user->name;?></span>
        
      </div>
      
      
       

        <a href="<?=site_url('admin/auth/logout')?>" class="btn">
          <span class="glyphicon glyphicon-log-out"></span>
        </a>
       
      
     

    </div>
     <nav class="navbar_menu">
        <ul>
          <?php foreach($menu as $k=>$v):?>
          <li>
            <?php if(is_array($v)):?>
            <li>
             <?php foreach($v as $ke=>$va ):?>
             <a href="<?=site_url($ke)?>">
                <span class="menu-item-parent"><?=$k;?></span>
              </a>
              <ul>
                  <?php foreach($va as $key=>$val):?>
                  <li>  
                    <a href="<?=site_url($key)?>"><?=$val;?></a>
                  </li>
                  <?php endforeach;?>
              </ul>
              <?php endforeach;?>
           </li>  
           <?php else:?> 
             <a href="<?=site_url($k)?>"><?=$v;?></a>
           <?php endif;?>
         </li>
         <?php endforeach;?> 
        </ul>
      </nav>
    
  </header>
  <!-- end-of-header -->

  <!-- content -->
  <main id="main">
  
    <div class="container">
      <div class="brd_crb">
        <ul>
          <?php foreach($breadcrumbs as $k=>$v):?>
           <li><a href="<?=site_url($k);?>"><?=$v;?></a></li>
          <?php endforeach;?>
        </ul>
      </div>
      <div class="content">
        <div class="widjet_item">
          <header>
             <h1><?=$current_section;?></h1>
          </header>
          <div class="inner_body">
              <?php echo $output; ?>
          </div>
        </div>
      </div>
      
    </div>

    <!-- footer -->
    <footer id="footer">
      <div id="copiright_web">
        <p>Разработано <a href="http://www.webcapitan.com/" target="_blank">Webcapitan.com</a> 2012 - <?=date('Y');?></p>
      </div>
    </footer>
    <!-- end-of-footer -->
  </main>
  <!-- end-of-content -->

  


</body>
</html>








