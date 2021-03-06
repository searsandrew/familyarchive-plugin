<?php

namespace Mayfifteenth\FamilyArchive\Builder;

use Mayfifteenth\FamilyArchive\Core\ConfigManager;

/**
 * Custom Taxonomy is used to register new custom taxonomies with Wordpress
 */
class CustomTaxonomy extends ConfigManager
{
    /**
     * Construct Custom Taxonomy
     */
    public function __construct()
    {
        $this->setFilename('/custom-taxonomies.json');
        $this->types = $this->getConfigArray();
        $this->errorHeading = 'Custom Taxonomy Not Found!';

        if (is_admin())
        {
            foreach(array_keys($this->types) as $type)
            {
                $termMeta = new CustomTermMeta($type);
            }
        }
    }

    /**
     * Create Types is used to register the custom taxonomies with Wordpress
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
            if(!array_key_exists('objectType', $type))
            {
                return false;
            }
            $objectType = $type['objectType'];
            unset($type['objectType']);
            register_taxonomy($key, $objectType, $type);
        }

        return true;
    }
}