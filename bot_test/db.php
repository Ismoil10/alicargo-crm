<?php
/*db class start*/
class db {
	
static function conn (){
$conn = new mysqli('localhost','root','evosoft050','alicargo');
$conn->set_charset('utf8mb4');
if ($conn->connect_error) {die('Connection faield:'.$conn->connect_error);}
else{$rs = $conn;}
return $rs;}

static function query($sql) {
$conn = db::conn();
if ($conn->query($sql)===TRUE) {$rs['stat']='success';$rs['ID']=$conn->insert_id;}else{$rs=$conn->error;}
return $rs;}

static function arr($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs[] = $row;}} 
if ($q->num_rows==0) {$rs='empty';}
return $rs;}

static function arr_s($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs = $row;}}
if ($q->num_rows==0) {$rs='empty';}
return $rs;}

static function arr_by_id($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs[$row['ID']] = $row;}}
if ($q->num_rows==0) {$rs='empty';}
return $rs;}	
}
/*db class end*/
?>