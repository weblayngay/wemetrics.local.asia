<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

class ProductOnHandInventories extends BaseModel
{
    /**
     * @var string;
     */
    private $branchId;

    /**
     * @var float;
     */
    private $onhand;

    /**
     * @var float;
     */
    private $reserved;

    /**
     * @return string
     */
    public function getBrandId(): ?string
    {
        return $this->branchId;
    }

    /**
     * @param  string  $branchId
     */
    public function setBrandId(?string $branchId): void
    {
        $this->branchId = $branchId;
    }

    /**
     * @return float
     */
    public function getOnHand(): ?float
    {
        return $this->onhand;
    }

    /**
     * @param  float  $onhand
     */
    public function setOnHand(?string $onhand): void
    {
        $this->onhand = $onhand;
    }

    /**
     * @return float
     */
    public function getReserved(): ?float
    {
        return $this->reserved;
    }

    /**
     * @param  float  $reserved
     */
    public function setReserved(?string $reserved): void
    {
        $this->reserved = $reserved;
    }
}
