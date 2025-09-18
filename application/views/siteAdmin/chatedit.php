<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/chat/'); ?>" class="btn btn-sm btn-info" style="float:right; margin-bottom: 10px;">Back</a>
    <h1><?php echo $title; ?></h1>

    <?php
    $info = $chat[0];
    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-success">' . $this->session->flashdata('message') . '</div>';
    }
    echo validation_errors(); 
    ?>

    <form method="post" action="<?php echo base_url('admin/chat/edit/' . $info->id); ?>">
        <div class="form-group">
            <label>Message*</label>
            <textarea name="message" class="form-control" required><?php echo $info->message; ?></textarea>
        </div>
        <div class="text-center">
            <input type="submit" name="save" value="Update" class="btn btn-primary">
        </div>
    </form>
</div>