<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    //

	 public function getDanhSach() {
        $loaitin = LoaiTin::get();
        return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]);
    }

    public function getThem() {
        $theloai = TheLoai::all();
        return view('admin.loaitin.them', ['theloai'=>$theloai]);
    }

    public function postThem(Request $request) {
        $this->validate($request,
            [
                'Ten'=>'required|unique:LoaiTin,Ten|min:3|max:100',
                'TheLoai'=>'required',
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên loại tin.',
                'Ten.unique'=>'Tên loại tin đã tồn tại.',
                'Ten.min'=>'Tên loại tin phải nhập có độ dài từ 3 đến 100 kí tự.',
                'Ten.max'=>'Tên loại tin phải nhập có độ dài từ 3 đến 100 kí tự.',
                'TheLoai.required'=>'Bạn chưa chọn thể loại.',
            ]);

        $loaitin = new LoaiTin();
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTiTle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao', 'Thêm thành công');
    }

    public function getSua($id) {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua', ['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id) {
        $loaitin = LoaiTin::find($id);
        $this->validate($request,
            [
                'Ten'=>'required|min:3|max:100|unique:LoaiTin,Ten,'.$id,
                'TheLoai'=>'required',
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại.',
                'Ten.unique'=>'Tên thể loại đã tồn tại.',
                'Ten.min'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
                'Ten.max'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
                'TheLoai.required'=>'Bạn chưa chọn thể loại.',
            ]);

        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTiTle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sửa thành công.');
    }

    public function getXoa($id) {
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();
        
        return redirect('admin/loaitin/danhsach')->with('thongbao', 'Xóa thành công.');
    }

}
