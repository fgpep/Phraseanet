<?php
/**
 * This file is part of Phraseanet
 *
 * (c) 2005-2016 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Collection\Factory;

use App\Collection\CollectionFactory;
use App\Collection\CollectionRepository;
use App\Collection\CollectionRepositoryFactory;
use App\Collection\Reference\CollectionReferenceRepository;
use App\Collection\Repository\DbalCollectionRepository;
use App\Databox\DataboxConnectionProvider;

class DbalCollectionRepositoryFactory implements CollectionRepositoryFactory
{

    /**
     * @var CollectionReferenceRepository
     */
    private $collectionReferenceRepository;

    /**
     * @var DataboxConnectionProvider
     */
    private $databoxConnectionProvider;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param DataboxConnectionProvider $connectionProvider
     * @param CollectionFactory $collectionFactory
     * @param CollectionReferenceRepository $referenceRepository
     */
    public function __construct(
        DataboxConnectionProvider $connectionProvider,
        CollectionFactory $collectionFactory,
        CollectionReferenceRepository $referenceRepository
    ) {
        $this->databoxConnectionProvider = $connectionProvider;
        $this->collectionFactory = $collectionFactory;
        $this->collectionReferenceRepository = $referenceRepository;
    }

    /**
     * @param int $databoxId
     * @return CollectionRepository
     */
    public function createRepositoryForDatabox($databoxId)
    {
        $databoxConnection = $this->databoxConnectionProvider->getConnection($databoxId);

        return new DbalCollectionRepository(
            $databoxId,
            $databoxConnection,
            $this->collectionReferenceRepository,
            $this->collectionFactory
        );
    }
}
