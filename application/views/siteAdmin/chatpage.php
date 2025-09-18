<div class="chat-container">
    <h3>Chat for User ID: <?php echo $user_id; ?> | Property ID: <?php echo $property_id; ?></h3>

    <!-- Chat Messages Display -->
    <div class="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message" style="margin: 10px 0; padding: 5px; background: #f9f9f9; border-radius: 5px;">
                    <p><strong>Message:</strong> <?php echo htmlspecialchars($message->message_text); ?></p>
                    <p><small><em>Sent on: <?php echo date('Y-m-d H:i:s', strtotime($message->r_date)); ?></em></small></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>

    <!-- Chat Input Form -->
    <div class="chat-input" style="margin-top: 20px;">
        <form id="chatForm" method="post" action="<?php echo base_url('admin/properties/send_message'); ?>">
            <textarea name="message_text" placeholder="Type your message here..." style="width: 70%; height: 50px; resize: none;"></textarea>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
            <button type="submit" style="padding: 5px 10px; background: #007bff; color: white; border: none; border-radius: 5px;">Send</button>
        </form>
    </div>
</div>

<script>
    // Basic form submission handling (optional AJAX can be added)
    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh page to show new message
            } else {
                alert('Error sending message.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<style>
    .chat-container { max-width: 800px; margin: 20px auto; }
    .message { word-wrap: break-word; }
</style>