<?php namespace App\Libs\CaptchaImages;

/**
* 
*/
class CaptchaImage
{
	//chiều rộng hình ảnh trả về
    var $img_width = 120;
    //chiều cao hình ảnh captcha
    var $img_height = 30; 
    // nơi chứa file font chữ của captcha 
    var $font_path = 'public/captcha/fonts';
    var $fonts = array();
    // size chữ khi in lên trên hình captcha
    var $font_size = 15;
     
    var $char_set = "ABCDEFGHJKLMNPQRSTUVWXYZ2345689";
    //chiều dài của mã captcha
    var $char_length = 5;
    var $char_color = "#880000,#008800,#000088,#888800,#880088,#008888,#000000";
    var $char_colors = array();
     
    var $line_count = 10;
    var $line_color = "#DD6666,#66DD66,#6666DD,#DDDD66,#DD66DD,#66DDDD,#666666";
    var $line_colors = array();
    //mã màu của background, default là màu trăng
    var $bg_color = '#FFFFFF';
    //
	//
	// Chuyển color
    protected function gdColor($html_color) {
        return preg_match('/^#?([\dA-F]{6})$/i', $html_color, $rgb) ? hexdec($rgb[1]) : false;
    }
 
    // Lấy danh sách file theo phần mở rộng (ext)collectt_files
    protected function collectFiles($dir, $ext) 
    {
        if (false !== ($dir = opendir($dir))) 
        {
            $files = array();
 
            while (false !== ($file = readdir($dir)))
                if (preg_match("/\\.$ext\$/i", $file))
                    $files[] = $file;
 
            return $files;
 
        }
                return false;
    }
	// Khởi tạo cấu hình, hàm này sẽ trả về mã code và hiển thị hình
    public function getShowCaptchaImage( $override = array() ) 
        {
        // Override lại thong số config
        if( is_array( $override) )
        {
            foreach ( $override as  $key => $value) {
                if( isset( $this->$key ))
                    $this->$key = $value;
            }           
        }
                 
        // Tạo danh sách colors thành một mảng
        $this->line_colors = preg_split("/,\s*?/", $this->line_color );
        $this->char_colors = preg_split("/,\s*?/", $this->char_color );
         
        // Lấy danh sách fonts trong folder được định nghĩa trong biến font_path
        $this->fonts = $this->collectFiles( $this->font_path, "ttf");
                 
        // Khởi tạo hình ảnh
        $img = imagecreatetruecolor( $this->img_width, $this->img_height);
        imagefilledrectangle($img, 0, 0, $this->img_width - 1, $this->img_height - 1, $this->gdColor( $this->bg_color ));
         
                 
        // Vẽ hình lung tung cho đời nó tươi mát
        for ($i = 0; $i < $this->line_count; $i++){
            imageline($img,
                rand(0, $this->img_width  - 1),
                rand(0, $this->img_height - 1),
                rand(0, $this->img_width  - 1),
                rand(0, $this->img_height - 1),
                $this->gdColor($this->line_colors[rand(0, count($this->line_colors) - 1)])
            );
                }
             
        // Vẽ code lên hình
        $code = "";
        $y = ($this->img_height / 2) + ( $this->font_size / 2);
         
        for ($i = 0; $i < $this->char_length ; $i++) 
                {
            $color = $this->gdColor( $this->char_colors[rand(0, count($this->char_colors) - 1)] );
            $angle = rand(-30, 30);
            $char = substr( $this->char_set, rand(0, strlen($this->char_set) - 1), 1);
             
            $sel_font = $this->fonts[rand(0, count($this->fonts) - 1)];   
                         
            $font = $this->font_path . "/" . $sel_font;
             
            $x = (intval(( $this->img_width / $this->char_length) * $i) + ( $this->font_size / 2));
            $code .= $char;
             
            imagettftext($img, $this->font_size, $angle, $x, $y, $color, $font, $char);
        }
        /* Avoid Caching */
        header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        // Hiển thị ảnh
        header('Content-type: image/jpeg');
                  
        imagejpeg( $img);
        imagedestroy($img);
                 
        return $code;
    }   
         
        

}

 ?>