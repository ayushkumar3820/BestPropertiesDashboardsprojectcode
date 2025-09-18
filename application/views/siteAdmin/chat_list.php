<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="col main pt-5 mt-3">
	<a href="<?php echo base_url('admin/projects/');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>
        
      <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
      <?php
	  $message = $this->session->flashdata('message');
	  if($message != ''){
	      echo '<div class="alert alert-success">'.$message.'</div>';
		  // Clear flash data after displaying it once
		$this->session->set_flashdata('message', '');
	  }
	  echo validation_errors(); ?>
	  
	  <div class="clearfix"></div>

    <?php
    $message = $this->session->flashdata('message');
    if ($message) {
        echo '<div class="alert alert-success">'.$message.'</div>';
        $this->session->set_flashdata('message', '');
    }
    echo validation_errors();

    /* ---------- Static demo data ---------- */
    $threads = [
        ['property_id'=>101,'user_id'=>1],
        ['property_id'=>102,'user_id'=>2],
        ['property_id'=>103,'user_id'=>3],
    ];

    $staticMessages = [
        ['status'=>'admin','message'=>'Welcome to the chat demo!','r_date'=>'2025-09-17 10:00:00'],
        ['status'=>'user','message'=>'Thanks, just testing this feature.','r_date'=>'2025-09-17 10:05:00'],
        ['status'=>'admin','message'=>'Everything is working fine here.','r_date'=>'2025-09-17 10:10:00'],
    ];

    $active_property = 101;
    $active_user     = 1;
    ?>

    <div class="row border rounded shadow-sm" style="height:75vh;">
        <!-- LEFT THREAD LIST -->
        <div class="col-md-4 border-end overflow-auto p-0">
            <div class="bg-light p-2 fw-bold border-bottom">Chat</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($threads as $t): ?>
                    <?php $active = ($active_property==$t['property_id'] && $active_user==$t['user_id']); ?>
                    <li class="list-group-item <?= $active ? 'active' : '' ?>">
                        <a href="#"
                           class="d-block text-decoration-none <?= $active ? 'text-white' : 'text-dark' ?>">
                           Property #<?= $t['property_id'] ?><br>
                           User #<?= $t['user_id'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- RIGHT CHAT WINDOW -->
        <div class="col-md-8 d-flex flex-column">
            <div class="flex-grow-1 overflow-auto p-3">
                <?php foreach ($staticMessages as $m): ?>
                    <div class="mb-3">
                        <strong><?= $m['status']==='admin' ? 'Admin' : 'User'; ?>:</strong>
                        <?= htmlspecialchars($m['message']); ?><br>
                        <small class="text-muted">
                            <?= date('d M Y h:i A', strtotime($m['r_date'])); ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- message input (disabled demo) -->
            <form class="border-top p-2 d-flex">
                <input type="text" class="form-control me-2" placeholder="Type message…" disabled>
                <button class="btn btn-primary" disabled>Send</button>
            </form>
        </div>
    </div>
</div>
