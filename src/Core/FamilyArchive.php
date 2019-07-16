<?php 

namespace Mayfifteenth\FamilyArchive\Core;

/**
 * Loads Family Archive and extracts options from WordPress. Also makes API availbe to be consumed by Family Archive themes.
 */
final class FamilyArchive {
    /**
     * Store the plugin file so it can be used later
     * 
     * @var string
     */
    public $pluginFile;

    /**
     * Store the plugin resource locator so it can be used later
     * 
     * @var string
     */
    public $pluginUrl;

    /**
     * Store the plugin directory without the trailing slash
     * 
     * @var string
     */
    public $pluginDir;

    /**
     * Construct Family Archive files
     */
    public function __construct(string $pluginFile)
    {
        $this->pluginFile = $pluginFile;
        $this->pluginUrl = plugins_url('/', $pluginFile);
        $this->pluginDir = dirname($pluginFile);
    }

    /**
     * Load configurations and setup plugin
     * 
     * @return void
     */
    public function execute() : void
    {
        $customPosts = new CustomPostTypes();
        $customPosts->createTypes();
    }
}