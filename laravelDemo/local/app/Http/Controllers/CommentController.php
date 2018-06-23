<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Comment;
use App\TinTuc;

class CommentController extends Controller
{
    //

	public function getXoa($id, $idTinTuc) {
		$comment = Comment::find($id);
		$comment->delete();

		return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao_comment', 'Xóa bình luận thành công.');
	}

	public function postComment($id, Request $request){
		$comment = new Comment();
		$tintuc = TinTuc::find($id);
		$comment->idTinTuc = $id;
		$comment->idUser = Auth::user()->id;
		$comment->NoiDung = $request->NoiDung;
		$comment->save();

		return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao', 'Gửi bình luận thành công');
	}

}
