<?php

require('template.php');
require('lib/TumblrBlog.php');

$getPostId = htmlspecialchars($_GET["post_id"]);
$currentPage = htmlspecialchars($_GET["page"]);
if (!$currentPage) {
  $currentPage = 1;
}

$singlePost = false;
if ($getPostId && is_numeric($getPostId)) {
  $singlePost = true;
  $getPostId = (int) $getPostId;
}

try {
  $tBlog = new TumblrBlog('bendalziel');
  if ($singlePost) {
    $posts = $tBlog->getPost($getPostId);
  }
  else {
    $posts = $tBlog->getPosts($currentPage);
  }
}
catch (Exception $e) {
}

$page_title = "Ben Dalziel's Blog. <small>From new to old.</small>";

$entriesMarkup = '';
foreach ($posts as $post) {
  $postMarkup = (!$singlePost) ? $post->toHtml() : $post->bodyToHtml();

  $tags = $post->getTags();
  $tagsMarkup = implode(' | ' , $tags);

  $entriesMarkup .= <<<HTML
        <li class="well">
          <div class="{$post_classes}">
            {$postMarkup}
            <h5>Tags: <small>{$tagsMarkup}</small></h5>
          </div>
        </li>
HTML;
  if ($singlePost) {
    $page_title = $post->getTitle() . ". <small><a href=\"blog.php\">Ben Dalziel's Blog</a></small>";
    break;
  }
}

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

$paginationMarkup = '';
$pageCount = $tBlog->getPageCount();
if (!$singlePost && $pageCount > 1) {
  $pageTabs = '';
  for ($i = 1; $i <= $pageCount; $i++) {
    $tabUrl = '?page=' . $i;
    $tabClasses = array();
    if ($i == $currentPage) {
      $tabClasses[] = 'active';
      $tabUrl = '#';
    }
    $tabClasses = implode(' ', $tabClasses);

    $pageTabs .= <<<HTML
    <li class="{$tabClasses}"><a href="{$tabUrl}">{$i}</a></li>
HTML;
  }

  $prevUrl = '?page=' . (int) ($currentPage - 1);
  $nextUrl = '?page=' . (int) ($currentPage + 1);
  $prevClasses = array('prev');
  $nextClasses = array('next');
  if ($currentPage == 1) {
    $prevClasses[] = 'disabled';
    $prevUrl = '#';
  }
  if ($currentPage == $pageCount) {
    $nextClasses[] = 'disabled';
    $nextUrl = '#';
  }
  $prevClasses= implode(' ', $prevClasses);
  $nextClasses= implode(' ', $nextClasses);

  $paginationMarkup .= <<<HTML
<div class="pagination">
  <ul>
    <li class="{$prevClasses}"><a href="{$prevUrl}">&larr; Previous</a></li>
    {$pageTabs}
    <li class="{$nextClasses}"><a href="{$nextUrl}">Next &rarr;</a></li>
  </ul>
</div>
HTML;
}

$comments = '';
if ($singlePost) {
  $comments = <<<HTML
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="bendalziel.com/blog.php?post_id={$getPostId}" num_posts="5" width="940"></fb:comments>
HTML;
}

print render_page($page_title, strip_tags($page_title), 'blog', $page_content . $paginationMarkup . $comments);

?>
