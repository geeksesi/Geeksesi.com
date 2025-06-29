<?php

/**
 * Widget registration and setup.
 */

namespace App;

// Ensure widgets are loaded after WordPress initialization
add_action('widgets_init', function () {
    // Widget class is already registered in setup.php
    // This file can be used for additional widget-related functionality
}, 5);
