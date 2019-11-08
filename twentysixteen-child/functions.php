<?php
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
    function my_theme_enqueue_styles() {
    
        $parent_style = 'twentysixteen-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 'child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );
    }

    if ( ! function_exists( 'contactform7_before_send_mail' ) ) {
        function contactform7_before_send_mail( $form_to_DB ) {
            global $wpdb;
            $form_to_DB = WPCF7_Submission::get_instance();
            if ( $form_to_DB ) 
                $formData = $form_to_DB->get_posted_data();
            $firstname = $formData['firstname'];
            $lastname = $formData['lastname'];
            $email = $formData['email'];
            $date = $formData['date'];
            
            $wpdb->insert( 'contact_form_backup', array( 'firstname' => $firstname, 'lastname' => $lastname, 'email'=> $email, 'date' => $date  ), array( '%s' ) );
        }
        remove_all_filters ('wpcf7_before_send_mail');
        add_action( 'wpcf7_before_send_mail', 'contactform7_before_send_mail' );
    }