<?php

/**
 * The template for displaying single oral history.
 */

get_header(); ?>


<?php while (have_posts()) : the_post(); ?>

  <div id="primary" class="content-area">
    <div id="story_content">
      <?php
      // get page content if any
      the_content();
      ?>
    </div>
  </div>

<?php endwhile; ?>

<?php
        while (have_posts()) : the_post();
        // get the featured image and caption
        $story_photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $story_photo_alt = get_post(get_post_thumbnail_id())->post_excerpt;

        $story_categories = array();
        // the tags are custom taxonomy story-category
        $terms = get_the_terms($post->ID, 'story-category');
        foreach ($terms as $term) {
            $story_categories[$term->slug] = array(
                'name' => $term->name,
                'slug' => $term->slug,
                'color' => get_field('color', $term)
            );
        }

        $story_date = get_the_date();
        $story_title = get_the_title();
        $story_content = get_the_excerpt();
        $story_link = get_the_permalink();
        // custom fields
        $quote = get_field('quote');
        $name = get_field('name');
        $sentence_summary = get_field('sentence_summary');
        $bio1 = get_field('biography1');
        $bio2 = get_field('biography2');
        $related_stories = get_field('related_stories');
        $image = get_field('image');
        $image1 = get_field('image1');
        $image2 = get_field('image2');
        $image3 = get_field('image3');
        $image4 = get_field('image4');
        $iframe = get_field('video');
        $iframe1 = get_field('video1');
        $iframe2 = get_field('video2');
        $iframe3 = get_field('video3');
        $iframe4 = get_field('video4');


?>

<!-- start custom stuff -->

  <section id="story-area">
    <div class="row" style="margin: auto;padding:80px 0px;background-image: linear-gradient(90deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0) 50%),
                    url(<?php echo $story_photo; ?>);background-repeat:no-repeat;background-size:cover;background-position:center;">
      <div class="container white">
      <div class="col-md-6" style="padding:0px">
      <?php
      $count = 1;
      foreach ($story_categories as $category) :
      ?>
      <div class="story-category-wrap" style="border:1px solid white;border-radius:5px;padding:0px 5px;margin-bottom:10px;text-transform:uppercase;">
      <small class="
      <?php echo "story-tag-" . $count++; ?>
      " style="margin-bottom:0px">
      <?php echo $category['name']; ?>
      </small>
      </div>
      <?php endforeach;?>
                                    
        <h1 style="margin-bottom:0px;font-size:50px;">
          <?php echo $name; ?>
        </h1>
        <p style="font-size:18px">
          <?php echo $sentence_summary; ?>
        </p>
      </div>
      </div>
    </div>

  <?php endwhile; ?>
      
  <div class="row" style="margin: auto;padding:40px 0px">
    <div class="container">
      <ul class="nav nav-tabs" id="nav-person" style="margin-bottom:40px">
        <li class="active"><a data-toggle="tab" href="#biography">Biography</a></li>
        <li><a data-toggle="tab" href="#photos">Photos</a></li>
        <li><a data-toggle="tab" href="#videos">Videos</a></li>
        <li><a data-toggle="tab" href="#reports">Reports</a></li>
      </ul>

      <div class="tab-content">
        <div id="biography" class="tab-pane fade in active">
          <h2>Biography</h2>
          <?php echo $bio1; ?>
          <div class="block-quote"><?php echo $quote; ?></div>
          <?php echo $bio2; ?>
        </div>
        <div id="photos" class="tab-pane fade">
          <h2>Photos</h2>
          <div class="stories-wrap related">
          <?php 
          if( !empty( $image ) ): ?>
              <img class="story-photo gallery-photo" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <?php endif; ?>
          <?php 
          if( !empty( $image1 ) ): ?>
              <img class="story-photo gallery-photo" src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>" />
          <?php endif; ?>
          <?php 
          if( !empty( $image2 ) ): ?>
              <img class="story-photo gallery-photo" src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>" />
          <?php endif; ?>
          <?php 
          if( !empty( $image3 ) ): ?>
              <img class="story-photo gallery-photo" src="<?php echo esc_url($image3['url']); ?>" alt="<?php echo esc_attr($image3['alt']); ?>" />
          <?php endif; ?>
          <?php 
          if( !empty( $image4 ) ): ?>
              <img class="story-photo gallery-photo" src="<?php echo esc_url($image4['url']); ?>" alt="<?php echo esc_attr($image4['alt']); ?>" />
          <?php endif; ?>
          
          </div>
        </div>
        <div id="videos" class="tab-pane fade">
          <h2>Videos</h2>
          <div class="person-videos">
            <?php echo $iframe; ?>
            <?php echo $iframe1; ?>
            <?php echo $iframe2; ?>
            <?php echo $iframe3; ?>
            <?php echo $iframe4; ?>
          </div>
        </div>
        <div id="reports" class="tab-pane fade">
          <h2>Reports</h2>
          <p>I'm uhh... not sure what this should look like?</p>
        </div>
      </div>

      <h2 style="margin-top:40px">Related Stories</h2>
      <div class="stories-wrap related">
        <?php foreach( $related_stories as $related_story ): 
                            // get the featured image and caption
                            $story_photo = get_the_post_thumbnail_url($related_story->ID, 'full');
                            $thumbnail_id = get_post_thumbnail_id( $related_story->ID );
                            $story_photo_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
        
                            $story_categories = array();
                            // the tags are custom taxonomy story-category
                            $terms = get_the_terms($related_story->ID, 'story-category');
                            foreach ($terms as $term) {
                                $story_categories[$term->slug] = array(
                                    'name' => $term->name,
                                    'slug' => $term->slug,
                                    'color' => get_field('color', $term)
                                );
                            }
        
                            $story_title = get_the_title($related_story->ID);
                            $story_link = get_the_permalink($related_story->ID);
                            // quote is a custom field
                            $quote = get_field($related_story->ID,'quote');
                            $name = get_field($related_story->ID,'name');
        ?>

          <a class="stories-element" href="<?php echo $story_link; ?>">
                        <div class="story-photo-wrap">
                            <img class="story-photo" src="<?php echo $story_photo; ?>" width="100%" height="200px" 
                            alt="<?php echo $story_photo_alt; ?>">

                        </div>
                        <div class="story-details">
                            <h3><?php echo $name; ?></h3>
                            <p>
                                <?php echo $quote; ?>
                            </p>
                        </div>
                        <div class="story-category-parent">
                            <?php
                                    $count = 1;
                                    foreach ($story_categories as $category) :

                                    ?>
                                        <div class="story-category-wrap">
                                            <p class="story-tag tag-<?php echo $category['color']; ?>
                                    <?php echo "story-tag-" . $count++; ?>
                                ">

                                                <?php echo $category['name']; ?>
                                            </p>

                                        </div>

                                    <?php endforeach;
                                    ?>
                        </div>
                        
                                    </a>
    <?php endforeach; ?>
      </div>

    </div>
  </div>



  </section>

  <?php get_footer(); ?>

  <!--get rid of default container-->
  <script>
    document.getElementById('content').firstElementChild.classList.remove('container');
  </script>