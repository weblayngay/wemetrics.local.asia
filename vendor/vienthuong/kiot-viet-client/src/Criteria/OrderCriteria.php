<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class OrderCriteria extends Criteria
{
    public function setIncludePayment(bool $includeInventory): self
    {
        return $this->addCriteria('includePayment', $includeInventory);
    }

    public function setIncludeSaleChannel(bool $includeSaleChannel): self
    {
        return $this->addCriteria('SaleChannel', $includeSaleChannel);
    }

    public function setIncludeOrderDelivery(bool $includeOrderDelivery): self
    {
        return $this->addCriteria('includeOrderDelivery', $includeOrderDelivery);
    }

    public function setCustomerIds(array $customerIds): self
    {
        return $this->addCriteria('customerIds', $customerIds);
    }

    public function setBranchIds(array $branchIds): self
    {
        return $this->addCriteria('branchIds', $branchIds);
    }

    public function setCustomerCode(string $customerCode): self
    {
        return $this->addCriteria('customerCode', implode(',', $customerCode));
    }

    public function setStatuses(array $status): self
    {
        return $this->addCriteria('status', implode(',', $status));
    }

    public function setStatus(int $status): self
    {
        return $this->addCriteria('status', $status);
    }

    public function setCategoryId(int $categoryId): self
    {
        return $this->addCriteria('categoryId', $categoryId);
    }
    
    public function setToDate(string $toDate): self
    {
        return $this->addCriteria('toDate', $toDate);
    }

    public function setFromPurchaseDate(string $fromPurchaseDate): self
    {
        return $this->addCriteria('fromPurchaseDate', $fromPurchaseDate);
    }

    public function setToPurchaseDate(string $toPurchaseDate): self
    {
        return $this->addCriteria('toPurchaseDate', $toPurchaseDate);
    }
}
