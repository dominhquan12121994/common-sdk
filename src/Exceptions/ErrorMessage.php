<?php

namespace Common\Exceptions;

class ErrorMessage
{
    const ERR_001 = 'Server Exception';
    const ERR_002 = 'Parameter Invalid';
    const ERR_003 = 'Validation Invalid';
    //Warehouse
    const E010500 = 'Kho đang chứa sản phẩm nằm trong đơn hàng chưa hoàn thành';
    const E010501 = 'Không tìm thấy bản ghi';
    //Store
    const E010701 = 'Đơn vị trực thuộc cha không thể là dơn vị trực thuộc hiện tại';
    const E010702 = 'Không chọn được đơn vị trực thuộc hiện tại. Đơn vị trực thuộc đang ngừng hoạt động';
    const E010703 = 'Trực thuộc cha không thể nằm trong trực thuộc con';
    const E010704 = 'Không thể xác định tổ chức của tài khoản hiện tại';
    const E010705 = 'Không tìm thấy bản';
    //ProductCatalog
    const E010900 = 'Loại sản phẩm đang chứa sản phẩm nằm trong đơn hàng chưa hoàn thành';
    const E010901 = 'Loại sản phẩm cha không thể là loại sản phẩm hiện tại';
    const E010902 = 'Không chọn được loại sản phẩm cha hiện tại. Loại sản phẩm cha đang ngừng hoạt động';
    const E010903 = 'Loại sản phẩm cha không thể nằm trong loại sản phẩm con';
    const E010904 = 'Không tìm thấy bản ghi';
    //login
    const E010001 = 'Tên đăng nhập hoặc mật khẩu sai';
}
