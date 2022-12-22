<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class ProductOnHandCriteria extends Criteria
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

    /**
     */
    public function setLastModifiedFrom(string $lastModifiedFrom): self
    {
        return $this->addCriteria('lastModifiedFrom', $lastModifiedFrom);
    }
}
