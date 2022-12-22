<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\FileHelper;
use App\Helpers\UrlHelper;
use App\Http\Requests\AdminMenuRequest;
use App\Models\Block;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlockController extends BaseController
{

    /**
     * @var Block
     */
    private Block $blockModel;

    /**
     * @var string
     */
    private $view = 'block';

    public function __construct(Block $blockModel)
    {
        $this->blockModel = $blockModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['blocks'] = $this->blockModel::parentQuery()->orderBy('block_sorted', 'asc')->get();
        $data['title'] = 'Quản lý Khối ở trang chủ';
        $data['view']  = $this->viewPath . $this->view . '.index';
        return view($data['view'] , compact('data'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function active(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->blockModel::parentQuery()->whereIn('block_id', $ids)->update(['block_status' => 'activated']);
        return back()->with('success', 'Bật khối thành công');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function inactive(Request $request): RedirectResponse
    {
        $ids = $request->post('cid', []);
        $this->blockModel::parentQuery()->whereIn('block_id', $ids)->update(['block_status' => 'inactive']);
        return back()->with('success', 'Tắt khối thành công');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sort(Request $request): RedirectResponse
    {
        $ids     = request()->post('cid', []);
        $sorts   = request()->post('sort', []);
        $redirect = UrlHelper::admin('block', 'index');

        if (!is_array($ids) || count($ids) == 0) {
            return redirect()->to($redirect)->with('error', 'Vui lòng chọn giá trị để sắp xếp');
        }

        foreach ($ids as $key => $id) {
            $this->blockModel::parentQuery()->where('block_id', $id)->update(['block_sorted' => intval($sorts[$key])]);
        }
        return redirect()->to($redirect)->with('success', 'Sắp xếp thành công');
    }

}
