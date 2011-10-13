<?php

require('template.php');

$markup = <<<HTML

<iframe src="//www.facebook.com/plugins/activity.php?site=bendalziel.com&amp;width=300&amp;height=300&amp;header=true&amp;colorscheme=light&amp;linktarget=_blank&amp;border_color&amp;font&amp;recommendations=false&amp;appId=234718439919013" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:300px;" allowTransparency="true"></iframe>

HTML;

print render_page("Test", "Test", '', $markup);

?>
