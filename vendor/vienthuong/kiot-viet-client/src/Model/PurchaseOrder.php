<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

class PurchaseOrder extends BaseModel
{
    const STATUSES = [
        '' => 0,
        'PENDING' => 1,
        'COMPLETED' => 3,
        'CANCELED' => 4,
    ];

    const STATUSES_REVERT = [
        0 => '',
        1 => 'PENDING',
        3 => 'COMPLETED',
        4 => 'CANCELED',
    ];

    const STATUSES_COLOR = [
        0 => '',
        1 => 'info',
        2 => 'success',
        4 => 'danger',
    ];

    /**
     * @var array|null
     */
    protected $otherProperties;

    /**
     * @var int
     */
    protected $status;

    /**
     */
    public function getOtherProperties(): ?array
    {
        return $this->otherProperties;
    }

    /**
     */
    public function setOtherProperties(?array $otherProperties): void
    {
        $this->otherProperties = $otherProperties;
    }

    /**
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }
}
