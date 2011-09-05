<?php

require('template.php');

$id = htmlspecialchars($_GET["pid"]);
$single_post = false;
if ($id && is_numeric($id)) {
  $single_post = true;
}

if ($single_post) {
  $response = executeQuery("http://api.tumblr.com/v2/blog/bendalziel.tumblr.com/posts?id=" . $id . "&api_key=EonZSbH566lKrQIcXzx8W1Tt3DcQ59tJhcmRTdXsEnjhodX9k2");
}
else {
  $response = executeQuery("http://api.tumblr.com/v2/blog/bendalziel.tumblr.com/posts?api_key=EonZSbH566lKrQIcXzx8W1Tt3DcQ59tJhcmRTdXsEnjhodX9k2");
}

if (!$response) {
  $page_content = <<<HTML
  <section>
    <div class="alert-message error">
      <p><strong>Something went wrong</strong> Perhaps Tumblr is down...</p>
    </div>
  </section>
HTML;
  print render_page("", 'Ben Dalziel\'s Blog', 'blog', $page_content);
  return;
}

$data = json_decode($response, true);

$entries = array();

foreach ($data['response']['posts'] as $post) {
  $entry['date'] = $post['timestamp'];
  $entry['title'] = (array_key_exists('title', $post)) ? $post['title'] : 'Untitled';
  $entry['body'] = $post['body'];
  $entry['url'] = "blog.php?pid=" . $post['id']; // $post['post_url'];
  $entries[] = $entry;
}

$entries_markup = '';

foreach ($entries as $entry) {
  $url = $entry['url'];
  $month_day = date("l F j", $entry['date']);
  $year = (date("Y", $entry['date']) !== date("Y")) ? date(", Y", $entry['date']) : '';
  $time = date("ga", $entry['date']);

  $date = $month_day . $year . ', ' . $time;

  $title = $entry['title'];
  $body = $entry['body'];

  $post_classes = array();
  if (!$single_post) {
    $post_classes[] = 'well';
  }
  $post_classes = implode($post_classes, ' ');


  $post_title = '';
  if (!$single_post) {
    $post_title = "<h3>" . $title . ". <small><a href=\"" . $url . "\">" . $date . "</a>.</small></h3>";
  }
  else {
    $page_title = $title . ". <small>" . $date . ".</small>";
  }

  $entries_markup .= <<<HTML
        <li class="post">
          <div class="{$post_classes}">
            {$post_title}
            {$body}
          </div>
        </li>
HTML;

}

$footer = '';
if ($single_post) {
  $footer = <<<HTML
<section>
  <h3 class="well"><a href="blog.php">Back to Ben Dalziel's Blog &#187;</h3>
</section>
HTML;
}
else {
  $page_title = "Ben Dalziel's Blog. <small>From new to old.</small>";  
}

$page_content = <<<HTML

  <section>
    <div class="page-header">
      <h1>{$page_title}</h1>
    </div>

    <div id="blog-container">
      <ul>
        {$entries_markup}
      </ul>
    </div>

  </section>

{$footer}

HTML;

print render_page($page_title, 'Ben Dalziel\'s Blog', 'blog', $page_content);

function executeQuery ($query, $timeout = 10) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $query);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);    

  if ($httpcode>=200 && $httpcode<300)
  {
    return $data;
  }
  return null;
}

?>
