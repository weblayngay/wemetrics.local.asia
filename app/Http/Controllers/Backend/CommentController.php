<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\AdminUser;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    private $view = '.comment';
    private $model = 'comment';
    private $adminUserModel;
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
        $this->adminUserModel = new AdminUser();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = COMMENT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $comments = $this->commentModel::query()->orderBy('comment_id', 'DESC')->paginate(50);
        $data['comments'] = $comments;
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $id = (int) request()->get('id', 0);
        $user = Auth::guard('admin')->user();
        $comment = $this->commentModel::query()->where('comment_id', $id)->first();
        if($comment){
            $data['title'] = COMMENT_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['comment'] = $comment;
            $data['adminName']  = $user->username;
            $data['adminId']  = $user->aduser_id;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy comment';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật commnent thành công.';
        $error   = 'Cập nhật comment thất bại.';
        $params = $this->commentModel->revertAlias(request()->post());

        try {
            $this->commentModel::query()->where('comment_id', $id)->update($params);
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function active(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Bật comment thành công.';
        $error   = 'Bật comment thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->commentModel->query()->whereIn('comment_id', $ids)->update(['comment_status' => 'approved']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->commentModel->query()->whereIn('comment_id', $ids)->update(['comment_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inactive(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Tắt comment thành công.';
        $error   = 'Tắt comment thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->commentModel->query()->whereIn('comment_id', $ids)->update(['comment_status' => 'unapproved']);
        if($number > 0) {
            $user = Auth::guard('admin')->user();
            $adminName  = $user->username;
            $adminId  = $user->aduser_id;
            $this->commentModel->query()->whereIn('comment_id', $ids)->update(['comment_updated_by' => $adminId]);
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}
