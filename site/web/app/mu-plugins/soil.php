<?php

// Enable features from Soil
add_action('after_setup_theme', function() {
    add_theme_support('soil-clean-up');
    add_theme_support('soil-disable-trackbacks');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');
    add_theme_support('soil-google-analytics', 'UA-158795146-1');
});
