<?php
namespace App\Handlers;

use Image;

class ImageUploadHandler
{
	protected $allow = ['image/jpeg', 'image/png', 'image/gif'];

	public function save($pic, $folder, $max_width = false)
	{
		// 文件路径
		$folder_name = "uploads/images/$folder/" . date("Ym/d", time());
		// 存储路径
		$upload_path = public_path() . '/' . $folder_name;
		// 文件扩展名
		$extension = $pic->getClientOriginalExtension();
		// 文件名
		$filename = time() . '_' . str_random(10) . '.' . $extension;

		// 上传格式验证
		$type = $pic->getMimeType();
		if(!in_array($type, $this->allow)) {
			return false;
		}
		$pic->move($upload_path, $filename);

		// 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

		return [
			'path' => config('app.url') . "/$folder_name/$filename"
		];
	}

	public function reduceSize($file_path, $max_width)
	{
		// 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
	}
}