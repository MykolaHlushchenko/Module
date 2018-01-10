<?php
/**
 * Course speaker repository
 *
 * @category  Nobel
 * @package   Nobel\Course
 * @author    Peter Chmeruk <pechm@smile.fr>
 * @copyright 2017 Smile
 */
namespace Smile\SetupTest\Model;

use Smile\SetupTest\Api\Data;
use Smile\SetupTest\Api\UserRepositoryInterface;
use Smile\SetupTest\Model\ResourceModel\User as ResourceUser;
use Smile\SetupTest\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class UserRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Speaker resource model
     *
     * @var UserRepository
     */
    protected $resource;

    /**
     * Speaker resource factory
     *
     * @var ResourceUserFactory
     */
    protected $userFactory;

    /**
     * User collection factory
     *
     * @var UserCollectionFactory
     */
    protected $userCollectionFactory;

    /**
     * Speaker search results interface
     *
     * @var Data\UserSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * Constructor
     *
     * @param ResourceUser                           $resource                 Resource speaker model
     * @param SpeakerFactory                            $speakerFactory           Speaker factory
     * @param SpeakerCollectionFactory                  $speakerCollectionFactory Speaker Collection factory
     * @param Data\SpeakerSearchResultsInterfaceFactory $searchResultsFactory     Search results factory
     */
    public function __construct(
        ResourceUser $resource,
        UserFactory $userFactory,
        UserCollectionFactory $userCollectionFactory,
        Data\UserSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->userFactory = $userFactory;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Speaker
     *
     * @param Data\SpeakerInterface $speaker
     * @return Data\SpeakerInterface
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
     * Load speaker data by given speaker identity
     *
     * @param string $entityId
     * @return User
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        $user = $this->userFactory->create();
        $this->resource->load($user, $entityId);
        if (!$user->getId()) {
            throw new NoSuchEntityException(__('Speaker with id "%1" does not exist.', $entityId));
        }
        return $user;
    }


    /**
     * Load speaker data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return \Nobel\Course\Model\ResourceModel\Speaker\Collection
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->userCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $speakers = [];
        /** @var Data\SpeakerInterface $speakerModel */
        foreach ($collection as $speakerModel) {
            $speakers[] = $speakerModel;
        }
        $searchResults->setItems($speakers);
        return $searchResults;
    }

    /**
     * Delete speaker
     *
     * @param Data\SpeakerInterface $speaker
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
     * Delete speaker by given identity
     *
     * @param string $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }
}
