@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Messages')

@push('css')
    <style>
        .chat-sender {
            border: 1px solid #b38e6a;
            border-radius: 40px;
            border-top-right-radius: 0px;
            background-color: #b38e6a;
            color: white;
        }

        .chat-receiver {
            border: 1px solid #eeeeee;
            border-radius: 40px;
            border-bottom-left-radius: 0px;
            background-color: #d4d2d2;
            color: rgb(0, 0, 0);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff0;
            background-clip: border-box;
            border: 1px solid rgb(0 0 0 / 0%);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
            border-radius: 20px;
            min-height: 800px;
            max-height: 800px;
            overflow: auto;
            background-color: white;
        }

        .send-message {
            position: static;
            padding: 10px;
        }

        .input-height-60 {
            height: 60px !important;
        }

        input#messageInput {
            border-radius: 40px;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }

        .sendbutton {
            border-radius: 40px;
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }

        .custom-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 40px;
            /* Apply rounded corners if desired */
        }

        .attachment {
            color: white;
            font-weight: 500;
            font-style: italic;
        }

        a.attachment:hover {
            color: #000000;
        }

        small#attached {
            font-size: 10px;
        }
    </style>
@endpush


@section('content')

    <div id="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" id="event" value="App\Events\MessageSent">

        <section id="registration-form" class="design-section">
            <div class="bg-primary bg-repeat-none bg-position-center bg-cover registration-form-image design-section-1"
                style="background-image: url('{{ asset('images/bg-design.png') }}');">
                <h2 style="padding-top:75px;" class="text-white text-center font-accent">Customer Portal</h2>
            </div>
            <div class="padding-section-medium registration-form-section design-section-2">
                <div class="customer-portal-section p-3 p-md-5 background-attorney">
                    <div class="customer-portal-sidebar-section">
                        @include('layouts.sidebar-customer')
                    </div>
                    <div class="customer-portal-content py-3">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="fw-bold font-28 mb-0 font-accent">Chat with
                                    {{ $receiver->getUserDetails->first_name . ' ' . $receiver->getUserDetails->last_name }}
                                </h2>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url()->previous() }}" class="btn btn-primary height-60 w-100 radius-10"> Go Back
                                </a>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card border-0">
                                        <div class="card-body" id="messagesbody">
                                            <div id="loadingIndicator" style="display:none;">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="offset-sm-4 col-sm-4 xy-center">
                                                            <h2 class="font-accent" style="margin-top: 50%;">Loading...</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container chat" id="messages">
                                            </div>
                                        </div>

                                        <div class="row send-message">
                                            <div class="col-md-12">
                                                <div class="input-group custom-shadow">
                                                    <input name="send_message" placeholder="Enter your message here"
                                                        id="messageInput" maxlength="250"
                                                        class="form-control form-control-lg height-60 input-height-60 input-border form-input form-input-medium"
                                                        type="text">

                                                    <input type="file" name="attachments" id="fileInput"
                                                        style="display: none;" onchange="handleFileChange(event)">

                                                    <button type="button" id="attachmentButton"
                                                        class="btn btn-secondary height-60">
                                                        <i class="fa-solid fa-paperclip"></i>
                                                        <small id="attached" style="display:none;">Attached</small>
                                                    </button>


                                                    <button type="button" id="sendButton"
                                                        class="btn btn-primary height-60 sendbutton">
                                                        <i class="fa-regular fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        function getReceiverUserId() {
            return {{ $receiver_id }}; // Replace with actual logic to get the receiver user's ID
        }

        function getSenderUserId() {
            return {{ auth()->user()->id }}; // Replace with actual logic to get the sender user's ID
        }

        function createRoomId(id1, id2) {
            const sortedIds = [id1, id2].sort((a, b) => a - b);
            return `room_${sortedIds[0]}_${sortedIds[1]}`;
        }

        document.addEventListener("DOMContentLoaded", function() {
            Pusher.logToConsole = true;

            var receiverId = getReceiverUserId();
            var senderId = getSenderUserId();
            fetchPreviousMessages(senderId, receiverId);

            var roomId = createRoomId(senderId, receiverId);

            var pusher = new Pusher('eaaf59b964fbd682eab8', {
                cluster: 'ap2',
                encrypted: true,
                authEndpoint: '{{ route('chat_pusherAuth') }}?user_id=' + senderId,
                auth: {
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'user_id': getSenderUserId(),
                    }
                }
            });

            pusher.connection.bind('state_change', function(states) {
                console.log('Pusher State Change:', states.current);
                if (states.current === 'disconnected') {
                    console.log('Pusher disconnected. Attempting to reconnect...');
                }
            });

            // Subscribe to a presence channel
            var channel = pusher.subscribe('presence-ChatAppForYBL.' + roomId);
            var event = $('#event').val();

            var lastMessageDate =
                '{{ $last_message_date->created_at ?? ' ' }}'; // Track the last message date outside the function

            // Listen for custom message events
            channel.bind(event, function(data) {
                console.log('New message received:', data);
                var messageContainer = document.getElementById('messages');

                update_unread_messages(receiverId,
                senderId); // If user is subscribed and receives a message, update unread

                var messageDate = moment(data.message.created_at);
                var currentDate = moment();

                // Check if the message date is different from the last message date
                if (!lastMessageDate || !messageDate.isSame(lastMessageDate, 'day')) {
                    lastMessageDate = messageDate;

                    var dateText = '';
                    if (messageDate.isSame(currentDate, 'day')) {
                        dateText = 'Today';
                    } else if (messageDate.isSame(currentDate.subtract(1, 'day'), 'day')) {
                        dateText = 'Yesterday';
                    } else {
                        dateText = messageDate.format('MMMM Do, YYYY');
                    }

                    // Add a date separator row
                    var dateElement = document.createElement('div');
                    dateElement.className = 'row mt-2';
                    dateElement.innerHTML = `
            <div class="col text-center">
                <small class="text-muted">${dateText}</small>
            </div>`;
                    messageContainer.appendChild(dateElement);
                }

                var messageElement = document.createElement('div');
                messageElement.innerHTML = `
        <div class="row mt-2 ${data.message.sender_id === getSenderUserId() ? 'chat-sender offset-sm-4 col-sm-8 ' : 'chat-receiver col-sm-8 '}">
            <div class="col-md-2 text-start mt-2 mb-2">
                <div class="icon-large">
                    <div class="text-start">
                        <img class="message-user-icon" src="${data.message.avatar}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="pt-2">
                    <p class="font-accent">
                        <p>${data.message.message}</p>
                        <p>
                        ${data.message.attachments ? `<a href="${data.message.attachments}" target="_blank" class="attachment"><i class="fa-solid fa-paperclip"></i> Attachments</a>` : ''}
                        </p>
                    </p>
                </div>
            </div>
            <div class="col-md-2 text-end d-flex align-items-end">
                <div class="row">
                    ${messageDate.format('h:mm A')}
                </div>
            </div>
        </div>`;

                messageContainer.appendChild(messageElement);
                scrollToBottom();
            });

            document.getElementById('sendButton').addEventListener('click', function() {
                var sendButton = document.getElementById('sendButton');
                sendButton.disabled = true; // Disable the button immediately
                sendButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'; // Show the loader
                sendMessage(senderId, receiverId,
                sendButton); // Pass the button to the sendMessage function
            });
        });


        function fetchPreviousMessages(senderId, receiverId) {
            document.getElementById('loadingIndicator').style.display = 'block';
            $.ajax({
                url: '{{ route('chat_getMessages') }}',
                method: 'POST',
                data: {
                    sender_id: senderId,
                    receiver_id: receiverId,
                },
                success: function(data) {
                    console.log(data.messages);
                    displayPreviousMessages(data.messages);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching previous messages:', error);
                },
                complete: function() {
                    // Hide the loading indicator after the request completes
                    document.getElementById('loadingIndicator').style.display = 'none';
                    //marking read messages
                    update_unread_messages(receiverId, senderId);
                }
            });
        }

        function displayPreviousMessages(messages) {
            var messageContainer = document.getElementById('messages');
            messageContainer.innerHTML = ''; // Clear any existing messages

            var lastMessageDate = null;

            messages.forEach(function(message) {
                var messageDate = moment(message.created_at);
                var currentDate = moment();

                // Check if the message date is different from the last message date
                if (!lastMessageDate || !messageDate.isSame(lastMessageDate, 'day')) {
                    lastMessageDate = messageDate;

                    var dateText = '';
                    if (messageDate.isSame(currentDate, 'day')) {
                        dateText = 'Today';
                    } else if (messageDate.isSame(currentDate.subtract(1, 'day'), 'day')) {
                        dateText = 'Yesterday';
                    } else {
                        dateText = messageDate.format('MMMM Do, YYYY');
                    }

                    // Add a date separator row
                    var dateElement = document.createElement('div');
                    dateElement.className = 'row mt-2';
                    dateElement.innerHTML = `
                <div class="col text-center">
                    <small class="text-muted">${dateText}</small>
                </div>`;
                    messageContainer.appendChild(dateElement);
                }

                var messageElement = document.createElement('div');
                messageElement.innerHTML = `
            <div class="row mt-2 ${message.sender_id === getSenderUserId() ? 'chat-sender offset-sm-4 col-sm-8 ' : 'chat-receiver col-sm-8 '}">
                <div class="col-md-2 text-start mt-2 mb-2">
                    <div class="icon-large">
                        <div class="text-start">
                            <img class="message-user-icon" src="${message.avatar}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="pt-2">
                        <p class="font-accent">
                            <p>${message.message}</p>
                            <p>
                            ${message.attachments ? `<a href="${message.attachments}" target="_blank" class="attachment"><i class="fa-solid fa-paperclip"></i> Attachments</a>` : ''}
                            </p>
                        </p>
                    </div>
                </div>
                <div class="col-md-2 text-end d-flex align-items-end">
                    <div class="row">
                        ${messageDate.format('h:mm A')}
                    </div>
                </div>
            </div>`;

                messageContainer.appendChild(messageElement);
            });

            // Scroll to the bottom of the message container after displaying all messages
            scrollToBottom();
        }




        function sendMessage(senderId, receiverId, sendButton) {
        var message = document.getElementById('messageInput').value;
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0]; // Get the selected file

        if (message.trim() === '' && !file) {
            Toast.fire({
                icon: 'error',
                title: 'Message cannot be empty or no file selected'
            });
            sendButton.disabled = false; // Re-enable the button if validation fails
            sendButton.innerHTML = '<i class="fa-regular fa-paper-plane"></i>'; // Restore the button icon
            return;
        }

        var formData = new FormData();
        formData.append('sender_id', senderId);
        formData.append('receiver_id', receiverId);
        formData.append('message', message);

        if (file) {
            formData.append('attachments', file); // Append the file to the FormData
        }

        $.ajax({
            url: '{{ route('chat_sendMessage') }}',
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(data) {
                document.getElementById('messageInput').value = '';
                fileInput.value = '';
                document.getElementById('attached').style.display = 'none';
                sendButton.disabled = false; // Re-enable the button on success
                sendButton.innerHTML =
                '<i class="fa-regular fa-paper-plane"></i>'; // Restore the button icon
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
                document.getElementById('attached').style.display = 'none';
                sendButton.disabled = false; // Re-enable the button on error
                sendButton.innerHTML =
                '<i class="fa-regular fa-paper-plane"></i>'; // Restore the button icon
            }
        });
    }


        function scrollToBottom() {
            var messageContainer = document.getElementById('messagesbody');
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        //to trigger send message on pressing of enter button
        document.getElementById('messageInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission if inside a form
                document.getElementById('sendButton').click(); // Simulate a click on the send button
            }
        });


        //for file attachment
        document.getElementById('attachmentButton').addEventListener('click', function() {
            document.getElementById('fileInput').click(); // Trigger the hidden file input
        });

        function handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                console.log('Selected file:', file);
                document.getElementById('attached').style.display = 'block';
                // You can handle the selected file here, such as uploading it or attaching it to a form submission
            } else {
                document.getElementById('attached').style.display = 'none';
            }
        }


        //to update unread messages
        function update_unread_messages(receiverId, senderId) {
            axios.post('{{ route('chat_markAsRead') }}/' + receiverId + '/' + senderId)
                .then(response => {
                    console.log('Messages marked as read');
                    // Refresh the contact list or do other UI updates
                })
                .catch(error => {
                    console.error('Error marking messages as read:', error);
                });
        }
    </script>
@endpush
