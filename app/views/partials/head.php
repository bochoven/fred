<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>F.R.E.D.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?=WEB_FOLDER?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?=WEB_FOLDER?>assets/css/datatables-bootstrap.css" rel="stylesheet">
    <link href="<?=WEB_FOLDER?>assets/css/datepicker.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      #item_list i{
          font-style:normal;
          padding-left: .5em;
        }
    </style>
    <link href="<?=WEB_FOLDER?>assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?=WEB_FOLDER?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?=WEB_FOLDER?>assets/css/fullcalendar.css" rel="stylesheet">
    <link href="<?=WEB_FOLDER?>assets/css/fullcalendar.print.css" rel="stylesheet" media="print">


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=WEB_FOLDER?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=WEB_FOLDER?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=WEB_FOLDER?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?=WEB_FOLDER?>assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">F.R.E.D.</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
            </p>
            <ul class="nav">
              <?$page = $GLOBALS[ 'engine' ]->get_uri_string(); $navlist = array( 
                'user/reservations' => (object) array('icon' => 'beaker', 'title' => 'Reservations'), 
                'user/calendar' => (object) array('icon' => 'calendar', 'title' => 'Calendar'), 
                'admin' => (object) array('icon' => 'wrench', 'title' => 'Administration'), 
                'user/inventory' => (object) array('icon' => 'list-ul', 'title' => 'Inventory list') 
                )?>
                <?foreach($navlist as $url => $obj):?>
              <li <?=$page==$url?'class="active"':''?>>
                <a href="<?=url($url)?>"><i class="icon-<?=$obj->icon?>"></i> <?=$obj->title?></a>
              </li>
                <?endforeach?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>