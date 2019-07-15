<?php

namespace Mayfifteenth\FamilyArchive\Core;

/**
 * Custom Post Types is used to register new custom post types with Wordpress
 */
class CustomPostTypes
{
    /**
     * Types holds the custom post type settings
     * 
     * @var array
     */
    private $types = [];

    /**
     * Construct the Custom Post types and assembled the types.
     */
    public function __construct()
    {
        $this->types = $this->getConfigArray();
    }

    /**
     * Set Types is used to override the types being set in the constructor
     * 
     * @param array $types
     * @return void
     */
    public function setTypes(array $types) : void
    {
        $this->types = $types;
    }

    /**
     * Create Types is used to register the custom post types with Wordpress
     * 
     * @return bool
     */
    public function createTypes() : bool
    {
        $types = $this->types;
        if(!is_array($types))
        {
            return false;
        }

        foreach($types as $key => $type)
        {
            if(!array_key_exists('label', $type[0]))
            {
                return false;
            }
            register_post_type($key, $type[0]);
        }

        return true;
    }

    /**
     * Get Config Array gets the file and json decodes it into an array
     * 
     * @return array
     */
    private function getConfigArray() : array
    {
        $types = $this->getConfigFile();

        return json_decode($types, true);
    }

    /**
     * Get Config File requests a config file from the child theme. If it cannot find one, it will display a notice.
     * 
     * @return string $json
     */
    private function getConfigFile() : string
    {
        $filepath = get_stylesheet_directory() . '/custom-posts.json';
        if(!file_exists($filepath))
        {
            add_action( 'admin_notices', array($this, 'customPostConfigNotFoundAdminNotice'));
            return '';
        }

        return file_get_contents($filepath);
    }

    public function customPostConfigNotFoundAdminNotice() {
        $class = 'notice notice-error';
        $heading = __( 'Custom Post Configuration Not Found!', 'family-archive' );
	    $message = __( 'Please check the documentation for configuration instructions.', 'family-archive' );

	    printf( '<div class="%1$s"><p><strong>%2$s</strong> %3$s</p></div>', esc_attr( $class ), esc_html( $heading ), esc_html( $message ) );
    }
}