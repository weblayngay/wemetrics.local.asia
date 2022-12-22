<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Banner;
use App\Models\Block;
use App\Models\Config;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends BaseController
{
    use SEOTools;
    /**
     * @var Banner
     */
    private Banner $bannerModel;

    /**
     * @var Product $productModel
     */
    private Product $productModel;

    /**
     * @var Config
     */
    private Config $configModel;


    /**
     * @var Block
     */
    private Block $blockModel;

    /**
     * IndexController constructor.
     * @param Banner $bannerModel
     * @param Product $productModel
     * @param Config $configModel
     * @param Block $blockModel
     */
    public function __construct(
        Banner $bannerModel,
        Product $productModel,
        Config $configModel,
        Block $blockModel
    )
    {
        $this->bannerModel = $bannerModel;
        $this->productModel = $productModel;
        $this->configModel = $configModel;
        $this->blockModel = $blockModel;
    }


    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $this->seo()->setTitle($this->configModel::getConfig('meta_title'));
        $this->seo()->setDescription($this->configModel::getConfig('meta_description'));
        $this->seo()->metatags()->setKeywords(explode(',', $this->configModel::getConfig('meta_keyword')));
        $blocks = $this->blockModel->findByStatus('activated');

        return \view(
            $this->viewPath . 'index.index',
            [
                'blocks' => $blocks
            ]
        );
    }
}
