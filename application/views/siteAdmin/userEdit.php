
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/user/') ?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>
    <h1 class="d-sm-block heading"><?php echo $title; ?></h1>

    <?php
    $info = $user[0];
    $message = $this->session->flashdata('message');
    if($message != ''){
        echo '<div class="alert alert-success">'.$message.'</div>';
    }
    echo validation_errors(); 
    ?>

    <form class="form" method="post" action="<?php echo base_url('admin/user/edit/').$this->uri->segment('4');?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" value="<?php echo set_value('name', $info->fullName); ?>" required class="form-control" placeholder="Name">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" value="<?php echo set_value('email', $info->email); ?>" required class="form-control" placeholder="Email">
                </div>
            </div>

           <div class="col-sm-6">
    <div class="form-group">
        <label>Password <small>(Please keep it empty if you don't want to change password)
</small></label>
        <input type="password" name="password" value="" class="form-control" placeholder="Password" autocomplete="new-password">
    </div>
</div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="number" name="mobile" value="<?php echo set_value('mobile', $info->phone); ?>" class="form-control" placeholder="Phone">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo set_value('address', $info->address); ?>" class="form-control" placeholder="Address">
                </div>
            </div>

          <div class="col-sm-6">
    <div class="form-group">
        <label>Company*</label>
        <select name="company_id_display" class="form-control" disabled>
            <option value="">-- Select Company --</option>
            <?php foreach ($companies as $c): ?>
                <option value="<?php echo $c['id']; ?>"
                    <?php echo ($info->company_id == $c['id']) ? 'selected' : ''; ?>>
                    <?php echo $c['company_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- hidden field ensures value is submitted -->
        <input type="hidden" name="company_id" value="<?php echo $info->company_id; ?>">
    </div>
</div>



            <?php
            $selected_roles = !empty($info->role) ? array_map('trim', explode(',', $info->role)) : [];
            // $all_roles = ['Admin', 'Manager', 'Agent', 'Telecaller', 'Marketing Exec', 'CRM Executive', 'Documentation'];
            $all_roles = ['Manager', 'Agent', 'Telecaller'];

            ?>
            <div class="col-sm-12">
                <div class="form-group-role">
                    <label>Role*</label><br>
                    <?php foreach ($all_roles as $role): ?>
                        <label>
                            <input type="radio" name="role[]" value="<?php echo $role; ?>" 
                            <?php echo in_array($role, $selected_roles) ? 'checked' : ''; ?>> <?php echo $role; ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-sm-12 text-center">
                <input type="submit" value="Submit" name="save" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

    

<style>
	.form-group-role{
				display: flex;
		padding-top: 37px;
		gap: 20px;

}
</style>