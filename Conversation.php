<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conversation extends CI_Controller
{

    private $data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('chatting/chatting_model', 'admin/setting_model'));
        $this->load->library('get_data_admin');
        $this->load->helper('text');
        $this->load->helper('download');
        $this->data['UID']      = $this->session->userdata('id');
        $this->data['YearID']   = $this->session->userdata('YearID');
        $this->data['Year']     = $this->session->userdata('Year');
        $this->data['Semester'] = $this->session->userdata('Semester');
        $this->data['Lang']     = $this->session->userdata('language');
        $this->user_id            = (int)$this->session->userdata("id");
        $this->SchoolID         = (int)$this->session->userdata('SchoolID');
        $this->data['date']     = $this->setting_model->converToTimezone_api();
        $this->config->load('api_config');
        $key = strtolower($this->uri->segment(1));
        if ($key != "chatting") {
            $this->data['database'] = $this->config->item($key);
            $configdb = $this->config->config['secondDatabase'];
            $configdb['database'] = $this->data['database']['database'];
            $configdb['username'] = $this->data['database']['username'];
            $configdb['password'] = $this->data['database']['password'];
            $this->db = $this->load->database($configdb, TRUE);
        }
    }

    public function uploadFile()
    {
        $this->data['success']    = '';
        $this->data['msg_upload'] = '';
        $this->data['base']       = base_url();
        $file_element_name        = 'fileUpload';
        if (empty($_FILES[$file_element_name]['name'])) {
            $this->data['success']   = '0';
            $this->data['msg_upload'] = 'File Empty ';
        } else {
            $config['upload_path']   = './chat_uploads/';
            $config['allowed_types'] = 'mp3|wav|aif|aiff|ogg|MP3|gif|jpg|png|jpeg|doc|docx|txt|text|zip|rar|pdf|mp4|ppt|pptx|pptm|xls|xlsm|xlsx|m4a|M4A';
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $this->data['success']    = '0';
                $this->data['msg_upload'] = $this->upload->display_errors();
            } else {
                $upload_data              = $this->upload->data();
                $this->data['success']    = '1';
                $this->data['msg_upload'] = 'msg_sucsess_upload';
                $this->data['img']        = $upload_data['file_name'];
            }
        }
        $this->jsonData($this->data);
    }

    public function deleteFile()
    {
        if (file_exists('./chat_uploads/' . $this->input->post('attachment'))) {
            unlink('./chat_uploads/' . $this->input->post('attachment'));
            $data['success'] = '1';
        }
        $this->jsonData($data);
    }

    public function jsonData($data)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function index($cat = null, $type = null)
    {
        $data['records'] =  $this->chatting_model->GetMessageList($cat, $type);
        $data['count']   = $this->chatting_model->countAllUnread();
        $data['school']  = $this->chatting_model->getSchoolName();
        $data['subview'] = 'chatting/conversation';
        $data['header']  = array(
            'U' => 'admin/header',
            'E' => 'emp/header',
            'F' => 'father/header',
            'S' => 'student/header',
        );
        $data['footer']  = array(
            'U' => 'admin/footer',
            'E' => 'emp/footer',
            'F' => 'father/footer',
            'S' => 'student/footer',
        );
        $data['cat'] = $cat;
        $data['img'] = $this->chatting_model->getImageById($this->session->userdata('id'));
        $data['Level_ID'] = '';



        $query1 = $this->db->query("SELECT type FROM contact    WHERE  ID='" . $this->session->userdata('id') . "' ");
        $query = $query1->row_array();
        if ($query1->num_rows() > 0) {
            $type = $query['type'];
        }

        $arr_Level_ID = array();
        if ($type == 'S') {
            $query1 = $this->db->query("SELECT Level_ID FROM row_level  join student on row_level.ID=student.R_L_ID   WHERE  student.Contact_ID='" . $this->session->userdata('id') . "' ");
            $query = $query1->row_array();
            if ($query1->num_rows() > 0) {
                $data['Level_ID'] = $query['Level_ID'];
            }
        } elseif ($type == 'F') {
            $query1 = $this->db->query("SELECT Contact_ID FROM student     WHERE  Father_ID ='" . $this->session->userdata('id') . "' ");
            $query = $query1->result();
            if ($query1->num_rows() > 0) {
                foreach ($query as $student) {
                    $contact = $student->Contact_ID;



                    $query1 = $this->db->query("SELECT Level_ID FROM row_level  join student on row_level.ID=student.R_L_ID   WHERE  student.Contact_ID='" . $contact . "' ");
                    $query = $query1->row_array();
                    if ($query1->num_rows() > 0) {
                        $arr_Level_ID[] = $query['Level_ID'];
                    }
                }
                $data['Level_ID'] = $arr_Level_ID;
            }


            $data['Level_ID'] = implode(",", $data['Level_ID']);
        } else {
            $data['Level_ID'] = '';
        }

        $this->load->view('chatting/index', $data);
    }

    public function parents()
    {
        $this->index('F');
    }

    public function students()
    {
        $this->index('S');
    }

    public function employers()
    {
        $this->index('E');
    }

    public function getUsers()
    {
        $category = $this->input->post('category');
        $select   = $this->selectFunction($category);
        $where    = $this->whereFunction($category);
        $join       = $this->joinFunction($category);
        $from       = $this->fromFunction($category);
        $groupBy  = $this->groupByFunction($category);
        $orderBy  = $this->orderByFunction($category);

        $data = $this->chatting_model->getAllUsers($category, $select, $where, $join, $from, $groupBy, $orderBy);
        $this->jsonData($data);
    }

    public function fromFunction($category)
    {
        $from = array(
            'person'    => 'contact',
            'staff'     => 'contact',
            'parents'   => 'contact',
            'students'  => 'contact',
            'levels'    => 'row_level',
            'row'       => 'row_level',
            'class'     => 'row_level',
            'U-class'   => 'row_level',
            'admin'        => 'contact',
            'E-student' => 'class_table',
            'E-parents' => 'class_table',
            'E-class'   => 'row_level',
            'F-staff'   => 'student',
            'S-staff'   => 'student',
            'S-student' => 'student',
        );
        return $from[$category];
    }

    public function whereFunction($category)
    {
        $where = array(
            'person'    => array(
                'contact.Isactive' => 1,
                'contact.ID!=' => $this->user_id,
                'contact.SchoolID' => $this->SchoolID
            ),
            'staff'     => array(
                'contact.Isactive' => 1,
                //'contact.ID!='=>$this->user_id, 
                'contact.SchoolID' => $this->SchoolID,
                'contact.Type' => 'E'
            ),
            'parents'   => array(
                'contact.Isactive' => 1,
                'contact.ID!=' => $this->user_id,
                'contact.SchoolID' => $this->SchoolID
            ),
            'students'  => array(
                'contact.Isactive' => 1,
                'contact.SchoolID' => $this->SchoolID,
                'contact.Type' => 'S'
            ),
            'levels'    => array(
                'row_level.IsActive' => 1,
                'level.Is_Active' => 1,
                'school_row_level.SchoolID' => $this->SchoolID
            ),
            'row'       => array(
                'row_level.IsActive' => 1,
                'row.Is_Active' => 1,
                'level.Is_Active' => 1,
                'school_row_level.SchoolID' => $this->SchoolID
            ),
            'class'     => array(
                'row_level.IsActive' => 1,
                'row.Is_Active' => 1,
                'level.Is_Active' => 1,
                'base_class_table.IsActive' => 1,
                'school_row_level.SchoolID' => $this->SchoolID
            ),

            'U-class'     => array(
                'row_level.IsActive' => 1,
                'school_row_level.SchoolID' => $this->SchoolID
            ),

            'admin'     => array('contact.SchoolID' => $this->SchoolID),
            'E-student' => array(
                'class_table.EmpID' => $this->user_id,
                'base_class_table.IsActive' => 1,
                's.SchoolID' => $this->SchoolID, 's.Isactive' => 1
            ),
            'E-parents' => array(
                'class_table.EmpID' => $this->user_id,
                'base_class_table.IsActive' => 1,
                'contact.SchoolID' => $this->SchoolID
            ),
            'E-class'    => array(
                'row_level.IsActive' => 1,
                'row.Is_Active' => 1,
                'level.Is_Active' => 1,
                'base_class_table.IsActive' => 1,
                'class_table.EmpID' => $this->user_id
            ),
            'F-staff'    => array(
                'student.Father_ID' => $this->user_id,
                'base_class_table.IsActive' => 1,
                'contact.SchoolID' => $this->SchoolID
            ),
            'S-staff'    => array(
                'student.Contact_ID' => $this->user_id,
                'base_class_table.IsActive' => 1,
                'contact.SchoolID' => $this->SchoolID
            ),
            'S-student' => array(
                'student.Contact_ID' => $this->user_id,
                's.SchoolID' => $this->SchoolID
            ),
        );
        return $where[$category];
    }

    public function selectFunction($category)
    {
        $language  = array('english' => 'Name_en', 'arabic' => 'Name');
        $language2 = array('english' => 'Name_en', 'arabic' => 'Name_Ar');

        $select = array(
            'person'    => 'contact.ID, contact.Name',
            'staff'     => 'contact.ID, contact.Name',
            'parents'   => 'contact.ID, contact.Name',
            'students'  => 'contact.ID, contact.Name as Name, level.' . $language[$this->data['Lang']] . ' AS level, row.' . $language[$this->data['Lang']] . ' AS row, class.' . $language[$this->data['Lang']] . ' AS className',
            'levels'    => "level.ID, level." . $language[$this->data['Lang']] . " AS Name",
            'row'       => "row_level.ID, level." . $language[$this->data['Lang']] . " AS LevelName, row." . $language[$this->data['Lang']] . " AS RowName",
            'class'     => "class_table.ID,class_table.RowLevelID,class.ID AS classid, level." . $language[$this->data['Lang']] . " AS LevelName, row." . $language[$this->data['Lang']] . " AS RowName, class." . $language[$this->data['Lang']] . " AS ClassName",
            'U-class'   => "row_level.ID AS RowLevelID,class.ID AS classid, level." . $language[$this->data['Lang']] . " AS LevelName, row." . $language[$this->data['Lang']] . " AS RowName, class." . $language[$this->data['Lang']] . " AS ClassName",
            'admin'     => "contact.ID, contact.Name,  employee.PerType, job_title." . $language2[$this->data['Lang']] . " AS JobTitle",
            'E-student' => "s.Name as Name ,s.ID",
            'E-parents' => "contact.Name, contact.ID",
            'E-class'    => "class_table.RowLevelID,class.ID AS classid,class_table.ID, level." . $language[$this->data['Lang']] . " AS LevelName, row." . $language[$this->data['Lang']] . " AS RowName, class." . $language[$this->data['Lang']] . " AS ClassName ",
            'F-staff'    => 'contact.Name, contact.ID',
            'S-staff'    => 'contact.Name, contact.ID',
            'S-student'    => "s.Name as Name ,s.ID",
        );
        return $select[$category];
    }

    public function joinFunction($category)
    {
        $join = array(
            'students'  => array(
                'student' => 'contact.ID = student.Contact_ID',
                'row_level' => 'row_level.ID = student.R_L_ID',
                'level' => 'level.ID = row_level.Level_ID',
                'row' => 'row.ID = row_level.Row_ID',
                'class' => 'class.ID = student.Class_ID',
                'contact as fa' => 'student.Father_ID = fa.ID'
            ),
            'levels'    => array(
                'level' => 'level.ID = row_level.Level_ID',
                'school_row_level' => 'school_row_level.RowLevelID = row_level.ID',
                'student' => 'student.R_L_ID= row_level.ID'
            ),
            'row'          => array(
                'level' => 'level.ID = row_level.Level_ID',
                'row' => 'row.ID = row_level.Row_ID',
                'school_row_level' => 'school_row_level.RowLevelID = row_level.ID',
                'student' => 'student.R_L_ID= row_level.ID'
            ),
            'class'     => array(
                'level' => 'level.ID = row_level.Level_ID',
                'row' => 'row.ID = row_level.Row_ID',
                'class_table' => 'class_table.RowLevelID = row_level.ID',
                'class' => 'class_table.ClassID = class.ID',
                'base_class_table' => 'base_class_table.ID = class_table.BaseTableID',
                'school_row_level' => 'school_row_level.RowLevelID = row_level.ID',
                'student' => 'student.R_L_ID= row_level.ID and student.Class_ID=class.ID'
            ),
            'U-class'     => array(
                'level' => 'level.ID = row_level.Level_ID',
                'row' => 'row.ID = row_level.Row_ID',
                'student' => 'student.R_L_ID= row_level.ID',
                'class' => 'student.Class_ID=class.ID',
                'school_row_level' => 'school_row_level.RowLevelID = row_level.ID'
            ),
            'admin'     => array(
                'employee' => 'contact.ID = employee.Contact_ID',
                'job_title' => 'employee.jobTitleID = job_title.ID',
            ),
            'E-student' => array(
                'base_class_table' => 'class_table.BaseTableID = base_class_table.ID',
                'student' => 'student.Class_ID = class_table.ClassID AND student.R_L_ID = class_table.RowLevelID',
                'contact as s' => 'student.Contact_ID = s.ID',
                'contact as f' => 'student.Father_ID = f.ID',
            ),
            'E-parents' => array(
                'base_class_table' => 'class_table.BaseTableID = base_class_table.ID',
                'student' => 'student.Class_ID = class_table.ClassID AND student.R_L_ID = class_table.RowLevelID',
                'contact' => 'student.Father_ID = contact.ID',
            ),
            'parents' => array(
                'student' => 'contact.ID = student.Father_ID',
            ),
            'E-class'   => array(
                'level' => 'level.ID = row_level.Level_ID',
                'row' => 'row.ID = row_level.Row_ID',
                'class_table' => 'class_table.RowLevelID = row_level.ID',
                'class' => 'class_table.ClassID = class.ID',
                'base_class_table' => 'base_class_table.ID = class_table.BaseTableID',
                'school_row_level' => 'school_row_level.RowLevelID = row_level.ID',
                'student' => 'student.R_L_ID= row_level.ID and student.Class_ID=class.ID'
            ),
            'F-staff'   => array(
                'class_table' => 'class_table.ClassID = student.Class_ID and class_table.RowLevelID=student.R_L_ID',
                'base_class_table' => 'base_class_table.ID = class_table.BaseTableID',
                'contact' => 'class_table.EmpID = contact.ID',
            ),
            'S-staff'   => array(
                'class_table' => 'class_table.ClassID = student.Class_ID and class_table.RowLevelID=student.R_L_ID',
                'base_class_table' => 'base_class_table.ID = class_table.BaseTableID',
                'contact' => 'class_table.EmpID = contact.ID',
            ),
            'S-student' => array(
                'student as c' => 'student.Class_ID = c.Class_ID and student.R_L_ID = c.R_L_ID and c.Contact_ID!=' . $this->user_id . '',
                'contact as s' => 'c.Contact_ID = s.ID',
                'contact as f' => 'c.Father_ID = f.ID',
            ),
        );
        return $join[$category];
    }

    public function groupByFunction($category)
    {
        $groupBy = array(
            'levels'    => array('level.ID'),
            'row'       => array('row_level.ID'),
            'class'     => array('class_table.ClassID', "class_table.RowLevelID"),
            'U-class'   => array('row_level.ID', "class.ID"),
            'E-student' => array('s.ID'),
            'parents'   => array('contact.ID'),
            'E-parents' => array('contact.ID'),
            'E-class'   => array('class_table.ClassID', "class_table.RowLevelID"),
            'F-staff'    => array('contact.ID'),
            'S-staff'    => array('contact.ID'),
            'admin'     => array('contact.ID'),
            'students'  => array('contact.ID'),
        );
        return $groupBy[$category];
    }

    public function orderByFunction($category)
    {
        $orderBy = array(
            'levels'    => array("level.ID" => "desc"),
            'row'       => array("row_level.ID" => "desc"),
            'U-class'     => array("row_level.ID" => "desc"),
            //'U-class'     => array("level.ID"=>"ASC","row.ID"=>"ASC","class.ID"=>"ASC"),
            'class'     => array("row_level.ID" => "desc"),
            'E-class'   => array("row_level.ID" => "desc"),
        );
        return $orderBy[$category];
    }

    public function sendMessage()
    {
        $this->chatting_model->sendMessage($this->data['date']);
        redirect('chatting/conversation/index/' . $this->input->post('cat'), 'refresh');
    }

    public function chat($cat)
    {
        $data['to_user']          = $this->input->post('to_user');
        $data['conversation_id'] = $this->input->post('conversation_id');
        $this->chatting_model->updateRead($data['conversation_id'], $this->input->post('chat_id'));
        $data['chat_id']          = $this->input->post('chat_id');
        $data['to_user_name']      = $this->input->post('to_user_name');
        $data['count']            = $this->chatting_model->countAllUnread();
        $data['records']            = $this->chatting_model->GetChatHistory($data['to_user'], $cat);
        // 		print_r($data['records']);die;
        $data['subview'] = 'chatting/chat';
        $data['header']  = array(
            'U' => 'admin/header',
            'E' => 'emp/header',
            'F' => 'father/header',
            'S' => 'student/header',
        );
        $data['footer']  = array(
            'U' => 'admin/footer',
            'E' => 'emp/footer',
            'F' => 'father/footer',
            'S' => 'student/footer',
        );
        $data['img'] = $this->chatting_model->getImageById($this->session->userdata('id'));
        $data['img_to'] = $this->chatting_model->getImageById($this->input->post('to_user'));
        $data['Level_ID'] = '';
        $query1 = $this->db->query("SELECT type FROM contact    WHERE  ID='" . $this->session->userdata('id') . "' ");
        $query = $query1->row_array();
        if ($query1->num_rows() > 0) {
            $type = $query['type'];
        }

        $arr_Level_ID = array();
        if ($type == 'S') {
            $query1 = $this->db->query("SELECT Level_ID FROM row_level  join student on row_level.ID=student.R_L_ID   WHERE  student.Contact_ID='" . $this->session->userdata('id') . "' ");
            $query = $query1->row_array();
            if ($query1->num_rows() > 0) {
                $data['Level_ID'] = $query['Level_ID'];
            }
        } elseif ($type == 'F') {
            $query1 = $this->db->query("SELECT Contact_ID FROM student     WHERE  Father_ID ='" . $this->session->userdata('id') . "' ");
            $query = $query1->result();
            if ($query1->num_rows() > 0) {
                foreach ($query as $student) {
                    $contact = $student->Contact_ID;



                    $query1 = $this->db->query("SELECT Level_ID FROM row_level  join student on row_level.ID=student.R_L_ID   WHERE  student.Contact_ID='" . $contact . "' ");
                    $query = $query1->row_array();
                    if ($query1->num_rows() > 0) {
                        $arr_Level_ID[] = $query['Level_ID'];
                    }
                }
                $data['Level_ID'] = $arr_Level_ID;
            }


            $data['Level_ID'] = implode(",", $data['Level_ID']);
        } else {
            $data['Level_ID'] = '';
        }
        $this->load->view('chatting/index', $data);
    }

    public function sendChatMessage()
    {
        return $this->jsonData($this->chatting_model->sendChatMessage($this->data['date']));
    }

    public function getChatMessage()
    {
        $data = $this->chatting_model->getChatMessage($this->input->post('to_user'), $this->input->post('chat_id'));
        return $this->jsonData($data);
    }

    public function countAllUnread()
    {
        $data = $this->chatting_model->countAllUnread();
        if (!$data) {
            return $this->jsonData(array());
        }
        return $this->jsonData($data);
    }
    public function count_All_Unread()
    {
        $data = $this->chatting_model->count_All_Unread();
        if (!$data) {
            print_r($this->jsonData(array()));
        }
        print_r($this->jsonData($data));
    }
    public function count_All_Unread1()
    {
        $data = $this->chatting_model->count_All_Unread();
        /*if (! $data) {
			print_r(  $this->jsonData(array()));
		}*/
        //	print_r(  $this->jsonData($data));
        print_r($data);
    }
    public function acceptAudioFile()
    {
        $config['upload_path']   = './chat_uploads/audio/';
        $config['allowed_types'] = 'wav';
        $config['encrypt_name']  = TRUE;
        $this->load->library('upload', $config);
        $this->upload->do_upload('audio');
        $upload_data    = $this->upload->data();
        $_POST['audio'] = $upload_data['file_name'];

        return $this->jsonData($this->chatting_model->sendChatMessage());
    }

    public function delete_chat()
    {
        $at = date('Y-m-d H:i', strtotime('+2 hour'));


        $delete_data = array(
            'is_deleted'   => 1,   'updated_at'   => $at,
            'updated_by'   => $this->session->userdata("id"),
        );
        $this->db->where('ID', (int)$this->input->post('id'));
        $Insert_q =  $this->db->update('messages', $delete_data);

        echo 1;
    }

    public function count()
    {
        $this->load->model('general_message_model');
        $count = $this->chatting_model->count_new_messages();
        // return $count;
        return $this->jsonData($count);
    }
}
