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

$paginationMarkup = '';
if (!$singlePost) {
  $pageCount = $tBlog->getPageCount();
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

print render_page($page_title, 'Ben Dalziel\'s Blog', 'blog', $page_content . $paginationMarkup);

?>
