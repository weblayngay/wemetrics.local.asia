<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Resource;

use GuzzleHttp\Psr7\Request;
use VienThuong\KiotVietClient\Collection\CollectionInterface;
use VienThuong\KiotVietClient\Collection\ProductOnHandCollection;
use VienThuong\KiotVietClient\Endpoint;
use VienThuong\KiotVietClient\Model\ProductOnHand;

class ProductOnHandResource extends BaseResource
{
    public function getEndPoint() : string
    {
        return Endpoint::PRODUCT_ONHAND_ENDPOINT;
    }

    public function getExpectedModel() : string
    {
        return ProductOnHand::class;
    }

    public function getCollectionClass() : string
    {
        return ProductOnHandCollection::class;
    }
}
