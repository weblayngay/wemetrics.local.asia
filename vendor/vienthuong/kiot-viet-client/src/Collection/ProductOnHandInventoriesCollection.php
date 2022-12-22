<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Collection;

use VienThuong\KiotVietClient\Model\ProductOnHandInventories;

class ProductOnHandInventoriesCollection extends Collection
{
    public function getModelClass(): string
    {
        return ProductOnHandInventories::class;
    }
}
