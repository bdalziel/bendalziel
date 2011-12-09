<?php

class TumblrPostRenderer {

  protected $post;
  protected $isSinglePost;

  public function __construct ($post, $isSinglePost = true) {
    $this->post = $post;
    $this->isSinglePost = $isSinglePost;
  }

  public function render () {
      $tags = '';
      $comments = '';
      if ($this->isSinglePost) {
          $postMarkup = $this->post->bodyToHtml();
          $tags = $this->renderTags();
          $comments = $this->renderComments();
      }
      else {
          $postMarkup = $this->post->toHtml();
          $cardComments = $this->renderComments();
      }

    if (!$this->isSinglePost) {
        $postTitle = $this->post->getTitle();
        $postSubTitle = $this->post->getFormattedDate();
        $postUrl = $this->post->getUrl();
        $postMarkup = <<<HTML
        <li class="post">
            <div class="row">
                <div class="span-one-third">
                <ul class="postCard">
                  <li>
                    <a href="{$postUrl}">
                        <h4>{$postTitle}.<br /><small>{$postSubTitle}.</small></h4>
                    </a>
                  </li>
                </ul>
                </div>
                <div class="span-two-thirds">
                    {$postMarkup}
                    {$tags}
                    {$comments}
                </div>
            </div>
        </li>
HTML;
    }
    else {
        $postMarkup = <<<HTML
        <li class="post">
          <div>
            {$postMarkup}
            {$tags}
            {$comments}
          </div>
        </li>
HTML;
    }
    return $postMarkup;
  }

  public function renderComments () {
    $url = $this->getPostUrl();

    if ($this->isSinglePost) {
      $comments = <<<HTML
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="{$url}" num_posts="5" width="620"></fb:comments>
HTML;
    }
    else {
      $comments = '';
    /*
      $url = urlencode($url);
      $comments = <<<HTML
<iframe src="http://www.facebook.com/plugins/comments.php?href={$url}&permalink=1" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:16px;" allowTransparency="true"></iframe>
HTML;
*/
    }
    return $comments;
  }

  public function renderTags () {
    $tags = $this->post->getTags();
    $tagsMarkup = implode(' | ' , $tags);
    return <<<HTML
<h5 class="tags">Tags: <small>{$tagsMarkup}</small></h5>
HTML;
  }

  protected function getPostUrl () {
    $url = "bendalziel.com/blog.php?post_id=" . $this->post->getId();
    return $url;
  }

}

?>
