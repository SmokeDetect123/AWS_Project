let username = '';

function startChat() {
    username = $('#username').val().trim();
    if (username) {
        $('#login-section').hide();
        $('#chat-section').show();
        loadMessages();
        setInterval(loadMessages, 2000); // Refresh messages every 2 seconds
    } else {
        alert("Please enter a username.");
    }
}

// Function to load messages
function loadMessages() {
    $.ajax({
        url: 'chat.php',
        method: 'GET',
        data: { user: username },
        dataType: 'xml',
        success: function(xml) {
            $('#chat-display').empty();
            $(xml).find('message').each(function() {
                const user = $(this).find('user').text();
                const text = $(this).find('text').text();
                const time = $(this).find('timestamp').text();
                $('#chat-display').append('<div><strong>' + user + ':</strong> ' + text + ' <span class="timestamp">(' + time + ')</span></div>');
            });
            $('#chat-display').scrollTop($('#chat-display')[0].scrollHeight);
        }
    });
}

// Function to send a message
function sendMessage() {
    const message = $('#message').val().trim();
    if (message) {
        $.ajax({
            url: 'chat.php',
            method: 'POST',
            data: { message: message, user: username },
            success: function() {
                $('#message').val(''); // Clear input after sending
                loadMessages();
            }
        });
    }
}
