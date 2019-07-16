<?php

namespace Mayfifteenth\FamilyArchive\Core;

/**
 * Config Manager is the base system for fetching config files for the plugin to injest
 */
class ConfigManager
{
    /**
     * Types holds the config type settings
     * 
     * @var array
     */
    private $types = [];

    /**
     * Filename is the path and name for the config file
     * 
     * @var string
     */
    private $filename;

    /**
     * WordPress Error message heading
     * 
     * @var string
     */
    public $errorHeading = 'Custom Configuration Not Found!';

    /**
     * WordPress Error message body
     * 
     * @var string
     */
    public $errorMessage = 'Please check the documentation for configuration instructions.';

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
     * Set Filename is used to set the filename to be used
     * 
     * @param string $filename
     * @return void
     */
    public function setFilename(string $filename) : void
    {
        $this->filename = $filename;
    }

    /**
     * Get Config Array gets the file and json decodes it into an array
     * 
     * @return array
     */
    public function getConfigArray() : array
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
        $filepath = get_stylesheet_directory() . $this->filename;
        if(!file_exists($filepath))
        {
            add_action( 'admin_notices', array($this, 'customConfigNotFoundAdminNotice'));
            return '{"error":true}';
        }

        return file_get_contents($filepath);
    }

    public function customConfigNotFoundAdminNotice() {
        $class = 'notice notice-error';

	    printf( '<div class="%1$s"><p><strong>%2$s</strong> %3$s</p></div>', esc_attr( __( $class, 'family-archive' ) ), esc_html( __( $this->errorHeading, 'family-archive' ) ), esc_html( __( $this->errorMessage, 'family-archive') ) );
    }
}