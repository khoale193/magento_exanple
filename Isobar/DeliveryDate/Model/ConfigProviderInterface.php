<?php
namespace Isobar\DeliveryDate\Model;

/**
 * Interface ConfigProviderInterface
 * @api
 */
interface ConfigProviderInterface
{
    /**
     * Retrieve assoc array of delivery date configuration
     *
     * @return array
     */
    public function getConfig();
}
