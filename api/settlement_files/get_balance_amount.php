<?php
require '../../ajaxconfig.php';

$auction_id = $_POST['auction_id'];
$cus_id     = $_POST['cus_id'];
$share_id   = $_POST['share_id'];

$stmt = $pdo->query("
    SELECT 
        si.balance_amount,
        si.settle_amount,
        gs.share_percent
    FROM settlement_info si

    LEFT JOIN customer_creation cc
        ON si.cus_name = cc.id

    LEFT JOIN group_share gs
        ON gs.cus_id = cc.id

    WHERE si.auction_id = $auction_id
      AND cc.cus_id = '$cus_id'
      AND gs.id =  $share_id

    ORDER BY si.id DESC
    LIMIT 1
");

 echo " SELECT 
        si.balance_amount,
        si.settle_amount,
        gs.share_percent
    FROM settlement_info si

    LEFT JOIN customer_creation cc
        ON si.cus_name = cc.id

    LEFT JOIN group_share gs
        ON gs.cus_id = cc.id

    WHERE si.auction_id = $auction_id
      AND cc.id =  '$cus_id'
      AND gs.id =  $share_id

    ORDER BY si.id DESC
    LIMIT 1";

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {

    $balance_amount = (float) $result['balance_amount'];
    echo $balance_amount;
 
    $settle_amount  = (float) $result['settle_amount'];
       echo $settle_amount;
    $share_percent  = (float) $result['share_percent'];
 if ($balance_amount == 0){
$result = $stmt->fetch(PDO::FETCH_ASSOC);
 }else if($balance_amount != 0){
     $result = [
        'balance_amount' => null,
        'settle_amount'  => null
    ];
}
 

} else {

    $result = [
        'balance_amount' => null,
        'settle_amount'  => null
    ];
}

$pdo = null;

echo json_encode($result);
?>