<?php

class Api
{
    // Get Subscriber
    function getSubscriber(  $path_arr )
    {
        global $mysqli;
        $userid = isset($path_arr[2])?$path_arr[2]:false;
        if((preg_match('/^[0-9]+$/', $userid)==false) && $userid )
        {
            $stats = [ 'status' => 0 ,'msg' => 'Invalid Id' ];
            echo json_encode( $stats );
            die();
        } 

        if( $userid ) 
        {
            $id = (int)$mysqli->real_escape_string( $userid );
            $row = $mysqli->query("SELECT * FROM   `subscribers` WHERE `id`=$id");

        }else{
            $row = $mysqli->query("SELECT * FROM  `subscribers`");
        }
        $r   = [];
        while( $d = $row->fetch_object() )
        {
            $r[] = $d;
        }
        if( count( $r ) > 0 )
        {
            http_response_code(200);
            echo json_encode( array( "status"=>1,"data"=>$r ) );
        }else{
            http_response_code(200);
            echo json_encode( array( "status"=>0,"msg"=>'No Record Found' ) );
        }
    }
    // Add Subscriber
    function addSubscriber( )
    {

        $stats=['status'=>0,'msg'=>''];
        global $mysqli;
        $required_parameters= ['name', 'email'];
                
        $missing_parameters= array_filter( $required_parameters, function($key){
            return !isset($_POST[$key] );
        });
        $data = $_POST;
        if(count($missing_parameters)===0)
        {
            $name = $mysqli->real_escape_string( $data['name'] );
            $email = $mysqli->real_escape_string( $data['email'] );
            if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                http_response_code(200);
                $stats['msg']='Invalid Email address';

            }else{
                if( self::details(false, $email) == false )
                {
                    $mysqli->query("INSERT INTO `subscribers`(`name`, `email`) VALUES ('$name','$email')");
                    if($mysqli->affected_rows>0)
                    {
                        $data = self::details( $mysqli->insert_id );
                        http_response_code(200);
                        $stats["status"]=1;
                        $stats['msg']='Subscriber added successfully';
                        $stats['data'] = $data;
                    }else{
                        http_response_code(200);
                        $stats["status"]=0;
                        $stats['msg']='Subscriber not added successfully';
                    }

                }else{
                    http_response_code(200);
                    $stats["status"]=0;
                    $stats['msg']='Subscriber already registered';
                }
            }
        }
        else{
            $missing_parameters= implode(", ", $missing_parameters);
            $stats['msg']= "Parameter missing $missing_parameters";
        }
        echo json_encode($stats);
        die();
    }
    // Get Details Subscriber
    function details( $id=false,$email=false )
    {
        global $mysqli;
        if(!$id || !$email) return false;
        $id = $mysqli->real_escape_string($id);
        $email = $mysqli->real_escape_string($email);
        if(  $id && $email )
        {
            $row  =  $mysqli->query("SELECT *  FROM `subscribers` WHERE `email`='$email' && `id` != $id");
        }
        else if( $id )
        {
            $row = $mysqli->query("SELECT *  FROM `subscribers` WHERE `id`=$id");
        }
        else if( $email ){
            $row  =  $mysqli->query("SELECT *  FROM `subscribers` WHERE `email`='$email'");
        }

        if( $row->num_rows > 0 )
        {
            $data = $row->fetch_assoc();
            return $data;
        }
        return false;

    }
    // Update Subscriber
    function updateSubscriber($path_arr)
    {
        $stats=['status'=>0,'msg'=>''];
        global $mysqli;
        $data = $_POST;

        $userid = isset($path_arr[2])?$path_arr[2]:false;
        if((preg_match('/^[0-9]+$/', $userid)==false) && $userid )
        {
            $stats = [ 'status' => 0 ,'msg' => 'Invalid Id' ];
            echo json_encode( $stats );
            die();
        } 

        $id = (int)$mysqli->real_escape_string( $userid );
        $data = self::details( $id); 
        if( $data && ( isset($_POST['name']) ||  isset($_POST['email'] ) ) )
        {
            $sql='';
            if(isset($_POST['name']) &&  isset($_POST['email']) )
            {
                $name = $mysqli->real_escape_string( $_POST['name'] );
                $email = $mysqli->real_escape_string( $_POST['email'] );

                if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
                {
                    http_response_code(200);
                    $stats['msg']='Invalid Email address';
                    echo json_encode($stats);
                    die();
    
                }else{
                    if( self::details($id, $email) === false)
                    {
                        $sql .= "UPDATE `subscribers` SET `name`='$name',`email`='$email' WHERE `id`=$id";
                    }else{
                        http_response_code(200);
                        $stats['msg']='Email already availabel, Please use different email';
                        echo json_encode($stats);
                        die();
                    }
                }
                
    
            }else if( isset($_POST['email']) ){
                $email = $mysqli->real_escape_string( $_POST['email'] );
                if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
                {
                    http_response_code(200);
                    $stats['msg']='Invalid Email address';
                    echo json_encode($stats);
                    die();
    
                }else{
                    if( self::details($id, $email) === false)
                    {
                        $sql .= "UPDATE `subscribers` SET `email`='$email' WHERE `id`=$id";
                    }else{
                        http_response_code(200);
                        $stats['msg']='Email already availabel, Please use different email';
                        echo json_encode($stats);
                        die();
                    }
                }
                
            }
            else if( isset($_POST['name']) ){
                $name = $mysqli->real_escape_string( $_POST['name'] );
                $sql .= "UPDATE `subscribers` SET `name`='$name' WHERE `id`=$id";
            }
            // echo $sql;
            $check = $mysqli->query( $sql )?1:0;
            // print_r($mysqli);
            if($check)
            {
                $stats=['status'=>1,'msg'=>'Subscriber updated Successfully'];

            }else{
                $stats=['status'=>0,'msg'=>'Subscriber not updated'];
            }
        }else{
            $stats=['status'=>0,'msg'=>'No Record Found'];
        }
        echo json_encode($stats);
        die();
    }
     // Delete Subscriber
    function deleteSubscriber( $path_arr )
    {
        $stats=['status'=>0,'msg'=>''];
        global $mysqli;

        $userid = isset($path_arr[2])?$path_arr[2]:false;
        if((preg_match('/^[0-9]+$/', $userid)==false) && $userid )
        {
            $stats = [ 'status' => 0 ,'msg' => 'Invalid Id' ];
            echo json_encode( $stats );
            die();
        } 
        
        $id = (int)$mysqli->real_escape_string( $userid );
        $data = self::details( $id);
        if( $data )
        {
            $mysqli->query( "DELETE FROM `subscribers` WHERE `id`=$id" );
            if($mysqli->affected_rows>0)
            {
                $stats=['status'=>1,'msg'=>'Subscriber deleted Successfully'];

            }else{
                $stats=['status'=>0,'msg'=>'Error! Subscriber not deleted'];
            }
        }else{
            $stats=['status'=>0,'msg'=>'No Record Found'];
        }
        echo json_encode($stats);
        die();
    }
     // Authenticate User
    function authenticate()
    {
        global $mysqli;
        
        if( isset($_SERVER['HTTP_X_API_KEY'] ) )
        {
            $api_token = $mysqli->real_escape_string( $_SERVER['HTTP_X_API_KEY'] );
            $row = $mysqli->query("SELECT `id` FROM `api_tokens` WHERE `token`='$api_token'");
            if( $row->num_rows > 0 )
            {
                return  true;

            }else{
                return false;
            }
        }else{
            return false;
        }

    }

}