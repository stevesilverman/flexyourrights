<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}


/**
 * Add and initiate the Soil hooks
 *
 * @since 1.1
 * @uses add_action() calls to trigger the hooks.
 *
 */


/**
 * called after theme files are included but before theme is loaded
 *
 * @since 1.1
 */
function soil_init() {
	do_action( 'soil_init' );
}


/**
 * called in header.php after the opening body tag
 *
 * @since 1.1
 */
function soil_before() {
	do_action( 'soil_before' );
}


/**
 * called in footer.php before the closing body tag
 *
 * @since 1.1
 */
function soil_after() {
	do_action( 'soil_after' );
}


/**
 * called in header.php before the theme header hook loads
 *
 * @since 1.1
 */
function soil_before_header() {
	do_action( 'soil_before_header' );
}


/**
 * called in header.php and loads the theme header
 *
 * @since 1.1
 */
function soil_header() {
	do_action( 'soil_header' );
}


/**
 * called in header.php after the theme header hook loads
 *
 * @since 1.1
 */
function soil_after_header() {
	do_action( 'soil_after_header' );
}


/**
 * Page action hooks
 *
 */


/**
 * called in page.php before the loop executes
 *
 * @since 1.1
 */
function soil_before_page_loop() {
	do_action( 'soil_before_page_loop' );
}


/**
 * called in page.php before the page post section
 *
 * @since 1.1
 */
function soil_before_page() {
	do_action( 'soil_before_page' );
}


/**
 * called in page.php before the page post title tag
 *
 * @since 1.1
 */
function soil_before_page_title() {
	do_action( 'soil_before_page_title' );
}


/**
 * called in page.php after the page post title tag
 *
 * @since 1.1
 */
function soil_after_page_title() {
	do_action( 'soil_after_page_title' );
}


/**
 * called in page.php before the page post content
 *
 * @since 1.1
 */
function soil_before_page_content() {
	do_action( 'soil_before_page_content' );
}


/**
 * called in page.php after the page post content
 *
 * @since 1.1
 */
function soil_after_page_content() {
	do_action( 'soil_after_page_content' );
}


/**
 * called in page.php after the page post section
 *
 * @since 1.1
 */
function soil_after_page() {
	do_action( 'soil_after_page' );
}


/**
 * called in page page.php after the loop endwhile
 *
 * @since 1.1
 */
function soil_after_page_endwhile() {
	do_action( 'soil_after_page_endwhile' );
}


/**
 * called in page page.php after the loop else
 *
 * @since 1.1
 */
function soil_page_loop_else() {
	do_action( 'soil_page_loop_else' );
}


/**
 * called in page page.php after the loop executes
 *
 * @since 1.1
 */
function soil_after_page_loop() {
	do_action( 'soil_after_page_loop' );
}


/**
 * called in page comments-page.php before the comments list block
 *
 * @since 1.1
 */
function soil_before_page_comments() {
	do_action( 'soil_before_page_comments' );
}


/**
 * called in page comments-page.php in the ol block
 *
 * @since 1.1
 */
function soil_list_page_comments() {
	do_action( 'soil_list_page_comments' );
}


/**
 * called in page comments-page.php after the comments list block
 *
 * @since 1.1
 */
function soil_after_page_comments() {
	do_action( 'soil_after_page_comments' );
}


/**
 * called in page comments.php before the pings list block
 *
 * @since 1.1
 */
function soil_before_page_pings() {
	do_action( 'soil_before_page_pings' );
}


/**
 * called in page comments.php in the ol block
 *
 * @since 1.1
 */
function soil_list_page_pings() {
	do_action( 'soil_list_page_pings' );
}


/**
 * called in page comments.php after the pings list block
 *
 * @since 1.1
 */
function soil_after_page_pings() {
	do_action( 'soil_after_page_pings' );
}


/**
 * called in page comments-page.php before the comments respond block
 *
 * @since 1.1
 */
function soil_before_page_respond() {
	do_action( 'soil_before_page_respond' );
}


/**
 * called in page comments-page.php after the comments respond block
 *
 * @since 1.1
 */
function soil_after_page_respond() {
	do_action( 'soil_after_page_respond' );
}


/**
 * called in page comments-page.php before the comments form block
 *
 * @since 1.1
 */
function soil_before_page_comments_form() {
	do_action( 'soil_before_page_comments_form' );
}


/**
 * called in page comments-page.php to include the comments form block
 *
 * @since 1.1
 */
function soil_page_comments_form() {
	do_action( 'soil_page_comments_form' );
}


/**
 * called in page comments-page.php after the comments form block
 *
 * @since 1.1
 */
function soil_after_page_comments_form() {
	do_action( 'soil_after_page_comments_form' );
}


