<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

<section class="hero is-primary image-background" style="background-image: url('<?php the_post_thumbnail_url() ?>');">
  <figure class="image is-hidden">
      <img src="<?php the_post_thumbnail_url() ?>" alt="">
  </figure>
  <div class="hero-body">
      <div class="container" style="min-height: 32vh;">
          <!-- <h1 class="title">
              Hero title
          </h1>
          <h2 class="subtitle">
              Hero subtitle
          </h2> -->
      </div>
  </div>
</section>

<!-- <figure class="image is-3by2">
    <?php the_post_thumbnail(); ?>
</figure> -->

<nav class="nav">
    <div class="nav-left">
        <a class="nav-item" href="/">
            <img src="https://capitalinoerrante.com/wp-content/uploads/2016/11/CAPITALINOBABY.jpg" alt="Bulma logo">
        </a>
    </div>

    <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
    <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
    <span class="nav-toggle">
        <span></span>
    <span></span>
    <span></span>
    </span>

    <!-- This "nav-menu" is hidden on mobile -->
    <!-- Add the modifier "is-active" to display it on mobile -->
    <!-- <div class="nav-right nav-menu">
            <a class="nav-item">
                Home
            </a>
            <a class="nav-item">
                Documentation
            </a>
            <a class="nav-item">
                Blog
            </a>

            <span class="nav-item">
                <a class="button" >
                    <span class="icon">
                        <i class="fa fa-twitter"></i>
                    </span>
                    <span>Tweet</span>
                </a>
                <a class="button is-primary">
                    <span class="icon">
                        <i class="fa fa-download"></i>
                    </span>
                    <span>Download</span>
                </a>
            </span>
        </div> -->
    <?php
        wp_nav_menu(array(
            'container'       => false,
            'container_id'    => false,
            'menu_class'      => 'nav-right nav-menu',
            'menu_id'         => false,
            'fallback_cb'     => false,
            'items_wrap'      => '<div class="%2$s">%3$s</div>',
            'depth'           => 1,
            'walker'          => new Description_Walker
        ));
    ?>
</nav>

<section class="section is-paddingless">

    <div class="container">

        <div class="columns is-marginless">

                <div class="column is-paddingless is-10-tablet is-8-desktop is-offset-1-tablet is-offset-2-desktop">

                        <div class="card" style="box-shadow: none;">

                            <div class="card-content">

                                <div class="is-hidden-mobile" style="height: 3rem;"></div>

                                <div class="media" style="margin-bottom: 10px;">
                                    <div class="media-content">
                                        <p class="title is-3 is-strong"><?php the_title(); ?></p>
                                        <p class="subtitle is-6">Por <?php the_author(); ?> - <?php the_date(); ?></p>
                                    </div>
                                </div>

                                <div class="content">
                                    <small class="color-primary" style="text-transform: capitalize;"><?php the_category( ', ' ); ?></small>
                                    <br><br>
                                    <?php the_excerpt(); ?>
                                    <p class="color-primary">
                                        <?php
                                            if( $tags = get_the_tags() ) {
                                                foreach( $tags as $tag ) {
                                                    $sep = ( $tag === end( $tags ) ) ? '' : ', ';
                                                    echo '<a href="' . get_term_link( $tag, $tag->taxonomy ) . '">#' . $tag->name . '</a>' . $sep;
                                                }
                                            }
                                        ?>
                                    </p>
                                    <?php the_content(); ?>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            <?php endwhile; endif;?>
        </div>
    </div>
</section>

<!-- <section class="section">
    <div class="container">
        <nav class="level">
        <div class="level-item has-text-centered">
        <div>
        <p class="heading">Tweets</p>
        <p class="title">3,456</p>
        </div>
        </div>
        <div class="level-item has-text-centered">
        <div>
        <p class="heading">Following</p>
        <p class="title">123</p>
        </div>
        </div>
        <div class="level-item has-text-centered">
        <div>
        <p class="heading">Followers</p>
        <p class="title">456K</p>
        </div>
        </div>
        <div class="level-item has-text-centered">
        <div>
        <p class="heading">Likes</p>
        <p class="title">789</p>
        </div>
        </div>
        </nav>
    </div>
</section> -->

<?php get_footer(); ?>

<?php //
// the_content();
// echo "Category";
// the_category();
// echo "Excerpt";
//
// echo "ID";
// the_ID();
// echo "Tags";
// the_tags();
// echo "Next post link";
// next_post_link();
// echo "Previous post link";
// previous_post_link();
// echo "---------------------------------------------------";?>
