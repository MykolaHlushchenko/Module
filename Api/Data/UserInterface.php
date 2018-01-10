<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Api\Data;

/**
 * CMS block interface.
 * @api
 * @since 100.0.2
 */
interface UserInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const USER_ID               = 'user_id';
    const USER_NAME             = 'user_name';
    const USER_LAST_NAME        = 'user_lastname';
    const USER_BIOGRAPHY        = 'user_bioagrafy';
    const USER_DATE_OF_BIRTH    = 'user_dateofbirds';
    const USER_IS_ACTIVE        = 'user_is_active';

    /**#@-*/

    /**
     * Get userID
     *
     * @return int|null
     */
    public function getUserId();

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName();

    /**
     * Get userLastName
     *
     * @return string|null
     */
    public function getUserLastName();

    /**
     * Get userBiography
     *
     * @return string|null
     */
    public function getUserBiography();

    /**
     * Get userDateOfBirth
     *
     * @return string|null
     */
    public function getUserDateOfBirth();

    /**
     * Get user status
     *
     * @return int|null
     */
    public function getUserIsActive();

     /**
     * Set userID
     *
     * @param int $userId
     * @return UserInterface
     */
    public function setUserId($userId);

    /**
     * Set userName
     *
     * @param string $userName
     * @return UserInterface
     */
    public function setUserName($userName);

    /**
     * Set userLastName
     *
     * @param string $userLastName
     * @return UserInterface
     */
    public function setUserLastName($userLastName);

    /**
     * Set userBiography
     *
     * @param string $userBiography
     * @return UserInterface
     */
    public function setUserBiography($userBiography);

    /**
     * Set userDateOfBirth
     *
     * @param string $userDateOfBirth
     * @return UserInterface
     */
    public function setUserDateOfBirth($userDateOfBirth);

    /**
     * Set user status
     *
     * @param string $userIsActive
     * @return UserInterface
     */
    public function setUserIsActive($userIsActive);
}
