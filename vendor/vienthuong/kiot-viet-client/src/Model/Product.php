<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

use VienThuong\KiotVietClient\Collection\InventoryCollection;
use VienThuong\KiotVietClient\Collection\ProductAttributeCollection;
use VienThuong\KiotVietClient\Collection\ProductUnitCollection;

/**
 * Class Product
 * @package VienThuong\KiotVietClient\Model
 *
 * Hàng hoá
 */
class Product extends BaseModel
{
    /**
     * Hàng combo, sản xuất
     */
    const PRODUCT_TYPE_COMBO_OR_OEM = 1;

    /**
     * Hàng hóa thông thường
     */
    const PRODUCT_TYPE_NORMAL = 2;

    /**
     * Hàng hoá dịch vụ
     */
    const PRODUCT_TYPE_SERVICE = 3;

    /**
     * Loại hàng hóa
     */
    const PRODUCT_TYPE = [
        '1' => 'Hàng combo',
        '2' => 'Hàng hóa thông thường',
        '3' => 'Dịch vụ'
    ];

    /**
     * Theo dõi hạn sử dụng
     */
    const PRODUCT_BATCH_EXPIRED = [
        true => 'Có theo dõi hạn sử dụng',
        false => 'Không theo dõi hạn sử dụng'
    ];

    /**
     * Hàng hoá dịch vụ
     */
    const ALLOWS_SALE = [
        true    => 'Còn bán',
        false   => 'Dừng bán'
    ];

    const ALLOWS_SALE_CLASS = [
        true    => 'badge badge-success',
        false   => 'badge badge-dark'
    ];

    /**
     * Nhóm hàng hóa
     */
    const PRODUCT_CATE = [
        'CX'    => 'Cặp xách',
        //
        'TD'    => 'Túi đeo',
        'TQ'    => 'Túi quàng', // 'Túi quàng vai',
        //
        'TX'    => 'Túi xách',
        'SF'    => 'Túi xách', // Túi cầm tay Sofia
        //
        'VI'    => 'Bóp ví',
        'RS'    => 'Bóp ví', // 'Ví Rosa',
        'AD'    => 'Bóp ví', // 'Ví nam Ando',
        'IP'    => 'Bóp ví', // 'Túi đựng Ipad',
        'CL'    => 'Bóp ví', // 'Clutch',
        //
        'BL'    => 'Balo',
        //
        'DL'    => 'Túi du lịch',
        //
        'NI'    => 'Dây nịt',
        'DA'    => 'Dây nịt',
        'DN'    => 'Dây nịt',
        ///
        'PK'    => 'Phụ kiện',
        'MC'    => 'Phụ kiện', // 'Móc',
        'DC'    => 'Phụ kiện', // 'Dây đeo cổ',
        'DD'    => 'Phụ kiện', // 'Dây đeo chéo',
        //
        'QT'    => 'Quà tặng',
        'HV'    => 'Quà tặng', // 'Hộp ví',
        'HN'    => 'Quà tặng', // 'Hộp nịt',
        'CB'    => 'Quà tặng', // 'Combo',
    ];

    /**
     * Nhóm hàng hóa
     */
    const CATEGORIES = [
        'CX'    => 'Cặp xách',
        //
        'TD'    => 'Túi đeo',
        //
        'TQ'    => 'Túi quàng',
        //
        'TX'    => 'Túi xách',
        //
        'VI'    => 'Bóp ví',
        //
        'BL'    => 'Balo',
        //
        'DL'    => 'Túi du lịch',
        //
        'NI'    => 'Dây nịt',
        //
        'PK'    => 'Phụ kiện',
    ];

    /**
     * Nhóm túi xách
     */
    const CATE_CAPXACH = [
        'CX'    => 'Cặp xách',  
    ];

    /**
     * Nhóm túi đeo
     */
    const CATE_TUIDEO = [
        'TD'    => 'Túi đeo',
    ];

    /**
     * Nhóm túi quàng
     */
    const CATE_TUIQUANG = [
        'TQ'    => 'Túi quàng', // 'Túi quàng vai',    
    ];

    /**
     * Nhóm túi xách
     */
    const CATE_TUIXACH = [
        'TX'    => 'Túi xách',
        'SF'    => 'Túi xách', // Túi cầm tay Sofia        
    ];

    /**
     * Nhóm túi xách
     */
    const CATE_BOPVI = [
        'VI'    => 'Bóp ví',
        'RS'    => 'Bóp ví', // 'Ví Rosa',
        'AD'    => 'Bóp ví', // 'Ví nam Ando',
        'IP'    => 'Bóp ví', // 'Túi đựng Ipad',
        'CL'    => 'Bóp ví', // 'Clutch',    
    ];

    /**
     * Nhóm Balo
     */
    const CATE_BALO = [
        'BL'    => 'Balo',   
    ];

    /**
     * Nhóm Túi du lịch
     */
    const CATE_TUIDULICH = [
        'DL'    => 'Túi du lịch',   
    ];

    /**
     * Nhóm Dây nịt
     */
    const CATE_DAYNIT = [
        'NI'    => 'Dây nịt',
        'DA'    => 'Dây nịt',
        'DN'    => 'Dây nịt', 
    ];

    /**
     * Nhóm pHỤ KIỆN
     */
    const CATE_PHUKIEN = [
        'PK'    => 'Phụ kiện',
        'MC'    => 'Phụ kiện', // 'Móc',
        'DC'    => 'Phụ kiện', // 'Dây đeo cổ',
        'DD'    => 'Phụ kiện', // 'Dây đeo chéo',
    ];

