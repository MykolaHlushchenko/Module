<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms block search results.
 * @api
 * @since 100.0.2
 */
interface UserSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return \Smile\SetupTest\Api\Data\UserInterface[]
     */
    public function getItems();

    /**
     * Set blocks list.
     *
     * @param \Smile\SetupTest\Api\Data\UserInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
