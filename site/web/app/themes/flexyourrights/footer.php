
  </div><!-- /#wrap -->

  <?php roots_footer_before(); ?>
  <footer id="content-info" class="<?php echo WRAP_CLASSES; ?>" role="contentinfo">
    <?php roots_footer_inside(); ?>
    <?php dynamic_sidebar('sidebar-footer'); ?>

    <div class="row">
      <div class="span8">
        <nav id="nav-footer">
          <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills')); ?>
        </nav>
        <div class="about">
          <p>Flex Your Rights (Flex), a 501(c)(3) educational nonprofit, was launched in 2002. Our mission is to educate the public about how basic Bill of Rights protections apply during encounters with law enforcement. To accomplish this, we create and distribute the most compelling, comprehensive and trustworthy know-your-rights media available. <a href="/about/">Read more&hellip;</a></p>
        </div>
        <div class="newsletter well">
          <h3>Get the latest news and offers from Flex Your Rights</h3>
          <?php gravity_form(3, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=false, $tabindex=20); ?>
        </div>
        <p class="copy"><small>Flex Your Rights materials are licensed under a <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 License</a>. <b><a href="/privacy/">Privacy Policy</a></b></small></p>

      </div>
      <div class="span4">
        <p class="donate"><a href="/donate/" class="btn btn-success"><i class="icon-heart icon-white"></i> Donate to Flex Your Rights</a></p>
        <ul class="social group">
          <li><a href="http://www.youtube.com/user/FlexYourRights"><img src="<?= get_template_directory_uri(); ?>/img/icon-youtube.png" alt="Follow Flex Your Rights on YouTube"></a></li>
          <li><a href="http://twitter.com/#!/FlexYourRights"><img src="<?= get_template_directory_uri(); ?>/img/icon-twitter.png" alt="Follow Flex Your Rights on Twitter"></a></li>
          <li><a href="http://www.facebook.com/FlexYourRights"><img src="<?= get_template_directory_uri(); ?>/img/icon-facebook.png" alt="Follow Flex Your Rights on Facebook"></a></li>
        </ul>
      </div>
    </div>
  </footer>
  <?php roots_footer_after(); ?>


  <?php wp_footer(); ?>
  <?php roots_footer(); ?>

<?php if (!is_front_page()) { ?>
<script>
  (function() {
    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
    li.src = 'https://platform.stumbleupon.com/1/widgets.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
  })();
</script>
<?php } ?>

<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0014/0140.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>


</body>
</html>