<?php 

require_once  '../../__/bootstrap.php';
use App\Utility\AccountUtility;

    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');


if(isset($_POST['id']) && $_POST['id'] && isset($_POST['status']) 
&& $_POST['status'] && isset($_POST['user_cd']) && $_POST['user_cd']){

    $app_id_reset = $_POST['id'];
    $status = $_POST['id'];
    $user_cd = $_POST['user_cd'];

    $sql_check_app_by_user = "SELECT * from apps where created_by = $user_cd and id = $app_id_reset ";
    $check = '';
    foreach($pdo->query($sql_check_app_by_user) as $v){
        $check = '1';
    }
    if($check){
        $sql_update = "UPDATE apps set status = 3 where id = $app_id_reset";
        $pdo->exec($sql_update);
        
        echo json_encode('success');
    }else{
        echo json_encode('fail');
    }

}

?>