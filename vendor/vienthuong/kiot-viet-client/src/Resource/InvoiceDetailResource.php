<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Resource;

use VienThuong\KiotVietClient\Collection\InvoiceCollection;
use VienThuong\KiotVietClient\Endpoint;
use VienThuong\KiotVietClient\Model\InvoiceDetail;

class InvoiceDetailResource extends BaseResource
{
    public function getEndPoint() : string
    {
        return Endpoint::INVOICE_DETAIL_ENDPOINT;
    }

    public function getExpectedModel() : string
    {
        return Invoice::class;
    }

    public function getCollectionClass() : string
    {
        return InvoiceDetailCollection::class;
    }
}
