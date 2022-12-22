<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

/**
 * Class Branch
 * @package VienThuong\KiotVietClient\Model
 *
 * Chi nhánh của cửa hàng
 */
class Branch extends BaseModel
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    private $branchName;

    /**
     * @var string
     */
    private $branchCode;

    /**
     * @var string
     */
    private $contactNumber;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $address;

    /**
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     */
    public function setId(?int $id): void 
    {
        $this->id = $id;
    }

    /**
     */
    public function getBranchName()
    {
        return $this->branchName;
    }

    /**
     */
    public function setBranchName(string $branchName): void
    {
        $this->branchName = $branchName;
    }

    /**
     */
    public function getBranchCode()
    {
        return $this->branchCode;
    }

    /**
     */
    public function setBranchCode(string $branchCode): void
    {
        $this->branchCode = $branchCode;
    }

    /**
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     */
    public function setContactNumber(string $contactNumber): void
    {
        $this->contactNumber = $contactNumber;
    }

    /**
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}
