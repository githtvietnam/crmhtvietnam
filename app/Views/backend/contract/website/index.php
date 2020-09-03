<?php
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Hợp Đồng Website</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Hợp Đồng Website</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Hợp Đồng Website </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 bản ghi</option>
                                        <option value="30">30 bản ghi</option>
                                        <option value="40">40 bản ghi</option>
                                        <option value="50">50 bản ghi</option>
                                        <option value="60">60 bản ghi</option>
                                        <option value="70">70 bản ghi</option>
                                        <option value="80">80 bản ghi</option>
                                        <option value="90">90 bản ghi</option>
                                        <option value="100">100 bản ghi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/contract/website/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Hợp đồng Website Mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example object-list">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th>Thông tin khách hàng</th>
                            <th class="text-left">Thông tin thanh toán</th>
                            <th class="text-left">Thông tin hợp đồng</th>
                            <th class="text-right">Người Tạo</th>
                            <th class="text-right">Ngày Tạo</th>
                            <th class="text-center" style="width:103px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $status = getOPtion('status');
                            ?>
                            <?php if(isset($objectList) && is_array($objectList) && count($objectList)){ ?>
                            <?php foreach($objectList as $key => $val){ ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td class="profile-detail">
                                    <div class="mb5"><span class="label">Họ Tên </span>: <span><?php echo $val['fullname'] ?></span></div>
                                    <div class="mb5"><span class="label">Số điện thoại</span> : <span><?php echo $val['phone'] ?></span></div>
                                    <div class="mb5"><span class="label">Email</span> : <span><?php echo $val['email'] ?></span></div>
                                </td>
                                <td style="color:blue;">
                                    <div class="mb5"><span class="text" style="min-width:100px;display:inline-block;">Tổng Tiền </span>: <span><?php echo number_format($val['total'], 0, ',', '.') ?> VNĐ</span></div>
                                    <div class="mb5"><span class="text" style="min-width:100px;display:inline-block;">Đã Thanh Toán </span>: <span class=" text-navy"><?php echo number_format($val['total_money'], 0, ',', '.') ?> VNĐ</span></div>
                                </td>
                                <td style="color:blue;">
                                    <div class="mb5"><span class="text" style="min-width:100px;display:inline-block;">Phụ Trách </span>: <span><?php echo $val['staff']; ?></span></div>
                                    <div class="mb5"><span class="text" style="min-width:100px;display:inline-block;">Ngày Ký </span>: <span><?php echo gettime($val['date_sign'],'d/m/Y'); ?></span></div>
                                    <div class="mb5"><span class="text" style="min-width:100px;display:inline-block;">Tình Trạng</span> : <span class="text-warning"><?php echo $status[$val['status']]; ?></span></div>
                                </td>
                                <td class="text-right"><?php echo $val['creator'] ?></td>
                                <td class="text-right"><?php echo $val['created_at'] ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/contract/website/update/'.$val['id']) ?>" class="btn btn-primary open-window"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/contract/website/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
