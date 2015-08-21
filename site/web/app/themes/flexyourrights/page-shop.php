<?php
/*
Template Name: Shop
*/
get_header(); ?>
  <?php roots_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php roots_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
        <?php if (function_exists('yoast_breadcrumb')) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
        <?php roots_loop_before(); ?>
        <?php get_template_part('loop', 'page'); ?>
        <?php roots_loop_after(); ?>

        <div class="row product bundle">
          <div class="span2">
            <p>
              <a href="https://flexyourrights-org.myshopify.com/products/10-rules-busted-bundle-free-shipping">
                <img src="<?= get_template_directory_uri(); ?>/img/10-rules.jpg" alt="10 Rules for Dealing with Police" class="first">
                <img src="<?= get_template_directory_uri(); ?>/img/busted.jpg" alt="BUSTED" class="last">
              </a>
            </p>
          </div>
          <div class="span6">
            <h2><a href="https://flexyourrights-org.myshopify.com/products/10-rules-busted-bundle-free-shipping">10 Rules &amp; BUSTED Bundle</a></h2>
            <iframe class="shopify-widget" frameborder="0" scrolling="no" src="http://widgets.shopifyapps.com/products/10-rules-busted-bundle-free-shipping?shop=flexyourrights-org.myshopify.com&style=buy_now&product-variant-id=228068348&destination=checkout" width="90" height="24"></iframe>
            <p class="price"><b>$30.00</b> (FREE shipping &amp; handling in USA)</p>
            <p>You don't have to choose! 10 Rules is a bit more polished and classroom friendly, but BUSTED scores the biggest laughs. Get 'em both, and decide for yourself which is your favorite.</p>
          </div>
        </div>

        <div class="row product">
          <div class="span2">
            <p><a href="/10-rules/"><img src="<?= get_template_directory_uri(); ?>/img/10-rules.jpg" alt="10 Rules for Dealing with Police"></a></p>
          </div>
          <div class="span6">
            <h2><a href="/10-rules/">10 Rules for Dealing with Police</a></h2>
            <iframe class="shopify-widget" frameborder="0" scrolling="no" src="http://widgets.shopifyapps.com/products/10rules?shop=flexyourrights-org.myshopify.com&style=buy_now&product-variant-id=216437520" width="90" height="24"></iframe>
            <p class="price"><b>$15.00</b> (+$5.00 shipping &amp; handling)</p>
            <p>The latest DVD from Flex Your Rights, <em>10 Rules</em> is a fast-paced and powerful know-your-rights resource. Ideal for high school and college audiences &ndash; <em>10 Rules</em> helps create more confident and intelligent citizens. Viewers will learn how to deal with traffic stops, street stops &amp; police at your door&hellip; <a href="/10-rules/">More&hellip;</a></p>
          </div>
        </div>

        <div class="row product">
          <div class="span2">
            <p><a href="/busted/"><img src="<?= get_template_directory_uri(); ?>/img/busted.jpg" alt="BUSTED"></a></p>
          </div>
          <div class="span6">
            <h2><a href="/busted/">BUSTED: The Citizen's Guide to Surviving Police Encounters</a></h2>
            <iframe class="shopify-widget" frameborder="0" scrolling="no" src="http://widgets.shopifyapps.com/products/busted?shop=flexyourrights-org.myshopify.com&style=buy_now&product-variant-id=216437524" width="90" height="24"></iframe>
            <p class="price"><b>$15.00</b> (+$5.00 shipping &amp; handling)</p>
            <p>Flex Your Rights' first film, <em>BUSTED</em> has become a cult classic. Humor and helpful tips combine to make this video a must-see for freedom lovers everywhere. Created by Flex Your Rights and narrated by retired ACLU director Ira Glasser, <em>BUSTED</em> realistically depicts the pressure and confusion of common police encounters. <a href="/busted/">More&hellip;</a></p>
          </div>
        </div>

        <div class="alert alert-info">
          <p><b>110% Guaranteed:</b> If our DVDs aren’t the best know-your-rights educational films you’ve ever seen, return it/them for a full refund (including shippping) + an additional 10% of the price of your DVD order.</p>
        </div>

        <p>DVDs will typically ship within 3 business days of your order.</p>


      </div><!-- /#main -->
    <?php roots_main_after(); ?>
    <?php roots_sidebar_before(); ?>
      <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
      <?php roots_sidebar_inside_before(); ?>
        <?php get_sidebar(); ?>
      <?php roots_sidebar_inside_after(); ?>
      </aside><!-- /#sidebar -->
    <?php roots_sidebar_after(); ?>
    </div><!-- /#content -->
  <?php roots_content_after(); ?>
<?php get_footer(); ?>