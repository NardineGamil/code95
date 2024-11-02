<?php
/*
Template Name: Blog Page
*/

// Display the featured image before the header
if (has_post_thumbnail()) {
    $background_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    echo '<div class="featured-image-background container" style="background-image: url(' . esc_url($background_image_url) . '); margin-bottom: 20px;"></div>';
}

get_header(); ?>

<section id="mainPosts">
    <div class="container main mt-4">
        <div class="row">
            <!-- First Column: Main Post(s) -->
            <div class="col-md-6">
                <?php
                
                $main_category = get_field('main_post_category');
                $main_category_slug = '';

                if (is_array($main_category) && !empty($main_category)) {
                    $main_category_slug = $main_category[0]->slug; 
                } elseif ($main_category) {
                    $main_category_slug = $main_category->slug; 
                } else {
                    $main_category_slug = 'main'; 
                }

                // Query for the main post
                $main_posts = new WP_Query(array(
                    'category_name' => $main_category_slug,
                    'posts_per_page' => 1,
                ));

                if ($main_posts->have_posts()) {
                    while ($main_posts->have_posts()) {
                        $main_posts->the_post(); ?>
                        <div class="post mb-4">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="thumbnail-container">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo get_the_post_thumbnail(null, 'medium'); ?>
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="maintitle">
                                <span>Local</span>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </div>
                    <?php }
                    wp_reset_postdata();
                } else {
                    echo '<p>No main posts found.</p>';
                }
                ?>
            </div>

            <!-- Second Column: Other Posts -->
            <div class="col-md-3">
                <?php
                
                $other_category = get_field('other_posts_category');
                $other_category_slug = '';

                if (is_array($other_category) && !empty($other_category)) {
                    $other_category_slug = $other_category[0]->slug; 
                } elseif ($other_category) {
                    $other_category_slug = $other_category->slug; 
                } else {
                    $other_category_slug = 'main'; 
                }

                $other_post_count = get_field('other_post_count') ? get_field('other_post_count') : 2;

                // Query for other posts
                $other_posts = new WP_Query(array(
                    'category_name' => $other_category_slug,
                    'posts_per_page' => $other_post_count,
                    'offset' => 1, 
                ));

                if ($other_posts->have_posts()) {
                    while ($other_posts->have_posts()) {
                        $other_posts->the_post(); ?>
                        <div class="post mb-3">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="thumbnail-container">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo get_the_post_thumbnail(null, 'medium'); ?>
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="maintitleTwo">
                                <span>Local</span>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </div>
                    <?php }
                    wp_reset_postdata();
                } else {
                    echo '<p>No other posts found.</p>';
                }
                ?>
            </div>

            <!-- Third Column: Featured Image of the Page -->
            <div class="col-md-3 feaImg">
                <?php

                $custom_featured_image = get_field('custom_featured_image');

                if ($custom_featured_image) {

                    echo '<img src="' . esc_url($custom_featured_image) . '" alt="Custom Featured Image" class="img-fluid">';
                } elseif (has_post_thumbnail()) {

                    echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'img-fluid'));
                } else {

                    echo '<p>No featured image found.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>


<section id="egyPosts">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="egy">Egy News</h2>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper gap-2">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'category_name' => 'egypt',
                            'posts_per_page' => 15
                        );
                        $the_query = new WP_Query($args);

                        if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                        ?>
                            <div class="swiper-slide">
                                <div class="image-container">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                        <div class="overlay"></div>
                                        <h2 class="title"><?php the_title(); ?></h2>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
                    <div class="swiper-button-prev"><img src="http://code95.local/wp-content/uploads/2024/11/Property-1Variant2.png" alt="prev"></div>
                    <div class="swiper-button-next"><img src="http://code95.local/wp-content/uploads/2024/11/Property-1Default.png" alt="next"></div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container mt-5 mb-5">
    <!-- Featured Posts and Top Stories Section -->
    <div class="row">

        <!-- Featured Posts -->
        <div class="col-12 col-md-8 mb-4">
            <div class="row">
            <h2 class="featured">Featured</h2>
                <?php
                // Get the ACF fields
                $featured_posts_category = get_field('featured_posts_category'); // Get selected category
                $featured_posts_count = get_field('featured_posts_count') ?: 8; // Default to 8 if not set for 2 rows of 4 posts

                // Ensure $featured_posts_category is a string
                if (is_array($featured_posts_category)) {
                    $featured_posts_category = !empty($featured_posts_category) ? $featured_posts_category[0]->slug : ''; // Get the slug of the first term
                } elseif ($featured_posts_category instanceof WP_Term) {
                    $featured_posts_category = $featured_posts_category->slug; // Get the slug if it's a single term
                } else {
                    $featured_posts_category = ''; // Default to empty string if no category found
                }

                // Create a new WP_Query using the selected category and number of posts
                $featured_posts = new WP_Query(array(
                    'category_name' => $featured_posts_category, 
                    'posts_per_page' => $featured_posts_count, 
                ));

                if ($featured_posts->have_posts()) {
                    while ($featured_posts->have_posts()) {
                        $featured_posts->the_post(); 
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 mb-3"> <!-- Each post takes 6 columns for 2 posts per row -->
                            <div class="post">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="thumbnail-container">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                            <div class="overlay"></div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="maintitle">
                                    <span>Local</span>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    // Restore original post data
                    wp_reset_postdata();
                } else {
                    echo '<p>No featured posts found.</p>';
                }
                ?>
            </div> <!-- End of inner row -->
        </div>

        <!-- Third Column: Top 5 Stories by Views -->
        <div class="col-12 col-md-4 topStories">
        <h2 class="top mx-3">Top Stories</h2>
            <?php
            $top_stories = new WP_Query(array(
                'meta_key' => 'post_views_count', 
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'posts_per_page' => 5, 
            ));

            if ($top_stories->have_posts()) {
                $rank = 1; 
                while ($top_stories->have_posts()) {
                    $top_stories->the_post();
                    ?>
                    <div class="top-story mb-4 mx-3">
                        <h4>
                            <span class="rank-number"><?php echo $rank; ?></span> 
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </div>
                    <?php
                    $rank++; 
                }
                wp_reset_postdata();
            } else {
                echo '<p>No top stories found.</p>';
            }
            ?>
        </div>
    </div>
</div>

