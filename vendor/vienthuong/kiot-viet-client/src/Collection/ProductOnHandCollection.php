<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Collection;

use VienThuong\KiotVietClient\Model\ProductOnHand;

class ProductOnHandCollection extends Collection
{
    public function getModelClass(): string
    {
        return ProductOnHand::class;
    }
}
