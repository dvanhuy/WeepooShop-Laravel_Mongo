<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Bill;
use App\Models\Figure;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getFiguresForm(Request $request){
        $figures= Figure::getQuery()->where('deleted_at', null);
        if($request->has("search")){
            // có mệnh đề where
            $figures =  $figures->where('ten', 'like', '%'.$request->input("search").'%');
        }
        $figures=$figures->orderBy('updated_at', 'desc');
        $figures=$figures->paginate(10);
        return view("Admin.manageFigures",["figures"=> $figures]);
        // if($request->has("search-column") && $request->has("search-column-value")){
        //     // có mệnh đề where
        //     $figures =  $figures->where($request->input("search-column"), 'like', '%'.$request->input("search-column-value").'%');
        // }

        // if($request->has("order")){
        //     //có tham số order -> nhấn vào nút tìm
        //     switch ($request->input("order")) {
        //         case 'priceasc':
        //             $figures = $figures->orderByRaw('gia * 1 asc');
        //             break;
        //         case 'pricedesc':
        //             $figures = $figures->orderByRaw('gia * 1 desc');
        //             break;
        //         case 'oldest':
        //             $figures = $figures->orderBy('updated_at', 'asc');
        //             break;
        //         case 'recently':
        //             $figures = $figures->orderBy('updated_at', 'desc');
        //             break;
        //         default:
        //             $figures = $figures->orderBy('updated_at', 'desc');
        //     }
        // }
        // else {
        //     $figures = $figures->orderBy('updated_at', 'desc');
        // }
        
        // $figures=$figures->paginate(30);
        // return view("Admin.manageFigures",["figures"=> $figures]);
    }

    public function getTrashFiguresForm(Request $request){
        $figures= Figure::getQuery()->whereNotNull('deleted_at');
        if($request->has("search")){
            // có mệnh đề where
            $figures =  $figures->where('ten', 'like', '%'.$request->input("search").'%');
        }
        $figures=$figures->orderBy('updated_at', 'desc');
        $figures=$figures->paginate(10);
        return view("Admin.manageTrashFigures",["figures"=> $figures]);
    }
    public function getUsersForm(Request $request){
        $users= User::getQuery()->where('deleted_at', null);
        if($request->has("search")){
            // có mệnh đề where
            $users =  $users->where('email', 'like', '%'.$request->input("search").'%');
        }
        $users=$users->orderBy('updated_at', 'desc');
        $users=$users->paginate(15);
        return view("Admin.manageUsers",["users"=> $users]);
    }

    public function getFormUpdateUser(User $userID)
    {
        return view("Admin.update_user",["user"=> $userID]);
    }

    public function updateUser(UpdateUserRequest $request, User $userID)
    {
        $user = $request->validated();
        if ($request->hasFile('avatar')) {
            //xóa ảnh cũ
            $old_image_path = $userID['avatar'];
            if($old_image_path != null && $old_image_path != 'images/avatardefault.png' && !str_contains($old_image_path,"http")) {
                preg_match("/upload\/(?:v\d+\/)?([^\.]+)/", $old_image_path, $matches);
                Cloudinary::uploadApi()->destroy($matches[1]);
            }
            $uploadedFileUrl = Cloudinary::upload($request->file('avatar')->getRealPath())->getSecurePath();
            $user['avatar'] =  $uploadedFileUrl;
        }
        $status = $userID->update($user);
        if ($status) {
            return redirect()->back()->with([
                'status' => 'Đã cập nhật thông tin thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Cập nhật thất bại'
        ]);
    }
    public function deleteUser(User $userID)
    {
        $check = $userID->delete();
        if ($check) {
            return redirect()->back()->with([
                'status' => 'Đã xóa người dùng thành công'
            ]);
        }
        return redirect()->back()->with([
            'status' => 'Xóa thất bại'
        ]);
    }
    
    public function getBillsForm(Request $request)
    {
        $bills= Bill::getQuery();

        // if($request->has("search")){
        //     // có mệnh đề where
        //     $users =  $users->where('email', 'like', '%'.$request->input("search").'%');
        // }
        $bills=$bills->orderBy('updated_at', 'desc');
        $bills=$bills->paginate(15);
        return view("Admin.manageBills",["bills"=> $bills]);
    }
}
