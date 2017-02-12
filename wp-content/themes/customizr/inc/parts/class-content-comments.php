<?php
/**
* Comments actions
*
*
* @package      Customizr
* @subpackage   classes
* @since        3.0
* @author       Nicolas GUILLAUME <nicolas@themesandco.com>
* @copyright    Copyright (c) 2013, Nicolas GUILLAUME
* @link         http://themesandco.com/customizr
* @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
if ( ! class_exists( 'TC_comments' ) ) :
  class TC_comments {
      static $instance;
      function __construct () {
        self::$instance =& $this;
        add_action ( '__after_loop'                       , array( $this , 'tc_comments' ), 10 );
        add_action ( '__comment'                          , array( $this , 'tc_comment_title' ), 10 );
        add_action ( '__comment'                          , array( $this , 'tc_comment_list' ), 20 );
        add_action ( '__comment'                          , array( $this , 'tc_comment_navigation' ), 30 );
        add_action ( '__comment'                          , array( $this , 'tc_comment_close' ), 40 );
        add_filter ('comment_form_defaults'               , array( $this , 'tc_set_comment_title') );

        //wp hooks => wp_query is built
        add_action ( 'wp'                                 , array( $this , 'tc_comments_set_hooks' ) );
      }


      /**
      * Set various comment hooks
      * hook : wp
      * @package Customizr
      * @since Customizr 3.3.2
      */
      function tc_comments_set_hooks() {
        //Add comment bubble
        add_filter( 'tc_the_title'                        , array( $this , 'tc_display_comment_bubble' ), 1 );
        //Custom Bubble comment since 3.2.6
        add_filter( 'tc_bubble_comment'                   , array( $this , 'tc_custom_bubble_comment'), 10, 2 );
        //Set user defined various inline stylings
        add_filter( 'tc_user_options_style'               , array( $this , 'tc_comment_bubble_inline_css' ) );
      }



     /**
      * Main commments template
      *
      * @package Customizr
      * @since Customizr 3.0.10
     */
      function tc_comments() {
        //By default not displayed on home, for protected posts, and if no comments for page option is checked
        $comments_bool    =  ( post_password_required() || tc__f( '__is_home' ) || ( is_page() && 1 != esc_attr( TC_utils::$inst->tc_opt( 'tc_page_comments' )) ) ) ? false : true;

        if ( ! apply_filters('tc_show_comments', $comments_bool ) )
          return;

        comments_template( '' , true );
      }




      /**
        * Comment title rendering
        *
        *
        * @package Customizr
        * @since Customizr 3.0
       */
        function tc_comment_title() {
          if ( 1 == get_comments_number() ) {
            $_title = __( 'One thought on', 'customizr' );
          } else {
            $_title = sprintf( '%1$s %2$s', number_format_i18n( get_comments_number(), 'customizr' ) , __( 'thoughts on', 'customizr' ) );
          }

          echo apply_filters( 'tc_comment_title' ,
                sprintf( '<h2 id="tc-comment-title" class="comments-title">%1$s &ldquo;%2$s&rdquo;</h2>' ,
                  $_title,
                  '<span>' . get_the_title() . '</span>'
                )
          );
        }



       /**
        * Comment list Rendering
        *
        * @package Customizr
        * @since Customizr 3.0
       */
        function tc_comment_list() {
          $_args = apply_filters( 'tc_list_comments_args' , array( 'callback' => array ( $this , 'tc_comment_callback' ) , 'style' => 'ul' ) );
          ob_start();
            ?>
              <ul class="commentlist">
                <?php wp_list_comments( $_args ); ?>
              </ul><!-- .commentlist -->
            <?php
          $html = ob_get_contents();
          if ($html) ob_end_clean();
          echo apply_filters( 'tc_comment_list' , $html );
        }




       /**
        * Template for comments and pingbacks.
        *
        *
        * Used as a callback by wp_list_comments() for displaying the comments.
        *  Inspired from Twenty Twelve 1.0
        * @package Customizr
        * @since Customizr 1.0
        */
       function tc_comment_callback( $comment, $args, $depth ) {

        $GLOBALS['comment'] = $comment;
        //get user defined max comment depth
        $max_comments_depth = get_option('thread_comments_depth');
        $max_comments_depth = isset( $max_comments_depth ) ? $max_comments_depth : 5;

        ob_start();

        switch ( $comment->comment_type ) :
          case 'pingback' :
          case 'trackback' :
          // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
          <article id="comment-<?php comment_ID(); ?>" class="comment">
            <p><?php _e( 'Pingback:' , 'customizr' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)' , 'customizr' ), '<span class="edit-link btn btn-success btn-mini">' , '</span>' ); ?></p>
          </article>
        <?php
            break;
          default :
          // Proceed with normal comments.
          global $post;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

            <?php
              //when do we display the comment content?
              $tc_show_comment_content = 1 == get_option( 'thread_comments' ) && ($depth < $max_comments_depth) && comments_open();

              //gets the comment text => filter parameter!
              $comment_text = get_comment_text( $comment->comment_ID , $args );

              printf('<article id="comment-%9$s" class="comment"><div class="%1$s"><div class="%2$s">%3$s</div><div class="%4$s">%5$s %6$s %7$s %8$s</div></div></article>',
                  apply_filters( 'tc_comment_wrapper_class', 'row-fluid' ),
                  apply_filters( 'tc_comment_avatar_class', 'comment-avatar span2' ),
                  get_avatar( $comment, apply_filters( 'tc_comment_avatar_size', 80 ) ),
                  apply_filters( 'tc_comment_content_class', 'span10' ),

                  $tc_show_comment_content ? sprintf('<div class="%1$s">%2$s</div>',
                                            apply_filters( 'tc_comment_reply_btn_class', 'reply btn btn-small' ),
                                            get_comment_reply_link( array_merge(
                                                                        $args,
                                                                        array(  'reply_text' => __( 'Reply' , 'customizr' ).' <span>&darr;</span>',
                                                                                'depth' => $depth,
                                                                                'max_depth' => $args['max_depth'] ,
                                                                                'add_below' => apply_filters( 'tc_comment_reply_below' , 'li-comment' )
                                                                              )
                                                                  )
                                            )
                  ) : '',

                  sprintf('<header class="comment-meta comment-author vcard">%1$s %2$s</header>',
                        sprintf( '<cite class="fn">%1$s %2$s %3$s</cite>' ,
                            get_comment_author_link(),
                            // If current post author is also comment author, make it known visually.
                            ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author' , 'customizr' ) . '</span>' : '' ,
                            current_user_can( 'edit_comment', $comment->comment_ID ) ? '<p class="edit-link btn btn-success btn-mini"><a class="comment-edit-link" href="' . get_edit_comment_link( $comment->comment_ID ) . '">' . __( 'Edit' , 'customizr' ) . '</a></p>' : ''
                        ),
                        sprintf( '<a class="comment-date" href="%1$s"><time datetime="%2$s">%3$s</time></a>' ,
                            esc_url( get_comment_link( $comment->comment_ID ) ),
                            get_comment_time( 'c' ),
                            /* translators: 1: date, 2: time */
                            sprintf( __( '%1$s at %2$s' , 'customizr' ), get_comment_date(), get_comment_time() )
                        )
                  ),

                  ( '0' == $comment->comment_approved ) ? sprintf('<p class="comment-awaiting-moderation">%1$s</p>',
                    __( 'Your comment is awaiting moderation.' , 'customizr' )
                    ) : '',

                  sprintf('<section class="comment-content comment">%1$s</section>',
                    apply_filters( 'comment_text', $comment_text, $comment, $args )
                  ),
                  $comment->comment_ID
                );//end printf
            ?>
          <!-- #comment-## -->
        <?php
          break;
        endswitch; // end comment_type check

        $html = ob_get_contents();
        if ($html) ob_end_clean();
        echo apply_filters( 'tc_comment_callback' , $html, $comment, $args, $depth, $max_comments_depth );
      }




    /**
    * Comments navigation rendering
    *
    * @package Customizr
    * @since Customizr 3.0
   */
    function tc_comment_navigation () {
      if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through

        ob_start();

        ?>
        <nav id="comment-nav-below" class="navigation" role="navigation">
          <h3 class="assistive-text section-heading"><?php _e( 'Comment navigation' , 'customizr' ); ?></h3>
          <ul class="pager">

            <?php if(get_previous_comments_link() != null) : ?>

              <li class="previous">
                <span class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments' , 'customizr' ) ); ?></span>
              </li>

            <?php endif; ?>

            <?php if(get_next_comments_link() != null) : ?>

              <li class="next">
                <span class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>' , 'customizr' ) ); ?></span>
              </li>

            <?php endif; ?>

          </ul>
        </nav>
        <?php

        $html = ob_get_contents();
        ob_end_clean();
        echo apply_filters( 'tc_comment_navigation' , $html );

      endif; // check for comment navigation

    }



    /**
    * Comment close rendering
    *
    * @package Customizr
    * @since Customizr 3.0
    */
    function tc_comment_close() {
      /* If there are no comments and comments are closed, let's leave a note.
       * But we only want the note on posts and pages that had comments in the first place.
       */
      if ( ! comments_open() && get_comments_number() ) :
        echo apply_filters( 'tc_comment_close' ,
          sprintf('<p class="nocomments">%1$s</p>',
            __( 'Comments are closed.' , 'customizr' )
          )
        );

      endif;
    }


    /**
    * Comment title override (comment_form_defaults filter)
    *
    * @package Customizr
    * @since Customizr 3.2.0
    */
    function tc_set_comment_title($_defaults) {
      $_defaults['title_reply'] =  __( 'Leave a comment' , 'customizr' );
      return $_defaults;
    }



    /**
    * Callback for tc_the_title
    * @return  string
    *
    * @package Customizr
    * @since Customizr 3.2.6
    */
    function tc_display_comment_bubble( $_title = null ) {

      //Must be in the loop and enabled by user
      if ( ! in_the_loop() || 0 == esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_show_bubble' ) ) )
        return $_title;

      //when are we showing the comments number in title?
      //1) comments are enabled
      //2) post type is in the eligible post type list : default = post
      $comments_enabled                  = ( 1 == esc_attr( TC_utils::$inst->tc_opt( 'tc_page_comments' )) && comments_open() && get_comments_number() != 0 && !post_password_required() && is_page() ) ? true : false;
      $comments_enabled                  = ( comments_open() && get_comments_number() != 0 && !post_password_required() && !is_page() ) ? true : $comments_enabled;

      if ( ! apply_filters( 'tc_comments_in_title', $comments_enabled )
        || ! in_array( get_post_type(), apply_filters('tc_show_comment_bubbles_for_post_types' , array( 'post' , 'page') ) ) )
        return $_title;

      global $post;
      //checks if comments are opened AND if there are any comments to display
      return sprintf('%1$s <span class="comments-link"><a href="%2$s#tc-comment-title" title="%3$s %4$s">%5$s</a></span>',
        $_title,
        is_singular() ? '' : get_permalink(),
        sprintf( '%1$s %2$s' , get_comments_number(), __( 'Comment(s) on' , 'customizr' ) ),
        is_null($_title) ? esc_attr( strip_tags( $post -> post_title ) ) : esc_attr( strip_tags( $_title ) ),
        0 != get_comments_number() ? apply_filters( 'tc_bubble_comment' , '' , esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_bubble_shape' ) ) ) : ''
      );
    }



   /**
    * Callback of tc_bubble_comment
    * @return string
    *
    * @package Customizr
    * @since Customizr 3.2.6
    */
    function tc_custom_bubble_comment( $_html , $_opt ) {
      return sprintf('%4$s<span class="tc-comment-bubble %1$s">%2$s %3$s</span>',
        'default' == $_opt ? "default-bubble" : $_opt,
        get_comments_number(),
        'default' == $_opt ? '' : sprintf( _n( 'comment' , 'comments' , get_comments_number(), 'customizr' ),
          number_format_i18n( get_comments_number(), 'customizr' )
        ),
        $_html
      );
    }


    /*
    * Callback of tc_user_options_style hook
    * @return css string
    *
    * @package Customizr
    * @since Customizr 3.3.2
    */
    function tc_comment_bubble_inline_css( $_css ) {
      if ( 0 == esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_show_bubble' ) ) )
        return $_css;

      //apply custom color only if type custom
      //if color type is skin => bubble color is defined in the skin stylesheet
      if ( 'skin' != esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_bubble_color_type' ) ) ) {
        $_custom_bubble_color = esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_bubble_color' ) );
        $_css .= "
          .comments-link .tc-comment-bubble {
            color: {$_custom_bubble_color};
            border: 2px solid {$_custom_bubble_color};
          }
          .comments-link .tc-comment-bubble:before {
            border-color: {$_custom_bubble_color};
          }
        ";
      }

      if ( 'default' == esc_attr( TC_utils::$inst->tc_opt( 'tc_comment_bubble_shape' ) ) )
        return $_css;

      $_css .= "
        .comments-link .custom-bubble-one {
          position: relative;
          bottom: 28px;
          right: 10px;
          padding: 4px;
          margin: 1em 0 3em;
          background: none;
          -webkit-border-radius: 10px;
          -moz-border-radius: 10px;
          border-radius: 10px;
          font-size: 10px;
        }
        .comments-link .custom-bubble-one:before {
          content: '';
          position: absolute;
          bottom: -14px;
          left: 10px;
          border-width: 14px 8px 0;
          border-style: solid;
          display: block;
          width: 0;
        }
        .comments-link .custom-bubble-one:after {
          content: '';
          position: absolute;
          bottom: -11px;
          left: 11px;
          border-width: 13px 7px 0;
          border-style: solid;
          border-color: #FAFAFA rgba(0, 0, 0, 0);
          display: block;
          width: 0;
        }\n";

      return $_css;
    }//end of fn

  }//end class
endif;