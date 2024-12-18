<?

if (empty($StudentR->StIdNumber)) {
    $User_Name = $StName;
} else {
    $User_Name = $StudentR->StIdNumber;
}
$where_student = "";

if ($this->ApiDbname == 'SchoolAccTabuk') {
    $where_student = " User_Name         = '" . $User_Name . "' ,
                  Password          = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name) . "',";
}
$this->db->query("update  contact SET  
$Name             = '" . $StName . "',
$Name_en          = '" . $StNameEn . "',
$where_student
Gender            = '" . $StudentR->StGenderId . "' ,
Number_ID         = '" . $StudentR->StIdNumber . "' ,
Phone             = '" . $StudentR->FaMobile1 . "' ,
Nationality_ID    = '" . $StudentR->NationalityId . "' ,
Longtude          = '" . $StudentR->StLongtude . "' ,
Latitude          = '" . $StudentR->StLatitude . "' ,
NameAtPassport    = '" . $StudentR->NameAtPassport . "' ,
NameEnAtPassport  = '" . $StudentR->NameEnAtPassport . "' ,
PassportNumber    = '" . $StudentR->PassportNumber . "' ,
PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
SchoolID          = '" . $add_school_id_to . "' ,
Isactive          = '" . $StudentR->IsExists . "',
ID_ACC            = '" . $StudentR->FaId . "' ,
GR_Number         = '" . $StudentR->Notes . "' ,
RealEstateComID   = '" . $StudentR->StDetailsId . "',
Birth_Place       = '" . $PlaceOfBirth . "' ,
motherName        = '" . $StudentR->MotherNAme . "' ,
motherMobile      = '" . $StudentR->MotherMobile . "' 
where studentBasicID='" . $StudentR->StBasicId . "' and Type='S' ");
$UP_Data++;

$query2 =  $this->db->query("select  student.Father_ID,fa.IDHr FROM student
                         inner join contact on student.Contact_ID=contact.ID 
                         inner join contact as fa on student.Father_ID=fa.ID
                         where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
if ($query2['IDHr']) {
    $this->db->query("update  contact SET  
ID_ACC           = '" . $StudentR->FaId . "' ,
Nationality_ID   = '" . $StudentR->NationalityId . "' ,
IDHr             = '" . $StudentR->EmpId . "' ,
typeHr           = '" . $StudentR->IsSchoolBelong . "' 
where ID         = '" . $query2['Father_ID'] . "' ");
} else {
    $where_father = "";
    if ($this->ApiDbname == 'SchoolAccTabuk') {
        $where_father = "   User_Name        = '" . $StudentR->FaIdNumber . "' ,
                   Password         = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $StudentR->FaIdNumber) . "', ";
    }
    $this->db->query("update  contact SET  
$Name            = '" . $FaName . "' ,
$Name_en         = '" . $FaNameEn . "' ,
$where_father
ID_ACC           = '" . $StudentR->FaId . "' ,
Number_ID        = '" . $StudentR->FaIdNumber . "' ,
Phone            = '" . $StudentR->FaMobile1 . "' ,
Nationality_ID   = '" . $StudentR->NationalityId . "' ,
Longtude          = '" . $StudentR->StLongtude . "' ,
Latitude          = '" . $StudentR->StLatitude . "' ,
NameAtPassport    = '" . $StudentR->NameAtPassport . "' ,
NameEnAtPassport  = '" . $StudentR->NameEnAtPassport . "' ,
PassportNumber    = '" . $StudentR->PassportNumber . "' ,
PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
IDHr             = '" . $StudentR->EmpId . "' ,
typeHr           = '" . $StudentR->IsSchoolBelong . "' 
where ID         = '" . $query2['Father_ID'] . "' ");
}
$query_s_language =  $this->db->query("select  s_language FROM student inner join contact on student.Contact_ID=contact.ID   where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
$stu_sec = $query_s_language['s_language'];
$array1 = explode(',', $stu_sec);
if ($sec_lang) {
    $query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();
    $sec_lang = $query_sub['ID'];
}
if ($religion) {
    $query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();
    $religion_id = $query_religion['ID'];
}
if ($sec_lang && $religion_id) {
    $s_language = $religion_id . ',' . $sec_lang;
} elseif ($sec_lang) {
    $s_language = $sec_lang;
} elseif ($religion_id) {
    $s_language = $religion_id;
} else {
    $s_language = "";
}
$array2 = explode(',', $s_language);
if ($array1[0] && $array2[0]) {
    $x = array_unique(array_merge($array1, $array2), SORT_REGULAR);
    $stu_sec_lang = implode(',', $x);
} elseif ($array1[0] != "") {
    $stu_sec_lang = $query_s_language['s_language'];
} elseif ($array2[0] != "") {
    $stu_sec_lang = $s_language;
} else {
    $stu_sec_lang = "";
}
$query4 = $this->db->query("select ID FROM contact where studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
$this->db->query("UPDATE student 
                  SET  
                  R_L_ID         = '" . $R_L_ID . "' ,
                  Class_ID       = '" . $class_id . "',
                  StudyTypeID    = '" . $StudyTypeId . "',
                  Birth_Date     = '" . $DateOfBirth . "',
                  Register_Date  = '" . $RegistrationDate . "',
                  previous_school= '" . $LastSchool . "',
                  s_language     = '" . $stu_sec_lang . "'
                  where Contact_ID  = '" . $query4['ID'] . "' ");

?>