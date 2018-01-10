<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Model;

use Smile\SetupTest\Api\Data\UserInterface;
use Smile\SetupTest\Model\ResourceModel\User as ResourceSmileUser;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * User block model
 *
 * @method User UserId(array $userId)
 * @method array getStoreId()
 */
class User extends AbstractModel implements UserInterface, IdentityInterface
{
    /**
     * CMS block cache tag
     */
    const CACHE_TAG = 'smile_user';

    /**#@+
     * Block's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'smile_users';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceSmileUser::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getUserId()];
    }

    /**
     * Retrieve block id
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    public function getUserName()
    {
        return (string)$this->getData(self::USER_NAME);
    }
    /**
     * Retrieve block identifier
     *
     * @return string
     */
    public function getUserLastName()
    {
        return (string)$this->getData(self::USER_LAST_NAME);
    }

    /**
     * Retrieve block title
     *
     * @return string
     */
    public function getUserBiography()
    {
        return $this->getData(self::USER_BIOGRAPHY);
    }

    /**
     * Retrieve block content
     *
     * @return string
     */
    public function getUserDateOfBirth()
    {
        return $this->getData(self::USER_DATE_OF_BIRTH);
    }

    /**
     * Retrieve block creation time
     *
     * @return string
     */
    public function getUserIsActive()
    {
        return $this->getData(self::USER_IS_ACTIVE);
    }

       /**
     * Set ID
     *
     * @param int $userId
     * @return UserInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Set identifier
     *
     * @param string $userName
     * @return UserInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
    }

    /**
     * Set title
     *
     * @param string $userLastName
     * @return UserInterface
     */
    public function setUserLastName($userLastName)
    {
        return $this->setData(self::USER_LAST_NAME, $userLastName);
    }

    /**
     * Set content
     *
     * @param string $userBiography
     * @return userInterface
     */
    public function setUserBiography($userBiography)
    {
        return $this->setData(self::USER_BIOGRAPHY, $userBiography);
    }

    /**
     * Set creation time
     *
     * @param string $userDateOfBirth
     * @return UserInterface
     */
    public function setUserDateOfBirth($userDateOfBirth)
    {
        return $this->setData(self::USER_DATE_OF_BIRTH, $userDateOfBirth);
    }

    /**
     * Set update time
     *
     * @param string $userIsActive
     * @return UserInterface
     */
    public function setUserIsActive($userIsActive)
    {
        return $this->setData(self::USER_IS_ACTIVE, $userIsActive);
    }

    /**
     * Prepare block's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
