</div>
</div>
</div>
<footer
    class="footer-section section background-primary position-relative z-index-1 color-white border-solid border-top-1px border-color-secondary border-bottom-0px border-left-0px border-right-0px">
    <div class="container padt-10 padb-10 flex row center text-center">
        <p style="font-size: 14px">Developed &amp; Maintained by: <a href="https://forayeji.com" target="_blank"
                class="color-success">Forayeji
                Creative
                Agency</a></p>
    </div>
</footer>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css">
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script>
    // Initialize Pickr for Primary Color
    const primaryColorPicker = Pickr.create({
        el: '#primary-color-picker',
        theme: 'classic', // or 'monolith', or 'nano'
        default: "{{ old('primary_color', isset($settings) ? $settings->primary_color : '#000325') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    primaryColorPicker.on('save', (color, instance) => {
        document.getElementById('primary_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Secondary Color
    const secondaryColorPicker = Pickr.create({
        el: '#secondary-color-picker',
        theme: 'classic',
        default: "{{ old('secondary_color', isset($settings) ? $settings->secondary_color : '#3361d9') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    secondaryColorPicker.on('save', (color, instance) => {
        document.getElementById('secondary_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Paragraph Color
    const paragraphColorPicker = Pickr.create({
        el: '#paragraph-color-picker',
        theme: 'classic',
        default: "{{ old('paragraph_color', isset($settings) ? $settings->paragraph_color : '#333333') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    paragraphColorPicker.on('save', (color, instance) => {
        document.getElementById('paragraph_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Danger Color
    const dangerColorPicker = Pickr.create({
        el: '#danger-color-picker',
        theme: 'classic',
        default: "{{ old('danger_color', isset($settings) ? $settings->danger_color : '#e74c3c') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    dangerColorPicker.on('save', (color, instance) => {
        document.getElementById('danger_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Alert Color
    const alertColorPicker = Pickr.create({
        el: '#alert-color-picker',
        theme: 'classic',
        default: "{{ old('alert_color', isset($settings) ? $settings->alert_color : '#f39c12') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    alertColorPicker.on('save', (color, instance) => {
        document.getElementById('alert_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Success Color
    const successColorPicker = Pickr.create({
        el: '#success-color-picker',
        theme: 'classic',
        default: "{{ old('success_color', isset($settings) ? $settings->success_color : '#4fff00') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    successColorPicker.on('save', (color, instance) => {
        document.getElementById('success_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Warning Color
    const warningColorPicker = Pickr.create({
        el: '#warning-color-picker',
        theme: 'classic',
        default: "{{ old('warning_color', isset($settings) ? $settings->warning_color : '#f39c12') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    warningColorPicker.on('save', (color, instance) => {
        document.getElementById('warning_color').value = color.toHEXA().toString();
    });

    // Initialize Pickr for Background Gray Color
    const backgroundGrayColorPicker = Pickr.create({
        el: '#background-gray-color-picker',
        theme: 'classic',
        default: "{{ old('background_gray', isset($settings) ? $settings->background_gray : '#f2f2f2') }}",
        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                input: true,
                save: true
            }
        }
    });

    // Sync Pickr value to hidden input
    backgroundGrayColorPicker.on('save', (color, instance) => {
        document.getElementById('background_gray').value = color.toHEXA().toString();
    });
</script>


</body>

</html>
