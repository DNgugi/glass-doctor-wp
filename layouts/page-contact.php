<?php
/*
 * Template Name: Contact Page
 * description: >-
  Page template for contact page
 */

get_header(); ?>

<div class="row container">
  <div class="col s12 m6 ">
    <main id="primary" class="site-main">

      <?php
      if ( have_posts() ) :

        if ( is_home() && ! is_front_page() ) :
          ?>
          <header>
            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
          </header>
          <?php
        endif;

    /* Start the Loop */
        while ( have_posts() ) :
          the_post();

          /*
          * Include the Post-Type-specific template for the content.
          * If you want to override this in a child theme, then include a file
          * called content-___.php (where ___ is the Post Type name) and that will be used instead.
          */
          get_template_part( 'template-parts/content', get_post_type() );

        endwhile;

        the_posts_navigation();

      else :

        get_template_part( 'template-parts/content', 'none' );

      endif;
      ?>
    </main><!-- #main -->
  </div>
  <div class="col s12 m6">
<h4 class="center">Find us on Maps</h4>
<p class="center">Tap "View Larger Map" to open in your maps app</p>
<div class="contact-map">
  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1994.3970853356975!2d36.80012312881817!3d-1.2982312999021832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2ske!4v1603206854596!5m2!1sen!2ske" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  </div></div>
</div>



<?php get_footer(); ?>