<?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

class Request extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->uploadTypes = array(
            'doc' => ['allowed_types' => 'pdf|docx|doc'],
            'img' => ['allowed_types' => 'jpg|jpeg|png']
        );
    }

    function id($id)
    {
        return array('md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5(id))))))))))' => $id);
    }

    function encKey($key){
        return "md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5($key))))))))))";
    }

    function acak($text)
    {
        return md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5($text))))))))));
    }

    function cekRelasiUpk($idUpk)
    {
        $hasil = "";
        $harus = "";
        $table = array(
            't_jabatan',
            't_jenis',
            't_sifat',
            't_staf',
            't_tujuan',
            't_aksi',
            't_status'
        );
        foreach ($table as $key) {
            $hasil .= ($this->db->get_where($key, array('id_upk' => $idUpk))->num_rows()) > 0 ? "1" : "0" ;
            $harus .= "0";
        }
        if ($hasil == $harus) {
            return true;
        } else {
            return false;
        }
    }

    function getIdUpk($id)
    {
        return $this->db->get_where('t_upk', $this->id($id))->row();
    }

    function print($array)
    {
        ob_clean();
        echo "<pre>";
        echo print_r($array);
        echo "</pre>";
        exit(0);
    }

    function json($array)
    {
        echo "<pre>";
        echo json_encode($array);
        echo "</pre>";
    }

    function query()
    {
        echo $this->db->last_query();
    }

    function input($input)
    {
        return htmlspecialchars(ltrim(rtrim($_POST[$input])));
    }

    function all($guarded = null)
    {
        $request = $_POST;
        foreach ($request as $key => $value) {
            $result[$key] = $this->input($key);
        }
        if ($guarded != null) {
            foreach ($guarded as $guard_ => $value) {
                if ($value == false) {
                    unset($request[$guard_]);
                } else {
                    unset($request[$guard_]);
                    $request[$guard_] = $value;
                }
            }
        }
        return $request;
    }

    function getKodeUpk($idUpk)
    {
        $this->load->model('admin/M_config', 'config_');
        return $this->config_->getKodeUpk($_SESSION['upk']);
    }

    function getLogo()
    {
        $data = $this->db->get_where('t_config', array("config" => "logo"))->row();
        return $data->value;
    }
    
    function getLogoUpk()
    {
        $this->load->model('admin/M_config', 'config_');
        $kodeUpk = $this->config_->getKodeUpk($_SESSION['upk']);
        $data = $this->db->get_where('t_config', array("config" => "$kodeUpk{}logo"))->row();
        return $data->value;
    }

    function upload($data)
    {
        $config = array(
            'upload_path' => './uploads/' . $data['path'],
            // 'allowed_types' = 'pdf|doc|docx|jpg|jpeg|';
            'encrypt_name' => $data['encrypt']
        );
        $config = array_merge($config, $this->uploadTypes[$data['type']]);
        $this->load->library('upload', $config);
        $uploading = $this->upload->do_upload($data['file']) ? true : false;
        if (!$uploading) {
            return array(
                'message' => 'error',
                'data' => $this->upload->display_errors()
            );
        } else {
            return array(
                'message' => 'success',
                'data' => $this->upload->data()
            );
        }
    }

    function upload_form($data)
    {
        $encrypt = (isset($data['encrypt']) == true) ? true : false ;
        $fileName = (isset($data['fileName']) != '') ? $data['fileName'] : null ;
        $customInput = (isset($data['customInput']) != '') ? $data['customInput'] : null ;
        if ($fileName) {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'file_name' => $data['fileName']
            );
        } else {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'encrypt_name' => $encrypt
            );
        }
        // echo count($_FILES['lampiran']['name']);
        // $this->print($data['file']);
        $config = array_merge($config, $this->uploadTypes[$data['type']]);
        $this->load->library('upload', $config);
        $uploading = $this->upload->do_upload($data['file']) ? true : false;
        if (!$uploading) {
            return $data_ = $this->all($customInput);
        } else {
            $data_ = $this->all($customInput);
            $upload_data = $this->upload->data();
            $result = array_merge($data_, [$data['file'] => $upload_data['file_name']]);
            // print_r($result);
            return $result;
        }
    }

    function upload_form_multi($data)
    {
        $fileName = "";
        $result = [];
        $customInput = (isset($data['customInput']) != '') ? $data['customInput'] : null;
        // $this->print($_FILES[$data['file']]['name']);
        $countfiles = count($_FILES[$data['file']]['name']);
        $success = 0;
        for ($i = 0; $i < $countfiles; $i++) {
            if (!empty($_FILES[$data['file']]['name'][$i])) {

                $fileNameNa = str_replace(["'","`",";","^"], "", $_FILES[$data['file']]['name'][$i]);

                $_FILES['file']['name'] = $fileNameNa;
                $_FILES['file']['type'] = $_FILES[$data['file']]['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES[$data['file']]['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES[$data['file']]['error'][$i];
                $_FILES['file']['size'] = $_FILES[$data['file']]['size'][$i];

                if ($data['encrypt'] != false) {
                    $config = array(
                        'upload_path' => './uploads/' . $data['path'],
                        'encrypt_name' => true
                    );
                } else {
                    $config = array(
                        'upload_path' => './uploads/' . $data['path'],
                        'encrypt_name' => false,
                        'file_name' => time() ."-" . $fileNameNa
                    );
                }
                
                $config = array_merge($config, $this->uploadTypes[$data['type']]);

                $this->load->library('upload', $config);

                // File upload
                $uploading = $this->upload->do_upload('file') ? true : false;
                if ($uploading) {
                    // Get data about the file
                    $success++;
                    $uploadData = $this->upload->data();
                    $fileName .= $uploadData['file_name'] . ",";
                } else {
                    return $this->upload->display_errors();
                }
            }            
        }
        $fileName = substr($fileName, 0, strlen($fileName) - 1);
        return $result = [
            'total' => $countfiles,
            'success' => $success,
            'data' => array_merge($this->all($data['customInput']), ['lampiran'=> $fileName])
        ];
    }

    function insertNotif($data)
    {   
        $suratNa = $this->db->get_where($data['table'], ['notif' => $data['notif']])->row();
        $idSuratMasuk  = null;
        $idSuratKeluar = null;
        $idSuratRevisi = null;
        switch ($data['tipe']) {
            case '1':
                $idSuratMasuk = $suratNa->id;
            break;
            case '2':
                $idSuratKeluar = $suratNa->id;
            break;
            case '3':
                $idSuratRevisi = $suratNa->id;
            break;
            case '4':
                $idSuratKeluar = $suratNa->id;
            break;
            default:
                # code...
            break;
        }
        $tuju = explode(",", $data['tujuan']);
        foreach ($tuju as $key) {
            if ($key != "") {
                $data = [
                    'notif' => $data['notif'],
                    'id_surat_masuk' => $idSuratMasuk,
                    'id_surat_keluar' => $idSuratKeluar,
                    'id_revisi' => $idSuratRevisi,
                    'id_user' => $key,
                    'tipe' => $data['tipe']
                ];
                $this->db->insert("t_notif", $data);
            }
        }
    }


    function sendMail($dataNa)
    {
        
        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';

        // PHPMailer object
        $response   = false;
        $mail       = new PHPMailer();       

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'suksesdianglobaltech@gmail.com'; // user email
        $mail->Password = 'suksespasti123'; // password email
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->setFrom('suksesdianglobaltech@gmail.com', ''); // user email
        // $mail->addReplyTo('xxx@hostdomain.com', ''); //user email
        
        // Add a recipient
        // $mail->addAddress('agastypandu@gmail.com'); //email tujuan pengiriman email
        if ($dataNa['email'] != '') {
            foreach ($dataNa['email'] as $key) {
                $mail->addAddress($key); //email tujuan pengiriman email
            }    
        }

        if ($dataNa['jabatanemail'] != '') {
            foreach ($dataNa['jabatanemail'] as $keyNa) {
                $mail->addAddress($keyNa); //email tujuan pengiriman email
            }  
        }


        // Email subject
        $mail->Subject = $dataNa['subjek']; //subject email
        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content
        $mailContent = $this->load->view('email',$dataNa, TRUE);
        $mail->Body = $mailContent;

        // Send email
        return $mail;

    }

    function getBulanRomawi()
    {
        $bul = date('n');

        switch ($bul) {
            case 1:
                $bulan = "I";
                break;
            case 2:
                $bulan = "II";
                break;
            case 3:
                $bulan = "III";
                break;
            case 4:
                $bulan = "IV";
                break;
            case 5:
                $bulan = "V";
                break;
            case 6:
                $bulan = "VI";
                break;
            case 7:
                $bulan = "VII";
                break;
            case 8:
                $bulan = "VIII";
                break;
            case 9:
                $bulan = "IX";
                break;
            case 10:
                $bulan = "X";
                break;
            case 11:
                $bulan = "XI";
                break;
            case 12:
                $bulan = "XII";
                break;
        }
        return $bulan;
    }
    
}


?>