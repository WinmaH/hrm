<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 1/27/2018
 * Time: 11:46 PM
 */
class Login extends CI_Controller

{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Hrm_dashboard_model');
        $this->load->model('Hrm_salary_model');
        $this->load->model('Hrm_training_model');
        $this->load->model('Hrm_leave_model');
        $this->load->model('Hrm_employee_model');
        $this->load->model('Hrm_attendance_model');
        $this->load->library("Aauth");
        $this->load->library("unit_test");
        //$this->output->enable_profiler(TRUE);

    }

    public function index()
    {
        // calls on the login function
        $this->login1();

    }
    public function view_dashboard(){
        $tot=$this->Hrm_dashboard_model->get_tot_employee_count();
        $data['tot_emp']=$tot;
        $basic=$this->Hrm_salary_model->get_basic();
        $year = date('Y');
        $month=date('m');
        $day=date('d');
        $array=array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
        $m=$array[$month];
        $data['total']=$this->Hrm_dashboard_model->get_tot_salary_this_month($year,$m,$basic);
        $data['new_emp']=$this->Hrm_dashboard_model->get_new_employee_count($year,$month);
        $data['salary_paid']=$this->Hrm_salary_model->get_salary_paid_count($year,$m);
        $data['params1']=$this->Hrm_training_model->get_last_record();
        // get the number of employees who participate in the last training program

        $program=$this->Hrm_training_model->get_last_record();
        $program_id=$program['Program_ID'];
        $data['program_count']=$this->Hrm_training_model->get_last_employee_count($program_id);

        $male =$this->Hrm_dashboard_model->get_male_employee_count();
        $data['taken_full']=$this->Hrm_training_model->get_program_count();
        $data['taken_half']=$this->Hrm_leave_model->get_admin_leave_count();
        $data['epf']=$this->Hrm_salary_model->get_epf();
        $data['etf']=$this->Hrm_salary_model->get_etf();
        // attendance details
        $data['present']=$this->Hrm_attendance_model->get_attendance_count($year,$month,$day);

        if($tot!=0){
           $male=$male*100/$tot;
        } else{
           $male=0;
        }
        $data['male']=$male;
        $data[ '_view']='hrm_dashboard/view';
        $this->load->view('hrm_layouts/main',$data);
    }
    public function view_employee_dashboard(){
        $data['params1']=$this->Hrm_training_model->get_last_record();
        $data['basic']=$this->Hrm_leave_model->get_last_record();
        $data['epf']=$this->Hrm_salary_model->get_epf();
        $data['etf']=$this->Hrm_salary_model->get_etf();
        $data['taken_half']=$this->Hrm_leave_model->get_employee_leave_count();
        $data['taken_full']=$this->Hrm_training_model->get_program_count();

        //get the no of employees participated in the last training program

        $program=$this->Hrm_training_model->get_last_record();
        $program_id=$program['Program_ID'];
        $data['program_count']=$this->Hrm_training_model->get_last_employee_count($program_id);
        $year = date('Y');
        $month=date('m');
        $day=date('d');
        $array=array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
        $m=$array[$month];
        $data['salary_paid']=$this->Hrm_salary_model->get_employee_paid($year,$m);
        $data['total']=$this->Hrm_employee_model->get_employee_designation();
        $user_ID=$this->session->userdata('username');
        $data['leaves']=$this->Hrm_leave_model->get_taken_full($user_ID,$year,$month) + $this->Hrm_leave_model->get_taken_half($user_ID,$year,$month);

        $data['present']=$this->Hrm_attendance_model->get_employee_attendance_count($year,$month,$day);
        $data['_view']='hrm_dashboard/view_employee';
        $this->load->view('hrm_layouts/main',$data);
    }

    public function validate($user,$pass,$remember){
        $result = $this->user_model->login($user , $pass,$remember);
        return $result;
    }


    public function login1(){

        // get the user name and password and check the validity
        $user = $this->input->post('username');
        $pass = $this->input->post('password');
        $data=array('user_name'=>$user);
        $remember = ($this->input->post('remember')=='on') ? true: false;

        if(($user!=null) && ($pass!=null)){
            $this->load->model('user_model');
            //$result = $this->user_model->login($user , $pass,$remember);

            //Bench marks

            $this->benchmark->mark('ValidateUser_start');
            $result=$this->validate($user,$pass,$remember);
            $this->benchmark->mark('ValidateUser_end');

            //if the user name and password is valid load the dashboard
            if($result){
                if($this->aauth->is_admin()){

                    // Bench marks

                    $this->benchmark->mark('ViewInterface_start');
                    $this->view_dashboard();
                    $this->benchmark->mark('ViewInterface_end');
                }
                else{
                    //Bench marks

                    $this->benchmark->mark('ViewInterface_start');
                    $this->view_employee_dashboard();
                    $this->benchmark->mark('ViewInterface_end');
                }
               //$this->view_dashboard();
            }else{
                $data = array('failed' => 1 );
                $this->load->view('hrm_user/user_login',$data);
            }

        }else{
            $data = array('failed' => 0 );
            $this->load->view('hrm_user/user_login',$data);
        }

    }


    public function test(){
        $answer=$this->validate('admin','123456',true);
        $expected=1;
        $test_name = 'login test with correct user name and password';
        $this->unit->run($answer,$expected,$test_name);

        $answer=$this->validate('admin','123',true);
        $expected=0;
        $test_name = 'login test with incorrect user name and password';
        $this->unit->run($answer,$expected,$test_name);

        echo $this->unit->report();


    }

}