<?php

require('template.php');

$page_content = <<<HTML

  <section>
    <div class="alert-message error">
      <p><strong>404</strong> Oops, try something else...</p>
    </div>
  </section>

HTML;

print render_page('Uh oh. <small>Something went wrong.</small>', 'Uh Oh, 404', '', $page_content);

?>
