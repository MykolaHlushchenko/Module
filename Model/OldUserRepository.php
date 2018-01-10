<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Model;

use Magento\Framework\Data\CollectionFactory;
use Smile\SetupTest\Api\UserRepositoryInterface;
use Smile\SetupTest\Api\Data;
use Smile\SetupTest\Model\ResourceModel\User as ResourceUser;
use Smile\SetupTest\Model\ResourceModel\User\Collection as SmileCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class BlockRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var ResourceUser
     */
    protected $resource;

    /**
     * @var UserFactory
     */
    protected $userFactory;

    /**
     * @var SmileCollectionFactory
     */
    protected $userCollectionFactory;

    /**
     * @var Data\UserSearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Smile\SetupTest\Api\Data\UserInterface
     */
    protected $dataUserFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceUser $resource
     * @param UserFactory $userFactory
     * @param Data\UserInterfaceFactory $dataUserFactory
     * @param CollectionFactory $userCollectionFactory
     * @param Data\UserSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceUser $resource,
        UserFactory $userFactory,
        Data\UserInterfaceFactory $dataUserFactory,
        CollectionFactory $userCollectionFactory,
        Data\UserSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null

    ) {
        $this->resource = $resource;
        $this->userFactory = $userFactory;
        $this->dataUserFactory = $dataUserFactory;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();

    }

    /**
     * Save User data
     *
     * @param \Smile\SetupTest\Api\Data\UserInterface $user
     * @return User
     * @throws CouldNotSaveException
     */
    public function save(Data\UserInterface $user)
    {
        try {
            $this->resource->save($user);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $user;
    }

    /**
     * Load User data by given User Identity
     *
     * @param string $userId
     * @return User
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($userId)
    {
        $user = $this->userFactory->create();
        $this->resource->load($user, $userId);
        if (!$user->getUserId()) {
            throw new NoSuchEntityException(__('User with id "%1" does not exist.', $userId));
        }
        return $user;
    }

    /**
     * Load User data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Smile\SetupTest\Api\Data\UserSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Smile\SetupTest\Model\ResourceModel\User\Collection $collection */
        $collection = $this->userCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\UserSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete User
     *
     * @param \Smile\SetupTest\Api\Data\UserInterface $user
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\UserInterface $user)
    {
        try {
            $this->resource->delete($user);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete User by given User Identity
     *
     * @param string $userId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($userId)
    {
        return $this->delete($this->getById($userId));
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 101.1.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Cms\Model\Api\SearchCriteria\BlockCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}
