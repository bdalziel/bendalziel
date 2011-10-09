<?php

require_once('template.php');
require_once('lib/TumblrBlog.php');
require_once('lib/TumblrPost.php');
require_once('lib/TumblrPostRenderer.php');
require_once('lib/TumblrBlogRenderer.php');

$getPostId   = (isset($_GET["post_id"])) ? htmlspecialchars($_GET["post_id"]) : '';
$currentPage = (isset($_GET["page"])) ? htmlspecialchars($_GET["page"]) : '';
if (!$currentPage) {
  $currentPage = 1;
}

$tBlog            = new TumblrBlog('bendalziel');
$blogRenderer     = new TumblrBlogRenderer($tBlog, 
					   (($currentPage) ? $currentPage : 1), 
					   (($getPostId) ? $getPostId : null));
$pageTitle        = "Ben Dalziel's Blog."; //$blogRenderer->getPageTitle();
$postsMarkup      = $blogRenderer->renderPosts();
$paginationMarkup = $blogRenderer->renderPagination();


if ($blogRenderer->isSinglePost()) {
    $allBlogRenderer     = new TumblrBlogRenderer($tBlog,  1, null);
    $postsListMarkup = $allBlogRenderer->renderPostsList($getPostId);
    $page_content = <<<HTML
  <section>
    <div class="page-header">
    <h1>{$pageTitle}</h1>
    </div>
    <div id="blog-container" class="row">
      <div class="span-one-third">
        <ul class="postsList">
          {$postsListMarkup}
        </ul>
      </div>
      <div class="span-two-thirds">
        <ul class="posts">
          {$postsMarkup}
        </ul>
      </div>
    </div>
    {$paginationMarkup}
  </section>
HTML;
}
else {
    $page_content = <<<HTML
  <section>
    <div class="page-header">
    <h1>{$pageTitle}</h1>
    </div>
    <div id="blog-container">
        <ul class="posts">
          {$postsMarkup}
        </ul>
    </div>
    {$paginationMarkup}
  </section>
HTML;
}

print render_page($pageTitle, strip_tags($pageTitle), 'blog', $page_content);

?>
