</div>
</div>

</main>
@include('dashboard.templates.session')
@include('css-js-loaders.dash-js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    $('#clear-cache-btn').click(function() {
        // Disable the button and change text to indicate processing
        var button = $(this);
        button.prop('disabled', true).text('Clearing Cache...');

        // Remove any existing SweetAlert loading spinner if visible
        Swal.close();

        // Send AJAX request to clear cache
        $.ajax({
            url: '{{ route('clear.cache') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Check if there are success or error messages from the controller
                if (response.status === 'success') {
                    // Add alert div with success classes and prepend it to the top
                    var alertDiv = $('<div class="alert alert-success marb-20">' + response.messages
                        .join('<br>') + '</div>');
                    $('body').prepend(alertDiv); // Prepend to the top of the body

                    // Change button to success state
                    button.addClass('btn-success').removeClass('btn-primary').text(
                        'Cache Cleared!');

                    // Automatically hide alert after 5 seconds
                    setTimeout(function() {
                        alertDiv.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000); // Adjust the time if needed

                    // Reload the page instantly after cache is cleared
                    location.reload(); // Instantly reload the page
                } else {
                    // Add alert div with error classes and prepend it to the top
                    var alertDiv = $('<div class="alert alert-danger marb-20">' + response.messages
                        .join('<br>') + '</div>');
                    $('body').prepend(alertDiv); // Prepend to the top of the body

                    // Change button to error state
                    button.addClass('btn-danger').removeClass('btn-primary').text(
                        'Error Clearing Cache');

                    // Automatically hide alert after 5 seconds
                    setTimeout(function() {
                        alertDiv.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000); // Adjust the time if needed

                    // Re-enable the button after the error
                    setTimeout(function() {
                        button.prop('disabled', false).text('Clear Cache');
                    }, 2000);
                }
            },
            error: function() {
                // Change button to error state
                button.addClass('btn-danger').removeClass('btn-primary').text(
                    'Error Clearing Cache');

                // Automatically hide alert after 5 seconds
                setTimeout(function() {
                    alertDiv.fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000); // Adjust the time if needed

                // Re-enable the button after the error
                setTimeout(function() {
                    button.prop('disabled', false).text('Clear Cache');
                }, 2000);
            }
        });
    });
</script>


</body>

</html>