    /**
     * Nhóm QUÀ TẶNG
     */
    const CATE_QUATANG = [
        'QT'    => 'Quà tặng',
        'HV'    => 'Quà tặng', // 'Hộp ví',
        'HN'    => 'Quà tặng', // 'Hộp nịt',
        'CB'    => 'Quà tặng', // 'Combo',
    ];

    /**
     * Loại trừ sản phẩm phụ kiện
     */    
    const PROD_EXCLUDE_PHUKIEN = [
        'PK50K' => 'Phí Khắc Chữ 50K',
        'PKKM50K'  => 'Phí Khắc Khuyến Mãi 50% - 50K',
        'TD03-New' => 'Túi đựng số 3 - Nhỏ',
        'TD04-New' => 'Túi đựng số 4 - Nhí',
        'TD02-New' => 'Túi đựng số 2 - Trung',
        'TD01-New' => 'Túi đựng Số 1 - Đại',
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var array
     */
    private $images;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryName;

    /**
     * @var bool
     */
    private $allowsSale;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $hasVariants;

    /**
     * @var ProductAttributeCollection
     */
    private $attributes;

    /**
     * @var InventoryCollection
     */
    private $inventories;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var int
     */
    private $masterUnitId;

    /**
     * @var int
     */
    private $conversionValue;

    /**
     * @var int
     */
    private $productType;

    /**
     * @var float
     */
    private $basePrice;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var bool
     */
    private $isRewardPoint;

    /**
     * @var string
     */
    private $tradeMarkName;

    /**
     * @var int
     */
    private $masterProductId;

    /**
     * @var string
     */
    private $orderTemplate;

    /**
     * @var ProductUnitCollection
     */
    private $units;

    /**
     * @var bool
     */
    private $isLotSerialControl;

    /**
     * @var string
     */
    private $masterCode;

    /**
     * @return string
     */
    public function getTradeMarkName(): ?string
    {
        return $this->tradeMarkName;
    }

    /**
     */
    public function setTradeMarkName(string $tradeMarkName): void
    {
        $this->tradeMarkName = $tradeMarkName;
    }

    /**
     * @return int
     */
    public function getMasterProductId(): ?int
    {
        return $this->masterProductId;
    }

    /**
     */
    public function setMasterProductId(int $masterProductId): void
    {
        $this->masterProductId = $masterProductId;
    }

    /**
     * @return string
     */
    public function getOrderTemplate(): ?string
    {
        return $this->orderTemplate;
    }

    /**
     */
    public function setOrderTemplate(string $orderTemplate): void
    {
        $this->orderTemplate = $orderTemplate;
    }

    /**
     * @return bool
     */
    public function getIsLotSerialControl(): ?bool
    {
        return $this->isLotSerialControl;
    }

    /**
     */
    public function setIsLotSerialControl(bool $isLotSerialControl): void
    {
        $this->isLotSerialControl = $isLotSerialControl;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return array
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return int
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    /**
     */
    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return bool
     */
    public function getIsAllowsSale(): ?bool
    {
        return $this->allowsSale;
    }

    /**
     */
    public function setAllowsSale(bool $allowsSale): void
    {
        $this->allowsSale = $allowsSale;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function getIsHasVariants(): ?bool
    {
        return $this->hasVariants;
    }

    /**
     */
    public function setHasVariants(bool $hasVariants): void
    {
        $this->hasVariants = $hasVariants;
    }

    /**
     * @return ProductAttributeCollection
     */
    public function getAttributes(): ?ProductAttributeCollection
    {
        return $this->attributes;
    }

    /**
     * @param  ProductAttributeCollection  $attributes
     */
    public function setAttributes(?ProductAttributeCollection $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return InventoryCollection
     */
    public function getInventories(): ?InventoryCollection
    {
        return $this->inventories;
    }

    /**
     * @param  InventoryCollection  $inventories
     */
    public function setInventories(?InventoryCollection $inventories): void
    {
        $this->inventories = $inventories;
    }

    /**
     * @return string
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return int
     */
    public function getMasterUnitId(): ?int
    {
        return $this->masterUnitId;
    }

    /**
     */
    public function setMasterUnitId(int $masterUnitId): void
    {
        $this->masterUnitId = $masterUnitId;
    }

    /**
     * @return int
     */
    public function getConversionValue(): ?int
    {
        return $this->conversionValue;
    }

    /**
     */
    public function setConversionValue(int $conversionValue): void
    {
        $this->conversionValue = $conversionValue;
    }

    /**
     * @return float
     */
    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    /**
     */
    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return float
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return bool
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return bool
     */
    public function getIsRewardPoint(): ?bool
    {
        return $this->isRewardPoint;
    }

    /**
     */
    public function setIsRewardPoint(bool $isRewardPoint): void
    {
        $this->isRewardPoint = $isRewardPoint;
    }

    /**
     * @return int
     */
    public function getProductType(): ?int
    {
        return $this->productType;
    }

    /**
     */
    public function setProductType(int $productType): void
    {
        $this->productType = $productType;
    }

    /**
     * @return ProductUnitCollection
     */
    public function getUnits(): ?ProductUnitCollection
    {
        return $this->units;
    }

    /**
     * @param  ProductUnitCollection  $units
     */
    public function setUnits(?ProductUnitCollection $units): void
    {
        $this->units = $units;
    }

    /**
     * @return string
     */
    public function getMasterCode(): ?string
    {
        return $this->masterCode;
    }

    /**
     * @param  string  $masterCode
     */
    public function setMasterCode(?string $masterCode): void
    {
        $this->masterCode = $masterCode;
    }
}
