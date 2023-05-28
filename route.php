<?php
class Route
{
    
    function getProtocol()
    {
        //get current protocol	
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            return "https";
        }
        return "http";
    }
    function doRedirectToHTTPS($path)
    {
        global $force_https;
        if($force_https)
        {
            $proto=self::getProtocol();
            if($proto=='http')
            {
                global $dont_force_https_list; // for not https force
                $list=$dont_force_https_list;
                $path=trim($path,'/');
                $path='/'.$path.'/';
                foreach($list as $val)
                {
                    if(strpos($path, $val)===0)
                    {
                        return;
                    }
                }
                header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                return;
            }
        }
    }
    function doRoute()
    {
        global $is_gcp;
        global $base_dir;
        global $default_controller;
        $temp_gcp_path=parse_url($_SERVER['REQUEST_URI']);


        if(isset($temp_gcp_path['path']) && (trim($temp_gcp_path['path'])!='/'))
        {
            $_GET['page']=$temp_gcp_path['path'];
        }

        self::doRedirectToHTTPS(((isset($_GET['page']))? $_GET['page']:''));
        if(isset($_GET['page']))
        {
            $parse=parse_url($_GET['page']);
            unset($_GET['page']);
          
            if(isset($parse['path']))
            {
                $trimmed_path=ltrim(strstr($parse['path'],"/api/"),'/');
                $path_arr=explode('/', $trimmed_path);
                if( (count($path_arr)>3) || in_array("api",$path_arr)==false || in_array("user",$path_arr)==false  ) 
                {
                    self::show404();
                    die();
                }

                if(count($path_arr)>0 && strlen($trimmed_path)>0)
                {

                    $controller=$path_arr[1];
                    $controller=$base_dir.'/api.php';
                  
                    if(is_file($controller))
                    {
                        require_once($controller);
                        $ob = new Api();
                        $authenticate =  $ob->authenticate();
                        
                       
                        if($authenticate)
                        {
                                if( ucwords( $_SERVER['REQUEST_METHOD'] ) == "GET" )
                                {
                                    $ob->getSubscriber( $path_arr );
                                }
                                elseif( ucwords( $_SERVER['REQUEST_METHOD'] ) == "POST" )
                                {
                                    if( isset( $_POST['_method'] ) && $_POST['_method' ]== "PUT" )
                                    {
                                        $ob->updateSubscriber(  $path_arr );

                                    }elseif( isset( $_POST['_method'] ) && $_POST['_method'] == "DELETE" )
                                    {
                                        $ob->deleteSubscriber( $path_arr );
                                        
                                    }else{
                                        if( isset( $path_arr[2] ) && !empty( $path_arr[2] )  )
                                        {
                                            self::show404();
                                        }else{
                                            $ob->addSubscriber();
                                        }
                                    }   
                                }

                        }else{
                            self::show404();
                        }
                    }
                    else
                    {
                        self::show404();
                    }
                }
            }

        }
        else
        {
            $this->show404();
        }
    }
    function show404()
    {
        http_response_code(404);
        echo "404";
    }
    function assignProduct(){
        if(isset($_GET['product']))
        {
            global $products;
            $product= strtolower($_GET['product']);
            if(array_search($product, $products) !==false){
                $_SESSION['session_product']= $product;
            }
        }
    }
}

?>