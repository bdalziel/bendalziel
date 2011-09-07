<?php

require('template.php');
require('lib/TumblrBlog.php');

$getPostId = htmlspecialchars($_GET["post_id"]);
$getPage = htmlspecialchars($_GET["page"]);

$single_post = false;
if ($getPostId && is_numeric($getPostId)) {
  $single_post = true;
  $getPostId = (int) $getPostId;
}

try {
  $tBlog = new TumblrBlog('bendalziel');
  if ($single_post) {
    $posts = $tBlog->getPost($getPostId);
  }
  else {
    $posts = $tBlog->getPosts($getPage);
  }
}
catch (Exception $e) {
}

$entriesMarkup = '';
foreach ($posts as $post) {
  $postMarkup = $post->toHtml();
  $entriesMarkup .= <<<HTML
        <li class="well">
          <div class="{$post_classes}">
            {$postMarkup}
          </div>
        </li>
HTML;
}

$page_title = "Ben Dalziel's Blog";
$page_content = <<<HTML
  <section>
    <div class="page-header">
      <h1>{$page_title}</h1>
    </div>
    <div id="blog-container">
      <ul>
        {$entriesMarkup}
      </ul>
    </div>
  </section>
HTML;

print render_page($page_title, 'Ben Dalziel\'s Blog', 'blog', $page_content);

?>
