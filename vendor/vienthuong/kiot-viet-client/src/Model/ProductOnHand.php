<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

class ProductOnHand extends BaseModel
{
    /**
     * @var inventories;
     */
    private $inventories;

    /**
     * @return array
     */
    public function getInventories(): ?array
    {
        return $this->inventories;
    }

    /**
     * @param  array  $inventories
     */
    public function setInventories(?array $inventories): void
    {
        $this->inventories = $inventories;
    }
}
