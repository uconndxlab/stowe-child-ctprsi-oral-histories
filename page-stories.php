<?php

/** Oral Histories Template, page-stories.php */
get_header();

$args = array(
    'post_type' => 'oral-history',
    'posts_per_page' => -1,
    'paged' => get_query_var('paged'),
);

// if $_GET['aof'] is set, filter by story category

if (isset($_GET['aof'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'story-category',
            'field' => 'slug',
            'terms' => $_GET['aof'],
            'per_page' => -1,
            'paged' => get_query_var('paged'),
        ),
    );
}

$oral_histories = new WP_Query($args);

?>


<div class="row">
    <div class="col-md-12" style="margin-top: 50px;">
        <!-- get the conent of the page -->
        <?php if (have_posts()) : while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif; ?>
    </div>
</div>

<section id="stories-app">
    <div class="container">

    <div class="row">

    <!-- START TEST AREA -->
    <div class="col-lg-3 stories-filter">
    <h4>Filter by Category:</h4>
    <form method="GET" action="" id="category-filter-form" hx-get="" hx-trigger="change" hx-target=".stories-wrap" hx-select=".stories-wrap" hx-swap="outerHTML" hx-indicator=".stories-wrap">
        <ul style="padding-left:0px">
            <?php
            // Define the taxonomy for 'story-category' and fetch the terms
            $args = array(
                'taxonomy' => 'story-category',  
                'hide_empty' => false,
            );

            $terms = get_terms($args);

            foreach ($terms as $term) {
                $term_description = $term->description;
                $term_slug = $term->slug;
                $term_name = $term->name;
                $term_color = get_field('color', $term);  // Custom field for color if needed

                // Check if term is selected via the GET parameter
                $is_checked = (isset($_GET['aof']) && in_array($term_slug, (array) $_GET['aof'])) ? 'checked' : '';
                ?>

                <li class="stories-filter-item">
                    <label for="category-<?php echo esc_attr($term_slug); ?>" class="checkbox-contain">
                        <input type="checkbox" name="aof[]" id="category-<?php echo esc_attr($term_slug); ?>" value="<?php echo esc_attr($term_slug); ?>" class="category-filter-checkbox" <?php echo $is_checked; ?> />
                        <span class="checkmark"></span>
                        <?php echo esc_html($term_name); ?>
                    </label>

                    <?php if ($term_description) : ?>
                        <p class="stories-filter-description"><?php echo esc_html($term_description); ?></p>
                    <?php endif; ?>
                </li>

                <?php
            }
            ?>
        </ul>
    </form>
</div>


<!-- END TEST AREA -->
        <div class="col-lg-9 stories-wrap stories row">
            <?php


            if ($oral_histories->have_posts()) {
                while ($oral_histories->have_posts()) {

                    $oral_histories->the_post();
                    // get the featured image and caption
                    $story_photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $thumbnail_id = get_post_thumbnail_id( $post->ID );
                    $story_photo_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);


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
                    // quote is a custom field
                    $quote = get_field('quote');
                    $name = get_field('name');


            ?>


                    <a class="stories-element" href="<?php echo $story_link; ?>">
                        <div class="story-photo-wrap">
                            <img class="story-photo" src="<?php echo $story_photo; ?>" width="100%" height="200px" 
                            alt="<?php echo $story_photo_alt; ?>">

                        </div>
                        <div class="story-details">
                            <h3><?php echo $name; ?></h3>
                            <p style="font-style:italic">
                                <?php echo $quote; ?>
                            </p>
                            <p><?php echo $story_content; ?></p>
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


            <?php

                }
                wp_reset_postdata();
            }
            ?>

        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="pagination">
                <?php
                $pagination_links = paginate_links(array(
                    'total' => $oral_histories->max_num_pages,
                    'type' => 'array', // Return the links as an array
                    'prev_text' => __('&laquo; Prev'),
                    'next_text' => __('View More'), // Change "Next" to "View More"
                ));

                if (!empty($pagination_links)) {
                    foreach ($pagination_links as $link) {
                        // Only modify the "next" page link to append content
                        if (strpos($link, 'next page-numbers')) {
                            echo str_replace('<a', '<a hx-get="' . esc_url(get_pagenum_link()) . '" hx-select="#stories-app" hx-target="#stories-app" hx-swap="beforeend"', $link);
                        } else {
                            echo $link;
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

</section>

<?php get_footer(); ?>