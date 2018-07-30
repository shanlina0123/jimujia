<?php
use Illuminate\Support\Facades\Storage;
class Upload
{
    public  $filepath = 'uploads';
    public  $fileFrom = "temp/";
    public static $disk = 'upload';
    public function __construct()
    {
       $this->filepath = config('configure.uploads');
       $this->fileFrom = config('configure.temp');
    }
    /**
     * @param $uuid
     * @param $name 文件临时目录下的名字
     * @param $type 上传类型
     * @param $alias 新名称
     * @return bool
     */
    public function uploadProductImage( $uuid, $name, $type, $alias=null )
    {

        try{
            switch ( $type )
            {
                case "site_info": //工地封面图片
                    $dbPath='site/'.$uuid.'/info';
                    $filePath  = $this->filepath.'/'.$dbPath;
                    break;
                case 'site_code'://工地推广图片
                    $dbPath='site/'.$uuid.'/code';
                    $filePath  = $this->filepath.'/'.$dbPath;
                    break;
                case "site_dynamic": //工地动态图片 $uuid 动态的id
                    $dbPath='site/'.$uuid.'/dynamic';
                    $filePath = $this->filepath.'/'.$dbPath;
                    break;
                case "user"://用户
                    $dbPath='user/'.$uuid;
                    $filePath  = $this->filepath.'/'.$dbPath;
                    break;
                case "lucky"://抽奖活动
                    $dbPath='lucky/'.$uuid;
                    $filePath  = $this->filepath.'/'.$dbPath;
                    break;
                case "activity"://宣传活动
                    $dbPath='activity/'.$uuid;
                    $filePath  = $this->filepath.'/'.$dbPath;
                    break;
                default:
                    return false;
            }
            $fileFrom = public_path().$this->fileFrom.$name;
            if( file_exists($fileFrom) )
            {
                $res = $this->uploads( $filePath, $fileFrom, $name, $alias );
                if( $res )
                {
                    return $dbPath;
                }else
                {
                    return false;
                }
            }else
                return false;

        } catch (Exception $e)
        {
            return false;
        }

    }

    /**
     * @param $filepath
     * @param $iPid
     * @param $fileFrom
     * @param $fileName
     * @return bool
     * 私有方法
     */
    private function uploads( $filePath, $fileFrom, $name, $alias  )
    {
        $newName = $alias?$alias:$name;
        if( $filePath && $fileFrom && $name )
        {
            $Directory = $filePath;
            $obj = Storage::disk(self::$disk)->makeDirectory( $Directory );
            if( $obj === true )
            {
                $upload = Storage::disk(self::$disk)->put($Directory.'/'.$newName,file_get_contents($fileFrom));
                if( $upload === true && file_exists($fileFrom) == true )
                {
                    @unlink($fileFrom);
                    return true;
                }else
                {
                    return false;
                }
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }

    }

    /**
     *  删除图片
     *
     */
    public function delImg( $path )
    {
        $path = $this->filepath.'/'.$path;
        if( Storage::disk(self::$disk)->exists($path) )
        {
            if (is_writable($path)) {
                $images = Storage::disk(self::$disk)->delete( $path );
                if ( $images )
                {
                    return true;
                }
                return false;
            } else {
                return true;
            }
        }else
            return false;
    }


    /**
     * @param $dir
     * @param $id
     * @return bool
     * 删除文件夹以及下面的文件
     */
    public function delDir( $dir, $id )
    {
        try
        {
            if( $dir && $id )
            {
                $Path = $this->filepath . '/' . $dir . '/' . $id;
                $res = Storage::disk(self::$disk)->deleteDirectory($Path);
                if ( $res )
                {
                    return true;
                }
                return false;
            }else
                return false;

        }catch (Exception $e)
        {
            return false;
        }
    }
}
