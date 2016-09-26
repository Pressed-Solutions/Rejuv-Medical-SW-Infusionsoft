<?php
// block direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// add contact to Infusionsoft upon registration
add_action( 'user_register', 'rmswi_user_register' );
function rmswi_user_register( $user_id ) {
    // set up error handling
    $infusionsoft_error = new WP_Error;

    // get user data
    $user_data = get_userdata( $user_id );
    $infusionsoft_user_data = array(
        'FirstName'     => $user_data->first_name ? $user_data->first_name : '',
        'LastName'      => $user_data->last_name ? $user_data->last_name : '',
        'Email'         => $user_data->user_email ? $user_data->user_email : '',
    );
    $infusionsoft_tag = '782'; // ID for “Trigger Campaign -->Tues_Thurs Content Emails” tag

    // send to Infusionsoft
    $infusionsoft_add_contact_response = Infusionsoft_ContactServiceBase::addWithDupCheck( $infusionsoft_user_data, 'Email' );

    // error handling
    if ( ! is_integer( $infusionsoft_add_contact_response ) ) {
        $infusionsoft_error->add( 'addWithDupCheck', 'Something went wrong when adding your user data. Please try again or contact us. <code>' . $infusionsoft_add_contact_response . '</code>', $infusionsoft_response );
    } else {
        // add tag
        $infusionsoft_add_tag_response = Infusionsoft_ContactServiceBase::addToGroup( $infusionsoft_add_contact_response, $infusionsoft_tag );
    }

    // print errors
    if ( is_wp_error( $infusionsoft_error ) ) {
        echo '<ul class="error_list">';
        foreach ( $infusionsoft_error->get_error_messages() as $error ) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }

}
