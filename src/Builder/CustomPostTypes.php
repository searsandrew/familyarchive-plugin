<?php

namespace Mayfifteenth\FamilyArchive\Builder;

use Mayfifteenth\FamilyArchive\Core\ConfigManager;

/**
 * Custom Post Types is used to register new custom post types with Wordpress
 */
class CustomPostTypes extends ConfigManager
{
    /**
     * Construct Custom Post Types
     */
    public function __construct()
    {
        $this->setFilename('/custom-posts.json');
        $this->types = $this->getConfigArray();
        $this->errorHeading = 'Custom Post Types Not Found!';
    }

    /**
     * Create Types is used to register the custom post types with Wordpress
     * 
     * @return bool
     */
    public function createTypes() : bool
    {
        $types = $this->types;
        if(!is_array($types) || array_key_exists('error', $types))
        {
            return false;
        }

        foreach($types as $key => $type)
        {
            if(!array_key_exists('label', $type))
            {
                return false;
            }
            register_post_type($key, $type);
        }

        return true;
    }
}