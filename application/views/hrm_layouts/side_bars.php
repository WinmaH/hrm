<div class="ui left fixed inverted vertical menu" id="sidebar">

    <div class="item">
        Hello <?=$this->session->userdata('username'); ?> !

    </div>
    <div class="ui divider"></div>



    <?php if($this->aauth->is_admin()){ ?>
        <a class="item" href="<?php echo base_url(''); ?>"><i class="block layout icon"></i>Dashboard</a>
        <a class="item" href="<?php echo base_url('Hrm_employee'); ?>"><i class="Add User icon"></i>Employee</a>
        <a class="item" href="<?php echo base_url('Hrm_salary/index'); ?>"><i class="Dollar icon"></i>Salary Payments</a>
        <a class="item" href="<?php echo base_url('issue'); ?>"><i class="Announcement icon"></i>Leave Notifications</a>

    <?php }

    else{?>
        <a class="item" href="<?php echo base_url(''); ?>"><i class="block layout icon"></i>Dashboard</a>
        <a class="item" href="<?php echo base_url('project'); ?>"><i class="Dollar icon"></i>Salary</a>
        <a class="item" href="<?php echo base_url('inventory'); ?>"><i class="Checkmark Box icon"></i>Attendance</a>
        <a class="item" href="<?php echo base_url('extinguisher'); ?>"><i class="Remove User icon"></i>Leave</a>
        <a class="item" href="<?php echo base_url('issue'); ?>"><i class="Announcement icon"></i>Notifications</a>

    <?php }?>

    <a class="item" href="<?php echo base_url('settings'); ?>"><i class="settings icon"></i>Settings</a>
    <a class="item" href="<?php echo base_url('Login/login1'); ?>">Logout</a>

</div>