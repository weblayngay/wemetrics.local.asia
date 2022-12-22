<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class InvoiceCriteria extends Criteria
{
    public function setBranchIds(string $branchIds): self
    {
        if(is_array($branchIds))
        {
            return $this->addCriteria('branchIds', implode(',', $branchIds));
        }
        else
        {
            return $this->addCriteria('branchIds', $branchIds);
        }
    }

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

    public function setCustomerIds(string $customerIds): self
    {
        if(is_array($customerIds))
        {
           return $this->addCriteria('customerIds', implode(',', $customerIds));
        }
        else
        {
            return $this->addCriteria('customerIds', $customerIds);
        }
    }

    public function setCustomerCode(string $customerCode): self
    {
        if(is_array($customerCode))
        {
           return $this->addCriteria('customerCode', implode(',', $customerCode)); 
        }
        else
        {
            return $this->addCriteria('customerCode', $customerCode);
        }   
    }

    public function setStatus(string $status): self
    {
        if(is_array($status))
        {
           return $this->addCriteria('status', implode(',', $status)); 
        }
        else
        {
            return $this->addCriteria('status', $status);
        }
    }

    public function setCategoryId(int $categoryId): self
    {
        return $this->addCriteria('categoryId', $categoryId);
    }

    public function setOrdersIds(string $orderIds): self
    {
        if(is_array($orderIds))
        {
            return $this->addCriteria('orderIds', implode(',', $orderIds));
        }
        else
        {
            return $this->addCriteria('orderIds', $orderIds);
        }
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
