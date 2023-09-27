<main class="main-content bg-white page intern-pg" role='main'>
  <?php 
echo( 'Hello World template is loadit' );
      if ( have_posts() ) : 
        while ( have_posts() ) : 
          the_post(); 

          echo 'TEMPLATE';
        
          if ( comments_open() || get_comments_number() ) { comments_template();	}
        endwhile; 
      else:
        //Dosent have post
        echo '<div class="container dosent-have-post my-5">';
        the_content(); 
        echo '</div>';
      endif; 
    ?>

</main>