<?php

require('runkeeper.php');
require('template.php');

$title = "Running 250 miles. <small>In 3 months</small>";

$markup = '';



$cdate = mktime(0, 0, 0, 12, 31, 2011, 0);
$today = time();
$difference = $cdate - $today;
$remainingDays = floor($difference/60/60/24);

$html = getUserActivities("tigerkitten");
$bTotal = (float) getCompetitionTotalMiles($html, 9);
$bCycMiles = (float) $bTotal*(float) ((float) 800/(float) 250);
$bRemaining = 250-$bTotal;
$bRemPace = $bRemaining/$remainingDays;
$bPerc = (float) ($bTotal/ 2.5);

$markup .= <<<HTML
<tr>
    <td><strong><a href="http://runkeeper.com/user/tigerkitten/activity/">Ben</a></strong> (running)</td><td>{$bTotal}</td><td>{$bPerc}</td><td>{$bRemaining}</td><td>{$bRemPace}</td>
</tr>
HTML;


$html = getUserActivities("DaddyRoundRound");
$cTotal =  getCompetitionTotalMiles($html, 6);
$cRunMiles = (float) $cTotal/(float) ((float) 800/(float) 250);
$cRemaining = 800-$cTotal;
$cRemPace = $cRemaining/$remainingDays;
$cPerc = (float) ($cTotal/ 8);

$markup .= <<<HTML
<tr>
    <td><strong><a href="http://runkeeper.com/user/DaddyRoundRound/activity/">Cris</a></strong> (cycling)</td><td>{$cTotal}</td><td>{$cPerc}</td><td>{$cRemaining}</td><td>{$cRemPace}</td>
</tr>
HTML;

$diff = ((float) $bTotal - $cRunMiles);
$status =  "<div class=\"alert-message " . (($diff < 0) ? "error" : "success") . "\">My status: <strong>" . ((float) $bTotal - $cRunMiles) . "</strong> miles " . ((($diff >= 0)) ? "ahead" : "behind") . "</div>";

$markup = <<<HTML
  <section>
    <div class="page-header">
      <h1>{$title}</h1>
    </div>

    <p>I have to run 250 miles before the end of 2011. Cris is aiming to cycle 800 miles. If only one of us achieves our goal, the loser has to pay for an all you can eat day for the winner and their family. There are also lesser sub goals to keep things interesting along the way.</p>

    <table class="zebra-striped">
      <thead>
        <tr><th>Competitor</th><th>Miles Done</th><th>% Done</th><th>Miles Remaining</th><th>Remaining Miles/day</th></tr>
      </thead>
      <tbody>
        {$markup}
      </tbody>
    </table>

    <div class="row">
      <div class="span-one-third offset-one-third">
        {$status}
      </div>
      <div class="span-one-third">
        <iframe src="//www.facebook.com/plugins/like.php?href=bendalziel.com%2Fcompetition.php&amp;send=false&amp;layout=button_count&amp;width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=234718439919013" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
      </div>
    </div>

  </section>

  <section>
    <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="bendalziel.com/competition.php" num_posts="5" width="940"></fb:comments>

  </section>
HTML;

print render_page($title, strip_tags($title), '', $markup, "competition.php");


?>