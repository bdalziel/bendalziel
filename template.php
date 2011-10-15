<?php

function render_page ($title, $page_title, $page_type, $page_content, $path = '') {

  $nav = render_nav($page_type);

  $type = "website";
  $url = "http://bendalziel.com/" . $path;

  $page = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head>

  <title>{$page_title} | BenDalziel.com</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="description" content="The virtual home of Ben Dalziel">
  <meta name="keywords" content="Ben Dalziel, Benjamin Dalziel, Benjamin John Dalziel, Sly Trunk, Yahoo!, San Francisco, Yahoo! Sports, Resume, visual resume, CV, Curriculum Vitae, Profile">
  <meta property="fb:app_id" content="234718439919013"/>

  <meta property="og:title" content="{$page_title}"/>
  <meta property="og:type" content="{$type}"/>
  <meta property="og:url" content="{$url}"/>

  <meta property="og:image" content="http://bendalziel.com/assets/img/bdalziel.jpg"/>
  <meta property="og:site_name" content="BenDalziel.com"/>

  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="icon" href="favicon.ico" />

  <link rel="image_src" href="assets/img/bdalziel.jpg" />

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/main.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/lessless.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/nav.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bootstrap.css" />

<!--
  <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap-1.2.0.min.css">
-->


<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2650047-8']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

</head>
<body>

{$nav}

<div class="container">

  {$page_content}

</div>

<div id="footer">
  <div id="footer_container">
    <ul>
      <li class="first">&copy; <a href="index.php" alt="Ben Dalziel Home Page">Ben Dalziel</a> 2011</li>
      <li><a href="http://www.linkedin.com/in/bendalziel" title="Ben Dalziel's professional profile on LinkedIn">Profile</a></li>
      <li><a href="http://www.flickr.com/photos/bendalziel/" title="Ben Dalziel's photography on Flickr">Camera Roll</a></li>
      <li><a href="https://twitter.com/#!/bdalziel" title="Ben Dalziel on Twitter">@bdalziel</a></li>
      <li><a href="https://github.com/bdalziel" title="Ben Dalziel on github">github</a></li>
    </ul>
  </div>
</div>

</body>
</html>

HTML;

  return $page;
}

function render_nav ($page_type) {

  $active_1 = ($page_type == 'home') ? 'active' : '';
  $active_2 = ($page_type == 'resume') ? 'active' : '';
  $active_3 = ($page_type == 'blog') ? 'active' : '';
  return <<<HTML

<div id="nav">

  <section id="nav_container">
    <div class="container_back"></div>
    <div class="container_left"></div>
    <div class="container_right"></div>
    <div class="container_bottom"></div>
    <div class="container_top"></div>
    <div class="box box1 {$active_1}">
      <a href="index.php" title="Ben Dalziel's Home Page">
        <figure class="back"></figure>
        <figure class="right"></figure>
        <figure class="left"></figure>
        <figure class="top"></figure>
        <figure class="bottom"></figure>
        <figure class="front"><span>Home</span></figure>
      </a>
    </div>
    <div class="box box3 {$active_3}">
      <a href="blog.php" title="Ben Dalziel's Blog">
        <figure class="back"></figure>
        <figure class="right"></figure>
        <figure class="left"></figure>
        <figure class="top"></figure>
        <figure class="bottom"></figure>
        <figure class="front"><span>Blog</span></figure>
      </a>
    </div>
    <div class="box box2 {$active_2}">
      <a href="resume.php" title="Ben Dalziel's R&#233;sum&#233;">
        <figure class="back"></figure>
        <figure class="right"></figure>
        <figure class="left"></figure>
        <figure class="top"></figure>
        <figure class="bottom"></figure>
	<figure class="front"><span>R&#233;sum&#233;</span></figure>
      </a>
    </div>
    <div class="title">BenDalziel.com<a href="https://github.com/bdalziel/3D-CSS3-Transform-Nav" title="This CSS 3D nav area is available on github">*</a></div>
  </section>

</div>

HTML;
}

?>
