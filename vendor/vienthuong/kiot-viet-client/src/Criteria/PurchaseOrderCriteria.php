<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class PurchaseOrderCriteria extends Criteria
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

    public function setIncludeOrderDelivery(bool $includeOrderDelivery): self
    {
        return $this->addCriteria('includeOrderDelivery', $includeOrderDelivery);
    }

    public function setStatus(bool $status): self
    {
        return $this->addCriteria('status', $status);
    }
}
