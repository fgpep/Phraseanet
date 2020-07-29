<?php

namespace Alchemy\Phrasea\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="WorkerRunningJob")
 * @ORM\Entity(repositoryClass="Alchemy\Phrasea\Model\Repositories\WorkerRunningJobRepository")
 */
class WorkerRunningJob
{
    const FINISHED = 'finished';
    const RUNNING  = 'running';
    const ERROR    = 'error';
    const ATTEMPT  = 'attempt ';

    const TYPE_PULL     = 'uploader pull';
    const TYPE_PUSH     = 'uploader push';

    const MAX_RESULT = 500;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="databox_id", nullable=true)
     */
    private $databoxId;

    /**
     * @ORM\Column(type="integer", name="record_id", nullable=true)
     */
    private $recordId;

    /**
     * @ORM\Column(type="string", name="work", nullable=true)
     */
    private $work;

    /**
     * @ORM\Column(type="string", name="work_on", nullable=true)
     */
    private $workOn;

    /**
     * @ORM\Column(type="string", name="commit_id", nullable=true)
     */
    private $commitId;

    /**
     * @ORM\Column(type="string", name="asset_id", nullable=true)
     */
    private $assetId;

    /**
     * @ORM\Column(type="string", name="info", nullable=true)
     */
    private $info;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finished;

    /**
     * @ORM\Column(type="string", name="status")
     */
    private $status;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $databoxId
     * @return $this
     */
    public function setDataboxId($databoxId)
    {
        $this->databoxId = $databoxId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataboxId()
    {
        return $this->databoxId;
    }

    /**
     * @param $recordId
     * @return $this
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecordId()
    {
        return $this->recordId;

    }

    /**
     * @param $work
     * @return $this
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param $workOn
     * @return $this
     */
    public function setWorkOn($workOn)
    {
        $this->workOn = $workOn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkOn()
    {
        return $this->workOn;
    }

    /**
     * @param $commitId
     * @return $this
     */
    public function setCommitId($commitId)
    {
        $this->commitId = $commitId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommitId()
    {
        return $this->commitId;
    }

    /**
     * @param $assetId
     * @return $this
     */
    public function setAssetId($assetId)
    {
        $this->assetId = $assetId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * @param $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $published
     * @return $this
     */
    public function setPublished(\DateTime $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param \DateTime $finished
     * @return $this
     */
    public function setFinished(\DateTime $finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
