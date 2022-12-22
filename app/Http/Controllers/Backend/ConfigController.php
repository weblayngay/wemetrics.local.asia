<?php
namespace App\Http\Controllers\Backend;

use App\Helpers\ArrayHelper;
use App\Helpers\UrlHelper;
use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ConfigController extends BaseController
{
    /**
     * @var Config
     */
    private Config $configModel;

    /**
     * @var string
     */
    private $view = '.config';

    /**
     * ConfigController constructor.
     * @param Config $configModel
     */
    public function __construct(Config $configModel)
    {
        $this->configModel = $configModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['configs'] = $this->configModel::parentQuery()->get();
        $data['title'] = 'Quản lý cấu hình';
        $data['view']  = $this->viewPath . $this->view . '.index';
        return view($data['view'] , compact('data'));
    }


    /**
     * @return Application|Factory|View
     */
    public function detail()
    {
        $id = \request()->get('id', null);
        $data['title'] = 'Cấu hình: [Thêm]';
        if ($id != null) {
            $data['title'] = 'Cấu hình: [Sửa]';
            $config = $this->configModel::parentQuery()->find($id);
            $data['config'] = $config;
            if (!$config){
                return redirect()
                    ->to(UrlHelper::admin('config', 'index'))
                    ->with('error', 'Cấu hình không tìm thấy');
            }
        }

        return view($this->viewPath . $this->view . '.detail' , compact('data'));
    }


    /**
     * @param ConfigRequest $request
     * @return RedirectResponse
     */
    public function save(ConfigRequest $request): RedirectResponse
    {
        $id     = $request->post('id', null);
        $name   = $request->post('conf_name', '');
        $key    = $request->post('conf_key', '');
        $value  = $request->post('conf_value', '');
        $description = $request->post('conf_description', '');
        $data = [
            'conf_name'         => strip_tags($name),
            'conf_key'          => strip_tags($key),
            'conf_value'        => $value,
            'conf_status'       => 'activated',
            'conf_description'  => strip_tags($description),
        ];

        $message = 'Tạo mới cấu hình thành công.';
        if ($id > 0){ // Update
            $message = 'Cập nhật cấu hình thành công.';
            $config  = $this->configModel::parentQuery()->find($id);
            if (!$config) {
                return redirect()
                    ->to(UrlHelper::admin('config', 'index'))
                    ->with('error', 'Cấu hình không tìm thấy') ;
            } else {
                unset($data['conf_key']);
                $config->update($data);
            }
        }else{ // Create new
            $newConfig = $this->configModel::parentQuery()->create($data);
            $id = $newConfig->conf_id;
        }


        if ($request->post('action_type') == 'save') {
            return redirect()->to(UrlHelper::admin('config', 'index'))->with('success', $message);
        } else {
            return redirect()->to(UrlHelper::admin('config', 'detail', ['id' => $id]))->with('success', $message) ;
        }
    }


    /**
     * @return RedirectResponse
     */
    public function saveCache(): RedirectResponse
    {
        $configs = $this->configModel::parentQuery()->select(['conf_value', 'conf_key'])->where(['conf_status' => 'activated'])->get();
        $configsArr = [];
        foreach ($configs as $config) {
            $configsArr[$config['conf_key']] = $config['conf_value'];
        }
        Cache::forever('config_model', $configsArr);
        return redirect()->to(UrlHelper::admin('config', 'index'))->with('success', 'Lưu cache thành công, website sẽ nhanh hơn khi lưu cache.');
    }

    /**
     * @return RedirectResponse
     */
    public function clearCache(): RedirectResponse
    {
        Cache::forget('config_model');
        return redirect()->to(UrlHelper::admin('config', 'index'))->with('success', 'Xóa cache thành công. Nên lưu cache để website hoạt động nhanh hơn.');
    }
}
