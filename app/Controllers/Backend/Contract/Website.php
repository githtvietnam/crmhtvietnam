<?php
namespace App\Controllers\Backend\Contract;
use App\Controllers\BaseController;

class Website extends BaseController{
	protected $data;


	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'contract_website';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/contract/website/index'
		]);

		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}


		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'where' => $where,
			'keyword' => $keyword,
			'count' => TRUE
		]);


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/contract/website/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['objectList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, customerid, userid, fullname, phone, email, address, total, date_sign, contract_file, status, process, description, (SELECT fullname FROM user WHERE user.id = contract_website.userid_created) as creator, created_at, updated_at, (SELECT fullname FROM user WHERE user.id = contract_website.userid) as staff, (SELECT SUM(money) FROM contract_website_detail WHERE contract_website_detail.contractid = contract_website.id) as total_money',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);
		}


		$this->data['template'] = 'backend/contract/website/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề Bản ghi!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$insert = $this->store(['method' => 'create']);
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Thêm mới người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/contract/website/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/contract/website/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, customerid, userid, fullname, phone, email, address, total, date_sign, contract_file, status, process, description',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);

		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/contract/website/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề Bản ghi!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$update = $this->store(['method' => 'update']);
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/contract/website/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/contract/website/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	public function delete($id = 0){

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);

		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/contract/website/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1,'userid_deleted' => $this->auth['id'],'updated_at' => $this->currentTime],
				'where' => ['id' => $_id],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/contract/website/index');
		}

		$this->data['template'] = 'backend/contract/website/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function condition_where(){
		$where = [];
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'title' => $this->request->getPost('title'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}
}
