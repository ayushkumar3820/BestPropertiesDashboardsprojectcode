<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col main pt-5 mt-3">
    <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
    
    <a href="<?php echo base_url('admin/chat/add'); ?>" class="btn btn-sm btn-success mb-3">Add New Chat</a>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chat)): foreach ($chat as $c): ?>
                <tr>
                    <td><?php echo $c->id; ?></td>
                    <td><?php echo $c->message; ?></td>
                    <td><?php echo $c->created_at; ?></td>
                    <td>
                        <a href="<?php echo base_url('admin/chat/edit/' . $c->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?php echo base_url('admin/chat/delete/' . $c->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="4">No chat messages found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>