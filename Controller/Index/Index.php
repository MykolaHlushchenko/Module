<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\SetupTest\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Smile\SetupTest\Api\UserRepositoryInterface;
use Smile\SetupTest\Api\Data\UserInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Index extends Action
{
    /**
     * SetupTest User Factory
     *
     * @var UserInterface
     */
    protected $userFactory;

    /**
     * SetupTest User Repository
     *
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Constructor
     *
     * @param Context $context Context
     * @param UserInterfaceFactory $userFactory User Factory
     * @param UserRepositoryInterface $userRepository User Repository
     */

    protected  $searchCriteria;

    public function __construct(
        Context $context,
        UserInterfaceFactory $userFactory,
        UserRepositoryInterface $userRepository,
        SearchCriteriaBuilder $searchCriteria
    )
    {
        parent::__construct($context);
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->searchCriteria = $searchCriteria;
    }

    public function execute()
    {
//        $data = [
//            'user_name' => 'John',
//            'user_lastname' => 'Smith',
//            'user_bioagrafy' => 'Biography by John Smith',
//            'user_dateofbirds' => '10.10.20.17',
//            'user_is_active' => 1
//        ];
//
//        $user = $this->userFactory->create();
//        $user->addData($data);
//        $this->userRepository->save($user);

//        $user = $this->userRepository->getById(5);
//        var_dump($user->getData());

        $users = $this->userRepository->getList($this->searchCriteria->create());
        foreach ($users->getItems() as $user) {
            var_dump($user->getUserName());
        }
        echo "Setup Test user was created!!!";
    }
}