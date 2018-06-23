<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;

class PagesController extends Controller
{
    //
    function __construct(){
    	$theloai = TheLoai::all();
    	$slide = Slide::all();
    	view()->share('theloai', $theloai);
    	view()->share('slide', $slide);
    }

    function trangchu(){
    	
    	return view('pages.trangchu');
    }

    function lienhe(){
    	return view('pages.lienhe');
    }

    function gioithieu(){
    	return view('pages.gioithieu');
    }

    function loaitin($id){
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
    	return view('pages.loaitin', ['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }

    function tintuc($id){
    	$tintuc = TinTuc::find($id);
        $tintuc->SoLuotXem ++;
        $tintuc->save();
    	$tinnoibat = TinTuc::where([['NoiBat', '=', 1], ['id', '<>', $tintuc->id]])->orderBy('SoLuotXem', 'desc')->take(4)->get();
    	$tinlienquan = TinTuc::where([['idLoaiTin','=', $tintuc->idLoaiTin], ['id', '<>', $tintuc->id]])->orWhere([['NoiDung', 'like', "%$tintuc->NoiDung%"], ['id', '<>', $tintuc->id]])->orWhere([['TomTat', 'like', $tintuc->TomTat], ['id', '<>', $tintuc->id]])->orderBy('SoLuotXem', 'desc')->take(4)->get();
    	return view('pages.tintuc', ['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }

    function getDangnhap(){
    	return view('pages.dangnhap');
    }

    function postDangnhap(Request $request){
    	$this->validate($request,
    		[
    			'email'=>'required',
    			'password'=>'required|min:3|max:32',
    		],[
    			'email.required'=>'Bạn chưa nhập email.',
    			'password.min'=>'Mật khẩu không dưới 3 kí tự.',
    			'password.max'=>'Mật khẩu tối đa 32 kí tự.',
    		]);
    	if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
    		return redirect('trangchu');
    	}
    	else
    	{
    		return redirect('dangnhap')->with('loi','Đăng nhập không thành công.');
    	}
    }

    function getDangxuat(){
    	Auth::logout();
    	return redirect('trangchu');
    }

    function getNguoidung(){
        return view('pages.nguoidung');
    }

    function postNguoidung(Request $request){
        $user = Auth::user();
        $this->validate($request,
            [
                'name'=>'required|min:3',
            ],
            [
                'name.required'=>'Bạn chưa nhập tên người dùng.',
                'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự.',
            ]);

        $user->name =$request->name;

        if($request->changePassword == "on"){
            $this->validate($request,
            [
                'password'=>'required|min:3|max:32',
                'passwordAgain'=>'required|same:password',
            ],
            [
                'password.required'=>'Bạn chưa nhập mật khẩu.',
                'password.min'=>'Mật khẩu phải có ít nhất 3 kí tự.',
                'password.max'=>'Mật khẩu chỉ được tối đa 32 kí tự.',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu.',
                'passwordAgain.same'=>'Mật khẩu nhập lại chưa đúng.',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('nguoidung')->with('thongbao', 'Sửa thành công');
    }

    function getDangki(){
        return view('pages.dangki');
    }

    function postDangki(Request $request){
        $this->validate($request,
            [
                'name'=>'required|min:3',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:3|max:32',
                'passwordAgain'=>'required|same:password',
            ],
            [
                'name.required'=>'Bạn chưa nhập tên người dùng.',
                'name.min'=>'Tên người dùng phải có ít nhất 3 kí tự.',
                'email.required'=>'Bạn chưa nhập email.',
                'email.email'=>'Bạn chưa nhập đúng định dạng email.',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Bạn chưa nhập mật khẩu.',
                'password.min'=>'Mật khẩu phải có ít nhất 3 kí tự.',
                'password.max'=>'Mật khẩu chỉ được tối đa 32 kí tự.',
                'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu.',
                'passwordAgain.same'=>'Mật khẩu nhập lại chưa đúng.',
            ]);

        $user = new User();
        $user->name =$request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();
        return redirect('dangnhap')->with('thongbao', 'Đăng kí thành công!');
    }

    function timkiem(Request $request){
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe', 'like', "%$tukhoa%")->orWhere('NoiDung', 'like', "%$tukhoa%")->orWhere('TomTat', 'like', "%$tukhoa%")->paginate(5);
        return view('pages.timkiem', ['tintuc'=>$tintuc, 'tukhoa'=>$tukhoa]);
    }

}
