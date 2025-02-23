$(document).ready(function() {
    let selectedFriend = 'friend1';  // Default to friend1

    // Update selected friend on sidebar click
    $('.friend').on('click', function() {
        selectedFriend = $(this).data('friend');
        loadMessages();
    });

    // Send message
    $('#send-message').on('click', function() {
        var message = $('#message').val();
        if (message) {
            $.ajax({
                type: 'POST',
                url: 'save_message.php',
                data: { message: message, friend: selectedFriend },
                success: function() {
                    $('#message').val('');
                    loadMessages();
                }
            });
        }
    });

    // Load messages for selected friend
    function loadMessages() {
        $.ajax({
            url: 'load_message.php',
            data: { friend: selectedFriend },
            success: function(data) {
                $('#chat-box').html(data);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }
        });
    }

    // Initial load
    loadMessages();
});
