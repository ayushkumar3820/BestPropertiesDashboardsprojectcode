<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/chat/'); ?>" class="btn btn-sm btn-info" style="float:right; margin-bottom: 10px;">Back</a>
    <h1><?php echo $title; ?></h1>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>

    <?php echo validation_errors(); ?>

    <form method="post" action="<?php echo base_url('admin/chat/add'); ?>">
        <div class="form-group">
            <label>Message*</label>
            <textarea name="message" class="form-control" required placeholder="Enter chat message"></textarea>
        </div>
        <div class="text-center">
            <input type="submit" name="save" value="Submit" class="btn btn-primary">
        </div>
    </form>
</div>