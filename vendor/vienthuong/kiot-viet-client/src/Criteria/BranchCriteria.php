<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class BranchCriteria extends Criteria
{
    public function setCode(string $code): self
    {
        return $this->addCriteria('code', $code);
    }

    public function setId(string $code): self
    {
        return $this->addCriteria('code', $code);
    }
}
