<?php
// File: template-functions.php
// Contains custom functions for the PhucTheme

if (!function_exists('phuctheme_display_hello')) {
    /**
     * Display a customizable hello message
     *
     * @param string $message The message to display (default: 'Hello WordPress')
     * @param string $tag The HTML tag to use (default: 'h1')
     * @param string $class Additional CSS classes (default: 'text-center mb-4')
     * @return string The formatted HTML message
     */
    function phuctheme_display_hello($message = 'Hello WordPress', $tag = 'h1', $class = 'text-center mb-4') {
        // Sanitize inputs
        $message = esc_html($message);
        $tag = esc_html($tag);
        $class = esc_attr($class);

        // Build the HTML output
        $output = "<{$tag} class='{$class}'>{$message}</{$tag}>";

        return $output;
    }
}

if (!function_exists('phuctheme_display_hello_wrapper')) {
    /**
     * Wrapper function to echo the hello message
     *
     * @param string $message The message to display
     * @param string $tag The HTML tag to use
     * @param string $class Additional CSS classes
     */
    function phuctheme_display_hello_wrapper($message = 'Hello WordPress', $tag = 'h1', $class = 'text-center mb-4') {
        echo phuctheme_display_hello($message, $tag, $class);
    }
}