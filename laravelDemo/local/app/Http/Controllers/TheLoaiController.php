<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //

    public function getDanhSach() {
        $theloai = TheLoai::get();
    	return view('admin.theloai.danhsach', ['theloai'=>$theloai]);
    }

    public function getThem() {
    	return view('admin.theloai.them');
    }

    public function postThem(Request $request) {
        $this->validate($request,
            [
                'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại.',
                'Ten.unique'=>'Tên thể loại đã tồn tại.',
                'Ten.min'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
                'Ten.max'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
            ]);

        $theloai = new TheLoai();
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTiTle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao', 'Thêm thành công');
    }

    public function getSua($id) {
    	$theloai = TheLoai::find($id);
        return view('admin.theloai.sua', ['theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id) {
        $theloai = TheLoai::find($id);
        $this->validate($request,
            [
                'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại.',
                'Ten.unique'=>'Tên thể loại đã tồn tại.',
                'Ten.min'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
                'Ten.max'=>'Tên thể loại phải nhập có độ dài từ 3 đến 100 kí tự.',
            ]);

        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTiTle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công.');
    }

    public function getXoa($id) {
        $theloai = TheLoai::find($id);
        if($theloai->loaitin){
            foreach ($theloai->loaitin as $lt) {
                if($lt->tintuc)
                {
                    $tintuc = $lt->tintuc;
                    foreach ($tintuc as $tt) {
                        if($tt->comment){
                            foreach ($tt->comment as $cm) {
                                $cm->delete();
                            }
                            $tt->delete();
                        }
                        else
                            $tt->delete();
                    }
                    $lt->delete();
                }
                else
                    $lt->delete();
            }
            $theloai->delete();
            
        }
        else{
            $theloai->delete();
        }
        
        return redirect('admin/theloai/danhsach')->with('thongbao', 'Xóa thành công.');
    }

}
