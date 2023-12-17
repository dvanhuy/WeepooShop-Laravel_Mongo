<?php

namespace App\Http\Controllers;

use App\Http\Requests\Figure\AddFigureRequest;
use App\Models\Figure;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FigureController extends Controller
{
    //
    public function index(Request $request)
    {
        $figures= Figure::getQuery()->where('deleted_at', null);

        if($request->has("search-column") && $request->has("search-column-value")){
            // có mệnh đề where
            $figures =  $figures->where($request->input("search-column"), 'like', '%'.$request->input("search-column-value").'%');
        }

        if($request->has("order")){
            //có tham số order -> nhấn vào nút tìm
            switch ($request->input("order")) {
                case 'priceasc':
                    $figures = $figures->orderBy('gia','asc');
                // $figures = $figures->orderByRaw('gia * 1 asc');
                    break;
                case 'pricedesc':
                    $figures = $figures->orderBy('gia','desc');
                    break;
                case 'oldest':
                    $figures = $figures->orderBy('updated_at', 'asc');
                    break;
                case 'recently':
                    $figures = $figures->orderBy('updated_at', 'desc');
                    break;
                default:
                    $figures = $figures->orderBy('updated_at', 'desc');
            }
        }
        else {
            $figures = $figures->orderBy('updated_at', 'desc');
        }
        
        $figures=$figures->paginate(30);

        return view("Figure.get_list",["figures"=>$figures]);
    }

    public function showDetail(Figure $figureID)
    {
        //model binding
        return view('Figure.get_detail_figure',['figure'=> $figureID]);
    }
    public function getFormAddFigure(Request $request)
    {
        return view('Figure.add_figure');
    }

    public function addFigure(AddFigureRequest $request)
    {
        $figure = $request->validated();
        $figure['gia'] = (int)$figure['gia'];
        $figure['so_luong_hien_con'] = (int)$figure['so_luong_hien_con'];
        $figure['so_luong_da_ban'] = (int)$figure['so_luong_da_ban'];
        if ($request->hasFile('hinh_anh')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('hinh_anh')->getRealPath())->getSecurePath();
            // Cloudinary::uploadApi()
            // $uploadedFileUrl['public_id'];
            $figure['hinh_anh'] =  $uploadedFileUrl;
        } else {
            $figure['hinh_anh']='images/emptyFigure.webp';
        }
        $figure['deleted_at']=null;
        $status = Figure::create($figure);
        if ($status) {
            return redirect()->back()->with([
                'status' => 'Đã thêm mô hình thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Thêm thất bại'
        ]);
    }
    public function getFormUpdateFigure(Figure $figureID)
    {
        return view('Figure.update_figure',['figure'=> $figureID]);
    }

    public function updateFigure(AddFigureRequest $request,Figure $figureID)
    {
        $figure = $request->validated();
        if ($request->hasFile('hinh_anh')) {
            //xóa ảnh cũ
            $old_image_path = $figureID['hinh_anh'];
            if($old_image_path != null && $old_image_path != 'images/emptyFigure.webp' && !str_contains($old_image_path,"http")) {
                preg_match("/upload\/(?:v\d+\/)?([^\.]+)/", $old_image_path, $matches);
                Cloudinary::uploadApi()->destroy($matches[1]);
            }
            $uploadedFileUrl = Cloudinary::upload($request->file('hinh_anh')->getRealPath())->getSecurePath();
            $figure['hinh_anh'] =  $uploadedFileUrl;
        } 
        // else {
        //     $figure['hinh_anh']='images/emptyFigure.webp';
        // }
        $status = $figureID->update($figure);
        if ($status) {
            return redirect()->back()->with([
                'status' => 'Đã cập nhật mô hình thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Cập nhật thất bại'
        ]);
    }
    public function deleteFigure(Figure $figureID){
        // $check = $figureID->delete();
        $figureID->deleted_at = date("Y-m-d H:i:s");
        $check = $figureID->save();
        if ($check) {
            return redirect()->back()->with([
                'status' => 'Đã xóa mô hình thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Xóa mô hình thất bại'
        ]);

    }

    public function restoreFigure(Figure $figureID){
        $figureID->deleted_at = null;
        $check = $figureID->save();
        if ($check) {
            return redirect()->back()->with([
                'status' => 'Đã phục hồi thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Phục hồi thất bại'
        ]);
    }
    public function deletpermaFigure(Figure $figureID){
        $check = $figureID->delete();
        if ($check) {
            return redirect()->back()->with([
                'status' => 'Đã xóa thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Xóa thất bại'
        ]);
    }
}
