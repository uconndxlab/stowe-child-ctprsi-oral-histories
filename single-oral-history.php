<?php

/**
 * The template for displaying single oral history.
 */

get_header(); ?>


<?php while (have_posts()) : the_post(); ?>

  <div id="primary" class="content-area">
    <div id="story_content">
      <?php
      // do the content
      the_content();
      ?>

      </main>
    </div>
  </div>

  <?php endwhile; ?>

  <?php
  get_footer();