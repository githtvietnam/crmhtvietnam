<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class ContractWebsite extends BaseController{

	private $table = 'contract_website';

	public function __construct(){

	}

	public function getDataBeforeInsert(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/contract/website/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}
			$staff = $this->AutoloadModel->_get_where([
				'table' => 'user',
				'select' => 'fullname, id',
				'where' => ['publish' => 1, 'deleted_at' => 0],
				'order_by' => 'fullname asc',
			], true);
			$staff = convert_array([
				'data' => $staff,
				'field' => 'id',
				'value' => 'fullname',
				'text' => 'người phụ trách',
			]);
			$status = getOption('status');
			$process = getOption('process');

			if(is_array($status) == false || is_array($process) == false || is_array($staff) == false){
				$response['message'] = 'Có lỗi xảy ra trong quá trình truy xuất dữ liệu';
				$response['code'] = '23';
				echo json_encode($response);die();
			}else{
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
				$response['data'] = [
					'staff' => $staff,
					'status' => $status,
					'process' =>$process,
				];
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function save(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/contract/website/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				$id = $this->request->getPost('id');
				$method = ($id > 0) ? 'update' : 'create';
		 		$save = $this->store(['method' => $method]);
		 		$flag = 0;
		 		if($method == 'create'){
		 			$flag = $this->AutoloadModel->_insert([
		 				'data' => $save,
		 				'table' => $this->table,
		 			]);
		 		}else{
		 			$flag = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $this->request->getPost('id')]
		 			]);
		 		}
		 		if($flag > 0){
					$primary_id = ($id == 0) ? $flag : $id; //là id của đối tượng
					if($method == 'update'){
						$this->delete_contract_detail($primary_id);
					}
					$this->create_contract_detail($primary_id);
		 			$response['message'] = 'Lưu trữ bản ghi thành công!';
					$response['code'] = '10';
					echo json_encode($response);die();
		 		}else{
		 			$response['message'] = 'Có lỗi xảy ra, Lưu trữ bản ghi không thành công!';
					$response['code'] = '23';
					echo json_encode($response);die();
		 		}
	        }else{
	        	$response['message'] = $this->validator->listErrors();
				$response['code'] = '22';
				echo json_encode($response);die();

	        }

		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function delete_contract_detail(int $id){
		$flag = $this->AutoloadModel->_delete([
			'table' => 'contract_website_detail',
			'where' => ['contractid' => $id]
		]);

		return $flag;
	}

	public function create_contract_detail(int $insert_id = 0){
		$billing = $this->request->getPost('billing');
		$save = [];
		if(isset($billing['billingPrice']) && is_array($billing['billingPrice']) && count($billing['billingPrice'])){
			foreach($billing['billingPrice'] as $key => $val){
				$save[] = [
					'contractid' => $insert_id,
					'money' => convertMoney($val),
					'cashierid' => $billing['billingCashierId'][$key],
					'date' => gettime($billing['billingDate'][$key],'Y-m-d H:i:s'),
				];
			}
		}

		$flag  = $this->AutoloadModel->_create_batch([
			'table' => 'contract_website_detail',
			'data' => $save,
		]);

		return $flag;
	}

	private function store(array $param = []){
		$data = $this->request->getPost('post');

		$store  = [];
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				if($key > 12) break;
				if($val['name'] == 'id') continue;
				$store[$val['name']] = $val['value'];
			}
		}
		$store['total'] = convertMoney($store['total']);
		$store['date_sign'] = gettime($store['date_sign'],'Y-m-d H:i:s');
		if(isset($param['method']) && $param['method'] == 'create'){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
		return $store;
	}


	private function validation(){
		$validate = [
			'customerid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'customerid' => [
				'is_natural_no_zero' => 'Bạn Phải Nhập Thông Tin Khách Hàng!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
