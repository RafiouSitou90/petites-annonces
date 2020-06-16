<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait TimestampsTrait
{
    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @return $this
     * @throws Exception
     */
    public function setPrePersistCreatedAtValue(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @return $this
     * @throws Exception
     */
    public function setPreUpdateUpdatedAtValue(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
