<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\SetupTest\Api\Data\UserInterface;

/**
 * CMS block CRUD interface.
 * @api
 * @since 100.0.2
 */
interface UserRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Smile\SetupTest\Api\Data\UserInterface $user
     * @return \Smile\SetupTest\Api\Data\UserInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(UserInterface $user);

    /**
     * Retrieve block.
     *
     * @param int $userId
     * @return \Smile\SetupTest\Api\Data\UserInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($userId);

    /**
     * Retrieve blocks matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Smile\SetupTest\Api\Data\UserSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete user.
     *
     * @param \Smile\SetupTest\Api\Data\UserInterface $user
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(UserInterface $user);

    /**
     * Delete block by ID.
     *
     * @param int $userId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($userId);
}
