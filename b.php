<div class="col-md-6 stories-filter">

        <h4>Filter by Category &#8628;</h4>


        <ul>
            <li>
                <a href="<?php the_permalink(); ?>" class=" filter view-all" data-filter="*">
                    <span class="circle" style="background-color: #000e2f"></span>All Categories
                </a>

            </li>
            <?php
            $args = array(
                'taxonomy' => 'story-category',
                'hide_empty' => false,
            );

            $terms = get_terms($args);

            foreach ($terms as $term) {
                $term_description = $term->description;
                echo '<li class="stories-filter-item';

                if (isset($_GET['aof']) && $_GET['aof'] == $term->slug) {
                    echo ' active"';
                } else echo '"';

                echo '>';

                echo '<a 
                hx-get="?aof=' . $term->slug . '"
                hx-select="#stories-app"
                hx-target="#stories-app"
                hx-swap="outerHTML"
                href="?aof=' . $term->slug . '"' . ' class="filter" data-filter=".' . $term->slug . '">';
                echo '<span class="circle bg-' . get_field('color', $term) . '"></span> ' . $term->name . '</a>';
                if ($term_description) {
                    echo '<p class="stories-filter-description">' . $term_description . '</p>';
                }
                echo '</li>';
            }
            ?>
        </ul>
    </div>