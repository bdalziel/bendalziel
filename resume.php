<?php

require('template.php');

$title = 'Ben Dalziel\'s R&#233;sum&#233;. <small>Senior Software Engineer @ Sly Trunk.</small>';

$page_content = <<<HTML
  <section>
    <div class="page-header">
      <h1>{$title}</h1>
    </div>

      <p></p>

    <div class="row">
      <div class="span16 columns shadow">
        <img src="assets/img/timeline.png" alt="Ben Dalziel's Visual Reume: A time line of education and professional experience" title="Ben Dalziel's Visual Resume: A time line of education and professional experience" width="900px" width="480px" />
      </div>
    </div>

  </section>

  <section>

    <h1>The Story So Far.</h1>

    <div class="row">
      <div class="span-one-third columns">
        <h2>Chapter 1. <small>Graduate.</small></h2>
  <p>At Durham, I worked behind the college bar and I played rugby. My proudest achievement was captaining the rugby team to a win in the final of the prestigious Floodlit Cup Trophy.</p>
        <p>During a summer internship at IBM, I co-invented a tool for developing Aspect Oriented applications, and implemented it for my final year project.</p>
      </div>

      <div class="span-one-third columns">
        <h2>Chapter 2. <small>Master.</small></h2>
        <p>I developed novel software that enabled biologists to immerse themselves in their enormous data sets. Specializing in CS for the Life Sciences, I grew the research out of a remarkable diseased placenta data set in collaboration with a team at the University of California, San Francisco.</p>
      </div>

      <div class="span-one-third columns">
        <h2>Chapter 3. <small>Professional.</small></h2>
        <p>From the Olympics and World Cup to Major League Baseball and the NFL, I wrote code that brought the magic of sports to users of the most visited sports site in the world.</p>
        <p>A new chapter is beginning as I transition to front end web development.</p>
      </div>
    </div>

    <div class="row">
      <div class="span-one-third columns">
        <div class="well">Java | Maple | AspectJ | Eclipse</div>
      </div>
      <div class="span-one-third columns">
        <div class="well">Java | R | MySQL | XML | NetBeans</div>
      </div>
      <div class="span-one-third columns">
  <div class="well">PHP | MySQL | JS | CSS | Emacs</div>
      </div>
    </div>


  </section>

HTML;

print render_page($title, 'Ben Dalziel\'s R&#233;sum&#233;', 'resume', $page_content, "resume.php");

?>