/**
 * deprecated
 *
 * @since 1.1
 */
function soil_page_comment() {
	do_action( 'soil_page_comment' );
}


/**
 * Blog action hooks
 *
 */


/**
 * called in loop.php before the loop executes
 *
 * @since 1.1
 */
function soil_before_blog_loop() {
	do_action( 'soil_before_blog_loop' );
}


/**
 * called in loop.php before the blog post section
 *
 * @since 1.1
 */
function soil_before_blog_post() {
	do_action( 'soil_before_blog_post' );
}


/**
 * called in loop.php before the blog post title tag
 *
 * @since 1.1
 */
function soil_before_blog_post_title() {
	do_action( 'soil_before_blog_post_title' );
}


/**
 * called in loop.php after the blog post title tag
 *
 * @since 1.1
 */
function soil_after_blog_post_title() {
	do_action( 'soil_after_blog_post_title' );
}


/**
 * called in loop.php before the blog post content
 *
 * @since 1.1
 */
function soil_before_blog_post_content() {
	do_action( 'soil_before_blog_post_content' );
}


/**
 * called in loop.php after the blog post content
 *
 * @since 1.1
 */
function soil_after_blog_post_content() {
	do_action( 'soil_after_blog_post_content' );
}


/**
 * called in loop.php after the blog post section
 *
 * @since 1.1
 */
function soil_after_blog_post() {
	do_action( 'soil_after_blog_post' );
}


/**
 * called in blog loop.php after the loop endwhile
 *
 * @since 1.1
 */
function soil_after_blog_endwhile() {
	do_action( 'soil_after_blog_endwhile' );
}


/**
 * called in blog loop.php after the loop else
 *
 * @since 1.1
 */
function soil_blog_loop_else() {
	do_action( 'soil_blog_loop_else' );
}


/**
 * called in blog loop.php after the loop executes
 *
 * @since 1.1
 */
function soil_after_blog_loop() {
	do_action( 'soil_after_blog_loop' );
}


/**
 * called in blog comments-blog.php before the comments list block
 *
 * @since 1.1
 */
function soil_before_blog_comments() {
	do_action( 'soil_before_blog_comments' );
}


/**
 * called in blog comments.php in the ol block
 *
 * @since 1.1
 */
function soil_list_blog_comments() {
	do_action( 'soil_list_blog_comments' );
}


/**
 * called in blog comments-blog.php after the comments list block
 *
 * @since 1.1
 */
function soil_after_blog_comments() {
	do_action( 'soil_after_blog_comments' );
}


/**
 * called in blog comments.php before the pings list block
 *
 * @since 1.1
 */
function soil_before_blog_pings() {
	do_action( 'soil_before_blog_pings' );
}


/**
 * called in blog comments.php in the ol block
 *
 * @since 1.1
 */
function soil_list_blog_pings() {
	do_action( 'soil_list_blog_pings' );
}


/**
 * called in blog comments.php after the pings list block
 *
 * @since 1.1
 */
function soil_after_blog_pings() {
	do_action( 'soil_after_blog_pings' );
}


/**
 * called in blog comments-blog.php before the comments respond block
 *
 * @since 1.1
 */
function soil_before_blog_respond() {
	do_action( 'soil_before_blog_respond' );
}


/**
 * called in blog comments-blog.php after the comments respond block
 *
 * @since 1.1
 */
function soil_after_blog_respond() {
	do_action( 'soil_after_blog_respond' );
}


/**
 * called in blog comments-blog.php before the comments form block
 *
 * @since 1.1
 */
function soil_before_blog_comments_form() {
	do_action( 'soil_before_blog_comments_form' );
}


/**
 * called in blog comments-blog.php to include the comments form block
 *
 * @since 1.1
 */
function soil_blog_comments_form() {
	do_action( 'soil_blog_comments_form' );
}


/**
 * called in blog comments-blog.php after the comments form block
 *
 * @since 1.1
 */
function soil_after_blog_comments_form() {
	do_action( 'soil_after_blog_comments_form' );
}


/**
 * deprecated
 *
 * @since 1.1
 */
function soil_blog_comment() {
	do_action( 'soil_blog_comment' );
}


/**
 * Custom post type action hooks
 *
 */


/**
 * called in loop-[custom-post-type].php before the loop executes
 *
 * @since 1.1
 */
function soil_before_loop() {
	do_action( 'soil_before_loop' );
}


/**
 * called in loop-[custom-post-type].php before the post section
 *
 * @since 1.1
 */
function soil_before_post() {
	do_action( 'soil_before_post' );
}


/**
 * called in loop-[custom-post-type].php before the post title
 *
 * @since 1.1
 */
function soil_before_post_title() {
	do_action( 'soil_before_post_title' );
}


