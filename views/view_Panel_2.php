<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $pageTitle =   $data['pageTitle'];  //title of the page
 $menuNav   =   $data['menuNav'];    // an array of menu items and associated URLS
 $stringPanel_1 =    $data['stringPanel_1'];  // A string intended of the Left Hand Side of the page
 $stringPanel_2 =    $data['stringPanel_2']; // A string intended of the Right Hand Side of the page
 $panelHead_1=$data['panelHead_1'];// A string containing the LHS panel heading/title
 $panelHead_2=$data['panelHead_2'];// A string containing the RHS panel heading/title
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pageTitle;?></title>
<!--
--Load the bootstrap scripts by reference
--Note the use of the 'integrity' property
--More info on that property here: https://blog.compass-security.com/2015/12/subresource-integrity-html-attribute/
-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!--apply any local styles if required -->
<style type="text/css">
    body{
        padding-top: 70px;
    }
    
     .panel-body  {
    word-break:break-all
    }
    
</style>
</head> 

<body>
<!--Main SECTION--> 
<section>
<!--Top of page Navigation menus-->    
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><?php echo $pageTitle?></a>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
		<?php foreach($menuNav as $menuItem){echo "<li>$menuItem</li>";} //populate the navbar menu items?>
            </ul>
        </div>
    </div>
</nav>

<!--Main container for page content-->  
<div class="container" >

<div class="row">
    <!--LEFT content panel - PANEL 1 --> 
    <div class="col-md-6" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHead_1; ?></div>
              <div class="panel-body" id="panel_body_1">
                  <!--Query form will appear here-->
                  <?php echo $stringPanel_1; ?>
              </div>
            </div>
    </div>
    <!--Right Hand Side (RHS) content panel - PANEL 2 --> 
    <div class="col-md-6" style="background-color:white;">
            <div class="panel panel-default">
              <div class="panel-heading"><?php echo $panelHead_2; ?></div>
              <div class="panel-body"  id="panel_body_2">
                  <!--Query results will appear here-->
                  <?php echo $stringPanel_2; ?>
              </div>
            </div>
    </div>
</div>
    
</div>  <!--end of main container-->
</section>   