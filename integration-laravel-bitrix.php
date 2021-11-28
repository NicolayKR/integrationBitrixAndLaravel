<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitrixController;
use App\Models\BitrixData;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Storage;
use App\Models\Customers;
use App\Models\Checks;

Route::get('/test', function(){
    function p($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    $mesilov_obj = new \Bitrix24\Bitrix24();
    // Инициализация класса авторизации
    $b24auth = new \Bitrix24Authorization\Bitrix24Authorization();

    // Заменить на свои данные авторизации
    $b24auth->setApplicationId('local.616049fc98dd93.05282843'); // Getting when registring Bitrix24 application
    $b24auth->setApplicationSecret('1bzjoF7OLks02gMP64qdkI9Jl5L1IlrAYCl9vcqEC4C3j7L4Gw'); // Getting when registring Bitrix24 application
    $b24auth->setApplicationScope('crm,user'); // write Bitrix24 instances which you want to use via API. They need to be choosen in application at Bitrix24
    $b24auth->setBitrix24Domain('avtotcifra.bitrix24.ru'); // Address of your Bitrix24 portal
    $b24auth->setBitrix24Login('test@dreamte.ru'); // login of your real user, he need to be an Admibistrator of instance you want to use
    $b24auth->setBitrix24Password('test'); // password of your real user, he need to be an Admibistrator of instance you want to use
    $file = '/api/token.txt';
    $filePath = 'api/token.txt';
    date_default_timezone_set("Europe/Moscow");
    $ASSIGNED_BY_ID = 1111;
    if(Storage::exists($file) && time()-filemtime(Storage::path($filePath)) < 3000){
        $mesilov_auth_obj = unserialize(Storage::get($file));
    } else {
        // Инициализация
        $mesilov_auth_obj = $b24auth->initialize($mesilov_obj);
        Storage::put($file, serialize($mesilov_auth_obj));
    }
//    $mesilov_auth_obj->addBatchCall("crm.deal.fields",[],
//            function ($result){
//        p($result);
//    });
//    $mesilov_auth_obj->processBatchCalls();
//    exit();
    $STORE = array(
        //1
        '4adaeb17-5814-11e3-88e8-08606ed88be2'=>1603,
        'ca530c8c-da49-11e2-bd47-08606ed88be2'=>1605,
        'ca530c89-da49-11e2-bd47-08606ed88be2'=>1607,
        '4adaeb18-5814-11e3-88e8-08606ed88be2'=>1609,
        'feb7e00e-7418-11e7-ab33-00155d641502'=>1611,
        //5
        '78a54512-87c4-11e7-8686-00155d641502'=>1613,
        'dd735eb6-ff70-11e8-8e8d-00155dc87104'=>1615,
        'b97433d5-6700-11e3-88e8-08606ed88be2'=>1617,
        '59de559b-88c7-11e7-8686-00155d641502'=>1619,
        'b21760e5-ddeb-11e8-bb49-00155d641502'=>1621,
        //10
        '7ea2300c-7b74-11e8-b378-00155d641502'=>1623,
        'e20f632a-50e8-11e3-88e7-08606ed88be2'=>1625,
        'b7653a74-51a4-11e3-88e7-08606ed88be2'=>1627,
        'd84f08df-5c03-11e7-a2c3-00155dc6dd07'=>1629,
        '87d4e693-bf93-11eb-874f-00155dc82609'=>1631,
        //15
        'b7653a73-51a4-11e3-88e7-08606ed88be2'=>1633,
        '4adaeb0b-5814-11e3-88e8-08606ed88be2'=>1635,
        '4adaeb06-5814-11e3-88e8-08606ed88be2'=>1637,
        '4adaeb04-5814-11e3-88e8-08606ed88be2'=>1639,
        '4adaeb02-5814-11e3-88e8-08606ed88be2'=>1641,
        //20
        '674d132c-889c-11e7-8686-00155d641502'=>1643,
        '4adaeb0c-5814-11e3-88e8-08606ed88be2'=>1645,
        '4adaeb0e-5814-11e3-88e8-08606ed88be2'=>1647,
        '4a663f52-1910-11e3-bdbb-08606ed88be2'=>1649,
        '9276d459-f119-11e2-8683-08606ed88be2'=>1651,
        //25
        '0ddf9c30-7283-11eb-a86c-00155dc8710f'=>1653,
        'f60262da-6854-11e7-a7c2-00155d641502'=>1655,
        '084fbbdd-58b6-11e3-88e8-08606ed88be2'=>1657,
        '4cc30f76-0526-11e9-8e8d-00155dc87104'=>1659,
        '084fbbdb-58b6-11e3-88e8-08606ed88be2'=>1661,
        //30
        '2b8d54e6-57c6-11ea-8bb3-00155dc8710f'=>1663,
        '084fbbe1-58b6-11e3-88e8-08606ed88be2'=>1665,
        '2b8d54e4-57c6-11ea-8bb3-00155dc8710f'=>1667,
        '2b8d54e5-57c6-11ea-8bb3-00155dc8710f'=>1669,
        '72752987-7b3a-11e7-8499-2c4d54538f83'=>1671,
        //35
        'bb3f0461-b92e-11eb-874f-00155dc82609'=>1683,
        '2341949f-982d-11eb-85b3-00155dc8710f'=>1685,
        '234194a1-982d-11eb-85b3-00155dc8710f'=>1687,
        '234194a0-982d-11eb-85b3-00155dc8710f'=>1689,
        '234194a2-982d-11eb-85b3-00155dc8710f'=>1691,
    );
    $files = Storage::allFiles('1c\sales');
    foreach ($files as $file){
        $curr_file = file_get_contents(Storage::path($file));
        $newPath = str_replace('sales', 'old_sales',stristr(Storage::url($file),'/1c'));
//        Storage::delete(Storage::path($file));
//        Storage::put($newPath, $curr_file);
        $content = iconv("utf-8", "windows-1251//IGNORE", $curr_file);
        $content = iconv("windows-1251", "utf-8", $content);
        $work_file = json_decode($content, true);
        $check_array = [];
        $start = time();
        foreach($work_file as $item){
            $xml_id = $item["id"];
            $check_array[$xml_id]['DATE'] = date('d.m.Y H:i:s',strtotime($item['date']));
            $check_array[$xml_id]['NUMBER'] = $item['check'];
            $check_array[$xml_id]['CUSTOMER'] = $item['customer'];
            $check_array[$xml_id]['STORE_ID'] = $STORE[$item['store']['id']];
            //Проверка, что чек с товарами
            if(!empty($item['products'])) {
                foreach($item['products'] as $current_product){
                    $mesilov_auth_obj->addBatchCall('crm.product.list', [
                        'order'=>[],
                        'filter' => [
                            'XML_ID' => $current_product['product']['id'],
                            'ACTIVE' => 'Y'
                        ],
                        'select' => [
                            '*', 'PROPERTY_*'
                        ]
                    ],function ($result) use (&$check_array, $current_product, $xml_id) {
                        if(!empty($result['result'])){
                            $sale = abs($current_product['sum'] - $current_product['price']*$current_product['quantity'])/$current_product['quantity'];
                            $check_array[$xml_id]['products'][] = [
                                'ID' => $result['result'][0]['ID'],
                                'QUANTITY' => $current_product['quantity'],
                                'PRICE' => $current_product['price'],
                                'DISCOUNT_SUM' =>$sale,
                            ];
                        }else{
                            $check_array[$xml_id]['products'] = [];
                        }
                    });
                }
            }
            else{
                $check_array[$xml_id]['products'] = [];
            }
        }
        $mesilov_auth_obj->processBatchCalls();
//        Теперь пройдемся по всем товарам которые собрали по файлу с чеками.
        foreach($check_array as $key=>$check){
            if(!empty($check['CUSTOMER'])){
                $phone = '';
                $email = '';
                $customer_id = '';
                if(strlen($check['CUSTOMER']['id'])!=0){
                    $customer_id = $check['CUSTOMER']['id'];
                }
                if(strlen($check['CUSTOMER']['name'])!=0){
                    $name = $check['CUSTOMER']['name'];
                }
                if(strlen($check['CUSTOMER']['phone'])!=0){
                    $phone = $check['CUSTOMER']['phone'];
                }
                if(strlen($check['CUSTOMER']['email'])!=0){
                    $email = $check['CUSTOMER']['email'];
                }
                $newCheck = Checks::create(array(
                    'xml_id' => $key,
                    'customer_id' => $customer_id,
                    'customer_name' => $name,
                    'customer_phone' => $phone,
                    'customer_email' => $email,
                    'data' => $check['products'],
                    'store_id' => $check['STORE_ID'],
                    'date_check' =>$check['DATE'],
                    'check_number' => $check['NUMBER'],
                ));
                $newCheck->save();
            }
            else{
                $newCheck = Checks::create(array(
                    'xml_id' => $key,
                    'name' => NULL,
                    'phone' => NULL,
                    'email' => NULL,
                    'data' => $check['products'],
                    'store_id' => $check['STORE_ID'],
                    'date_check' =>$check['DATE'],
                    'check_number' => $check['NUMBER'],
                ));
                $newCheck->save();
            }
        }
        $collection = Checks::select('*')->where('flag', 0)->get()->toArray();
        foreach($collection as $key=>$item){
            if(!empty($item['customer_phone'])){
                $index = $key;
                if(!empty($item['customer_name'])){
                    $name = $item['customer_name'];
                }
                else{
                    $name = $item['customer_phone']." (без имени)";
                }
                if(!empty($item['customer_email'])){
                    $email = $item['customer_email'];
                }
                else{
                    $email = '';
                }
                $phone = preg_replace('#[^0-9\+]#is', '', $item['customer_phone']);
                $mesilov_auth_obj->addBatchCall('crm.contact.list', [
                    'filter' => [
                        'PHONE' => $phone
                    ],
                    'select' => [
                        'ID'
                    ]
                ],function ($result) use ($name,$phone,$email,$ASSIGNED_BY_ID, &$mesilov_auth_obj, $index, &$collection) {
                    $current_index = $index;
                    if(!empty($result['result'])){
                        $collection[$current_index]['contact_id'] = $result['result'][0]['ID'];
                    }else{
                        $contact = [
                            'NAME' => $name,
                            'ASSIGNED_BY_ID' => $ASSIGNED_BY_ID,
                        ];
                        $contact['PHONE'] = [
                            [
                                'VALUE' => $phone,
                                'VALUE_TYPE' => 'WORK'
                            ]
                        ];
                        if(strlen($email)!=0)
                        {
                            $contact['EMAIL'] = [
                                [
                                    'VALUE' => $email,
                                    'VALUE_TYPE' => 'WORK'
                                ]
                            ];
                        }
                        $mesilov_auth_obj->addBatchCall('crm.contact.add', [
                            'fields' => $contact
                        ],function ($result) use ($current_index, &$contact_collection, &$collection){
                            if(!empty($result['result'])){
                                $collection[$current_index]['contact_id'] = $result['result'];
                            }
                        });
                    }
                });
            }
        }
        $mesilov_auth_obj->processBatchCalls();
//        Проверяем наличие сделки, если ее еще нет, то создаем.
        foreach ($collection as $key=>$item) {
            $index = $key;
            $current_item = $item;
            $mesilov_auth_obj->addBatchCall('crm.deal.list', [
                'order' =>   [],
                'filter' => [
                    'UF_CRM_1634906887' => $item['xml_id'],
                ],
                'select'=> ["ID"]
            ], function ($result) use ($index, &$collection, $current_item, $start, $ASSIGNED_BY_ID, &$mesilov_auth_obj){
                $current_index = $index;
                $deal[] = [];
                if(!empty($result['result'])){
                    $collection[$index]['deal_id'] = $result['result'][0]['ID'];
                }else{
                    $deal = [
                        'TITLE' => 'Чек №'.$current_item['check_number'],
//                        'UF_CRM_1593077296037' => date('d.m.Y H:i:s', $start),
                        'CLOSEDATE' => $current_item['date_check'],
                        'BEGINDATE' => $current_item['date_check'],
                        'STAGE_ID' => 'C7:NEW',
                        'CATEGORY_ID' => 7,
                        'ASSIGNED_BY_ID' => $ASSIGNED_BY_ID,
                        'UF_CRM_1634906887' => $current_item['xml_id'],
                        'UF_CRM_1623335854' => $current_item['store_id'],
                        'UF_CRM_1635427086' => 1,
                    ];
                    if (!empty($current_item['contact_id'])) {
                        $deal['CONTACT_ID'] = $current_item['contact_id'];
                    }
                    $mesilov_auth_obj->addBatchCall('crm.deal.add', [
                        'fields' => $deal
                    ], function ($result) use ($current_index, &$collection){
                        if(!empty($result['result'])){
                            $collection[$current_index]['deal_id'] = $result['result'];
                        }
                    });
                }
            });
        }
        $mesilov_auth_obj->processBatchCalls();
//        Обновляем или создаем товары у уже существующей сделки.
        foreach ($collection as $item) {
            $deal_id = $item['deal_id'];
            $index = $item['xml_id'];
            $dealProducts = [];
            foreach ($item['data'] as $curr_item){
                $dealProducts[] = [
                    'PRODUCT_ID' => $curr_item['ID'],
                    'PRICE' => $curr_item['PRICE'] - $curr_item['DISCOUNT_SUM'],
                    'QUANTITY' => $curr_item['QUANTITY'],
                    'DISCOUNT_SUM' => $curr_item['DISCOUNT_SUM'],
                    'DISCOUNT_TYPE_ID' => 1,
                ];
            }
            $mesilov_auth_obj->addBatchCall('crm.deal.productrows.set', [
                'id' => $deal_id,
                'rows' => $dealProducts
            ], function ($result) use($index){
                if(!empty($result['result'])){
                    Checks::where('xml_id', $index)->update(array(
                        'flag'=>1,
                    ));
                }
            });
        }
        $mesilov_auth_obj->processBatchCalls();
    }
});
