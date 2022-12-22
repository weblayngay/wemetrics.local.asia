<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Criteria;

class InvoiceDetailCriteria extends Criteria
{
    public function setId(string $id): self
    {
        if(is_array($id))
        {
            return $this->addCriteria('id', implode(',', $id));
        }
        else
        {
            return $this->addCriteria('id', $id);
        }
    }
}