/**
 * called in loop-[custom-post-type].php after the post title
 *
 * @since 1.1
 */
function soil_after_post_title() {
	do_action( 'soil_after_post_title' );
}


/**
 * called in loop-[custom-post-type].php before the post content
 *
 * @since 1.1
 */
function soil_before_post_content() {
	do_action( 'soil_before_post_content' );
}


/**
 * called in loop-[custom-post-type].php after the post content
 *
 * @since 1.1
 */
function soil_after_post_content() {
	do_action( 'soil_after_post_content' );
}


/**
 * called in loop-[custom-post-type].php after the post section
 *
 * @since 1.1
 */
function soil_after_post() {
	do_action( 'soil_after_post' );
}


/**
 * called in loop-[custom-post-type].php after the loop endwhile
 *
 * @since 1.1
 */
function soil_after_endwhile() {
	do_action( 'soil_after_endwhile' );
}


/**
 * called in loop-[custom-post-type].php after the loop else
 *
 * @since 1.1
 */
function soil_loop_else() {
	do_action( 'soil_loop_else' );
}


/**
 * called in loop-[custom-post-type].php after the loop executes
 *
 * @since 1.1
 */
function soil_after_loop() {
	do_action( 'soil_after_loop' );
}


/**
 * called in comments-[custom-post-type].php before the comments list block
 *
 * @since 1.1
 */
function soil_before_comments() {
	do_action( 'soil_before_comments' );
}


/**
 * called in comments-[custom-post-type].php in the ol block
 *
 * @since 1.1
 */
function soil_list_comments() {
	do_action( 'soil_list_comments' );
}


/**
 * called in comments-[custom-post-type].php after the comments list block
 *
 * @since 1.1
 */
function soil_after_comments() {
	do_action( 'soil_after_comments' );
}


/**
 * called in comments-[custom-post-type].php before the pings list block
 *
 * @since 1.1
 */
function soil_before_pings() {
	do_action( 'soil_before_pings' );
}


/**
 * called in comments-[custom-post-type].php in the ol block
 *
 * @since 1.1
 */
function soil_list_pings() {
	do_action( 'soil_list_pings' );
}


/**
 * called in comments-[custom-post-type].php after the pings list block
 *
 * @since 1.1
 */
function soil_after_pings() {
	do_action( 'soil_after_pings' );
}


/**
 * called in comments-[custom-post-type].php before the comments respond block
 *
 * @since 1.1
 */
function soil_before_respond() {
	do_action( 'soil_before_respond' );
}


/**
 * called in comments-[custom-post-type].php after the comments respond block
 *
 * @since 1.1
 */
function soil_after_respond() {
	do_action( 'soil_after_respond' );
}


/**
 * called in comments-[custom-post-type].php before the comments form block
 *
 * @since 1.1
 */
function soil_before_comments_form() {
	do_action( 'soil_before_comments_form' );
}


/**
 * called in comments-[custom-post-type].php to include the comments form block
 *
 * @since 1.1
 */
function soil_comments_form() {
	do_action( 'soil_comments_form' );
}


/**
 * called in comments-[custom-post-type].php after the comments form block
 *
 * @since 1.1
 */
function soil_after_comments_form() {
	do_action( 'soil_after_comments_form' );
}


/**
 * deprecated
 *
 * @since 1.1
 *
 */
function soil_comment() {
	do_action( 'soil_comment' );
}


/**
 * sidebar hooks
 *
 */


/**
 * called in the sidebar template files before the widget section
 *
 * @since 1.1
 */
function soil_before_sidebar_widgets() {
	do_action( 'soil_before_sidebar_widgets' );
}


/**
 * called in the sidebar template files after the widget section
 *
 * @since 1.1
 */
function soil_after_sidebar_widgets() {
	do_action( 'soil_after_sidebar_widgets' );
}


/**
 * footer hooks
 *
 */


/**
 * called in the footer.php before the footer section
 *
 * @since 1.1
 */
function soil_before_footer() {
	do_action( 'soil_before_footer' );
}


/**
 * invokes the footer section called in footer.php
 *
 * @since 1.1
 */
function soil_footer() {
	do_action( 'soil_footer' );
}


/**
 * called in the footer.php after the footer section
 *
 * @since 1.1
 */
function soil_after_footer() {
	do_action( 'soil_after_footer' );

}


/**
 * admin hooks
 *
 */


/**
 * called in admin-options.php  to create a sub-menu page under theme menu
 *
 * @since 1.2
 */
function soil_add_submenu_page() {
	do_action( 'soil_add_submenu_page' );
}


/**
 * called in admin-options.php  to create the sub-menu page content
 *
 * @since 1.2
 */
function soil_add_submenu_page_content() {
	do_action( 'soil_add_submenu_page_content' );
}


