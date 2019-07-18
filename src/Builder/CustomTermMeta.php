<?php

namespace Mayfifteenth\FamilyArchive\Builder;

/**
 * Custom Term Meta adds an image selector to all available Term Meta
 */
class CustomTermMeta
{
    /**
     * Term is used to hold the current term having the meta applied to it.
     * 
     * @var string
     */
    private $term;

    /**
     * The constructor takes in the key on instatiation since it's used for all variables.
     * 
     * @param string $term
     */
    public function __construct(string $term)
    {
        $this->term = $term;

        if (is_admin()) {
            $this->initializeTermMeta();
		}
    }

    /**
     * Initialized only on the admin, otherwise this class sit quietly 
     * 
     * @return void
     */
    private function initializeTermMeta() : void
    {
            add_action('admin_enqueue_scripts', array( $this, 'mediaLibUploaderEnqueue'));
			add_action( $this->term . '_add_form_fields',  array( $this, 'createScreenFields'), 10, 1 );
			add_action( $this->term . '_edit_form_fields', array( $this, 'editScreenFields' ),  10, 2 );

			add_action( 'created_' . $this->term, array( $this, 'save_data' ), 10, 1 );
			add_action( 'edited_' . $this->term,  array( $this, 'save_data' ), 10, 1 );
    }

    /**
     * Create screen fields builds the form fields for the create screen
     */
    public function createScreenFields($taxonomy)
    {
		$imageValue = '';

        printf('<div class="form-field term-cf_%1$s_image-wrap">
            <label for="cf_%1$s_image">Image</label>
            <input id="image-url" type="text" name="cf_%1$s_image" value="%2$s" />
            <input id="upload-button" type="button" class="button" value="Upload Image" />
        </div>', $taxonomy, esc_attr($imageValue));
    }

    /**
     * Edit screen fields builds the form fields for the edit screen
     */
    public function editScreenFields( $term, $taxonomy )
    {
		$imageValue = get_term_meta( $term->term_id, 'cf_'.$taxonomy.'_image', true );

        if( empty( $imageValue ) ) $imageValue = '';
        
        printf('<tr class="form-field term-cf_%1$s_image-wrap">
            <th scope="row">
                <label for="cf_%1$s_image">Image</label>
            </th>
            <td>
                <input id="image-url" type="text" name="cf_%1$s_image" value="%2$s" />
                <input id="upload-button" type="button" class="button" value="Upload Image" />
            </td>
        </tr>', $taxonomy, esc_attr( $imageValue ));
    }
    
    /**
     * Save the data from the media uploader
     */
    public function save_data( $term_id )
    {
        $saveValue = sprintf('cf_%s_image', $this->term);

		$cf_new_image = isset( $_POST[ $saveValue ] ) ? $_POST[ $saveValue ] : '';

		update_term_meta( $term_id, $saveValue, $cf_new_image );
	}

    /**
     * Enqueue the scripts needed to make the image uplader work correctly
     */
    function mediaLibUploaderEnqueue() {
        wp_enqueue_media();
        wp_register_script( 'media-lib-uploader-js', plugins_url( '../../assets/js/media-lib-uploader.js' , __FILE__ ), array('jquery') );
        wp_enqueue_script( 'media-lib-uploader-js' );
    }
}