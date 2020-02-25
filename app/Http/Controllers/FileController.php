<?php

namespace App\Http\Controllers;

use App\Http\Constants\ResponseCode;
use App\Model\File;
use \App\Model\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FileController extends Controller
{
    public function upload(Request $request) {

        if (!\Auth::check()) {
            return [
              'code' => ResponseCode::未登录,
              'msg' => '尚未登录'
            ];
        }


        $forum_id = session('forum_id');
        $file = $request->file('uploadfile');
        $type = request('type');
        if ($request->isMethod('post')) {
            // 获取文件相关信息
            $size = $file->getClientSize();
            if ($size > 5242880 * 100) {
                return [
                    'code' => '413',
                    'msg' => 'too large'
                ];
            }

            // 上传文件
            $originalName = $file->getClientOriginalName(); // 文件原名
//            $ext = $file->getClientOriginalExtension();     // 扩展名
//            $realPath = $file->getRealPath();   //临时文件的绝对路径
//            $type = $file->getClientMimeType();     // image/jpeg
//            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）

            $returnData = $this->fileUpload($file, 'file');
//            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            if ($returnData != null && $returnData['errno'] == 0) {
//                $returnData['data'] = [
//                    'path' => $path . $newFilename,
//                    'uri' => $fileUri,
//                    'filename' => $newFilename,
//                    'original_filename' => $originalFilename,
//                    'file_hash' => $fileHash,
//                ];
                $file = new File();
                $file->filename = $originalName;
                $file->user_id = \Auth::id();
                $file->forum_id = $forum_id;
                $file->path = $returnData['data']['path'];
                $file->uri = $returnData['data']['uri'];
                $file->hash = $returnData['data']['file_hash'];
                $file->type = $type;
                $file->status = 0;
                $file->save();
            }

        }

        \Log::info('upload file name:' . $originalName . ' type:' . $type);
        if($type == 0) {
            return redirect('examdata/zhenti');
        } else if ($type == 1) {
            return redirect('examdata/data');
        }

        return redirect('examdata');
    }

    public function download($upload_id) {
//        if (!\Auth::check()) {
//            return [
//                'code'=> '401',
//                'msg'=> '尚未登录'
//            ];
//        }
//        $upload = Upload::where('id', $upload_id)->first();

        $file = File::find($upload_id);
        if ($file == null) {
            return [
                'code' => '404',
                'msg' => '未找到资源，可能已经被删除'
            ];

        }
        $bool=DB::update('update files set downloads = downloads+1 where id= ? ',[$file->id]);
        return response()->download($file->path);
    }

    public function uploadImage(Request $request) {

        $returnData = $this->imageUpload($request->file('wangEditorImg'), 'posts', true);
        return response()->json($returnData)->setCallback($request->input('callback'));

    }


    /**
     * @comment 上传文件 图片和文件按理应该分开
     * @param object $file
     * @param string $dirName
     * @return array
     * @author zzp
     * @date 2017-11-03
     */
    public function fileUpload($file, $dirName)
    {
        $returnData = [
            'errno' => -1,
            'msg' => '',
            'data' => ''
        ];

        $yearMonth = sprintf('%s%s', \Carbon\Carbon::now()->year, \Carbon\Carbon::now()->month);
        $path = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth);
        $this->autoMakeDir($path);

//        var_dump($file->getError()); // 0
//        var_dump($file->getFilename()); // php3R7aUM
//        var_dump($file->getExtension());
//        var_dump($file->getClientMimeType()); // image/png
//        var_dump($file->getClientOriginalExtension()); // png
//        var_dump($file->getClientOriginalName()); // bef3df8aly1fbx05q2ra1j20b40b4mxi.png
//        var_dump($file->getErrorMessage()); // The file "bef3df8aly1fbx05q2ra1j20b40b4mxi.png" was not uploaded due to an unknown error.
//        var_dump($file->getBasename()); // php3R7aUM
//        var_dump($file->getPath()); // /tmp
//        var_dump($file->getPathname()); // /tmp/php3R7aUM
//        var_dump($file->getType()); // file
//        var_dump($file->getRealPath()); // /tmp/php3R7aUM

        $error = $file->getError();
        if ($error != 0) {
            $returnData['msg'] = $file->getErrorMessage();
        } else {
            $fileExt = $file->getClientOriginalExtension();
            // 新文件名
            $originalFilename = $file->getClientOriginalName();
            $realFilename = rtrim($originalFilename, '.' . $fileExt);
            $newFilename = sprintf('%s_%s_%s.%s', $realFilename, time(), rand(10000, 99999), $fileExt);
            $fileHash = hash_file('md5', $file->getPathname());
            // 不允许重复上传相同的文件
            //$fileExist = \App\File::where('hash', $fileHash)->count();
            $fileExist = false;
            if ($fileExist) {
                $returnData['msg'] = '该文件已存在 请选择其他文件上传';
                $returnData['errno'] = 123;
            } else {
                // 移动文件
                $file->move($path, $newFilename);
                $returnData['errno'] = 0;
                $fileUri = sprintf('/uploads/%s/%s/', $dirName, $yearMonth) . $newFilename;
                $returnData['data'] = [
                    'path' => $path . $newFilename,
                    'uri' => $fileUri,
                    'filename' => $newFilename,
                    'original_filename' => $originalFilename,
                    'file_hash' => $fileHash,
                ];
            }
        }
        return $returnData;
    }

    public function imageUpload($file, $dirName, $isWangEditor = false) {
        $returnData = [
            'errno' => -1,
            'msg' => '',
            'data' => ''
        ];

        $yearMonth = sprintf('%s%s', \Carbon\Carbon::now()->year, \Carbon\Carbon::now()->month);
        $path = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth);

        $this->autoMakeDir($path);

        $error = $file->getError();
        if ($error != 0) {
            $returnData['msg'] = $file->getErrorMessage();
        } else {
            $fileExt = $file->getClientOriginalExtension();
            // 新文件名
            $newFilename = sprintf('%s_%s.%s', time(), rand(10000, 99999), $fileExt);
            $filePath = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth) . $newFilename;
            $fileUrl = sprintf('%s/uploads/%s/%s/', DATA_URL, $dirName, $yearMonth) . $newFilename;
            $file->move($path, $newFilename);
            // 压缩图片
            list($pictureWidth, $pictureHeight) = getimagesize($filePath);
            $maxWidth = config('image.max_width');
            if ($pictureWidth > $maxWidth) {
                createthumb($filePath, $filePath, $maxWidth, $pictureWidth / 500 * $pictureHeight);
            }

            $returnData['errno'] = 0;
            if ($isWangEditor) {
                $returnData['data'] = [$fileUrl];
            } else {
                $returnData['data'] = $newFilename;
            }

        }
        
        return $returnData;
    }

    function autoMakeDir($filePath)
    {
        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }
    }

}
