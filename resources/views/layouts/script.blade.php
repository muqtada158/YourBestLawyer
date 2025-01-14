    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@7.0.9/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    {{-- file pond js--}}
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>

        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Initialize FilePond for image picker
        const imageInputs = document.querySelectorAll('.image-picker');
        imageInputs.forEach(input => {
            FilePond.create(input, {
                storeAsFile: true,
                acceptedFileTypes: ['image/*'],
            });
        });

        // Initialize FilePond for document picker
        const docInputs = document.querySelectorAll('.doc-picker');
        docInputs.forEach(input => {
            FilePond.create(input, {
                storeAsFile: true,
                acceptedFileTypes: [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.oasis.opendocument.text',
                    'application/vnd.oasis.opendocument.spreadsheet'
                ],
            });
        });

        // Hide FilePond credits
        $('.filepond--credits').hide();

    </script>

    <script src="{{asset('js/application-form.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.querySelector(".sign");
        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        $('#signature-trash').click(function(e) {
            e.preventDefault();
            signaturePad.clear();
            $('#hidden-signature-data').val('');
        });

        $('#confirm-signature').click(function(e) {
            e.preventDefault();
            if ($('#confirm-signature').text() === 'Confirm') {
                // Disable signature area
                signaturePad.off();
                var signatureData = signaturePad.toDataURL();
                $('#hidden-signature-data').val(signatureData);
                $('#confirm-signature').text('Edit').removeClass('bg-primary').addClass('bg-secondary');
            } else {
                // Enable signature area
                signaturePad.on();
                signaturePad.clear();
                $('#hidden-signature-data').val('');
                $('#confirm-signature').text('Edit').removeClass('bg-secondary').addClass('bg-primary');
                $('#confirm-signature').text('Confirm');
            }
        });

        $('#save-signature').click(function() {
            var signatureData = signaturePad.toDataURL();
            $('#hidden-signature-data').val(signatureData);
            $('#signature-form').submit(); // Assuming your form has the ID 'signature-form'
        });
    </script>

    <script>
        function AjaxRequest(url,data)
        {
            var res;
            $.ajax({
                url: url,
                data: data,
                async: false,
                error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
                },
                dataType: 'json',
                success: function(data) {
                res= data;

                },
                type: 'POST'
                });

            return res;
        }
    </script>

    <script>
        function formatPhoneNumber(input) {
            // Remove all non-digit characters
            var cleaned = input.replace(/\D/g, '');

            // Limit the input to 10 digits
            var formattedNumber = cleaned.slice(0, 10);

            // Format the number as (XXX) XXX-XXXX
            var match = formattedNumber.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
            if (match) {
                formattedNumber = '';
                if (match[1]) {
                    formattedNumber += '(' + match[1];
                }
                if (match[2]) {
                    formattedNumber += ') ' + match[2];
                }
                if (match[3]) {
                    formattedNumber += '-' + match[3];
                }
            }

            return formattedNumber;
        }

            // Attach event listener to input fields with class 'phone-number'
            $('.phone-number').on('input', function() {
            // Get the input value
            var inputValue = $(this).val();

            // Format the input value
            var formattedValue = formatPhoneNumber(inputValue);

            // Update the input value with the formatted number
            $(this).val(formattedValue);
        });

    </script>

    {{-- sweet alert starts--}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    @if (Session::has('message'))
        let type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
            Toast.fire({
                    icon: 'info',
                    title: '{{ Session::get('message') }}'
                })
                break;
            case 'success':
            Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('message') }}'
                })
                break;
            case 'warning':
            Toast.fire({
                    icon: 'warning',
                    title: '{{ Session::get('message') }}'
                })
                break;
            case 'error':
            Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('message') }}'
                })
                break;
            case 'modal':
                Swal.fire('{{ Session::get('message') }}');
                break;
            default:
                break;
        }
    @endif
    </script>
    {{-- sweet alert ends --}}

    <script>
        function checkUserAndRedirect() {
            var user = @json(auth()->user());

            if(user && user.user_type == 'customer'){

                if (user && user.restricted_steps > 19) {
                    // Redirect to somewhere if the user exists and restricted_steps > 19
                    window.location.href = '{{route("customer_add_application")}}';
                } else if (user && user.restricted_steps < 19) {
                    switch (user.restricted_steps) {
                        case null:
                            // Redirect if restricted_steps is null
                            window.location.href = '{{ route("customer_update_profile") }}';
                            break;
                        case 9:
                            // Redirect if restricted_steps is 9
                            window.location.href = '{{ route("customer_application_form") }}';
                            break;
                        case 10:
                            // Redirect if restricted_steps is 10
                            window.location.href = '{{ route("customer_payment_bid_form") }}';
                            break;
                        case 11:
                            // Redirect if restricted_steps is 11
                            window.location.href = '{{ route("customer_payment_plans") }}';
                            break;
                        case 12:
                            // Redirect if restricted_steps is 12
                            window.location.href = '{{ route("customer_preview") }}';
                            break;
                        case 13:
                            // Redirect if restricted_steps is 13
                            window.location.href = '{{ route("customer_thankyou") }}';
                            break;
                        case 14:
                            // Redirect if restricted_steps is 13
                            window.location.href = '{{ route("customer_thankyou") }}';
                            break;
                        case 17:
                            // Redirect if restricted_steps is 18
                            window.location.href = '{{ route("customer_contract_thank_you") }}';
                            break;
                        case 18:
                            // Redirect if restricted_steps is 18
                            window.location.href = '{{ route("customer_contract_thank_you") }}';
                            break;
                        default:
                            // Redirect to dashboard if no specific step matches
                            window.location.href = '{{ route("customer_dashboard") }}';
                            break;
                    }
                } else {
                    // Redirect to another location if the user doesn't exist
                    window.location.href = '{{route("register_view",["type=customer"])}}';
                }
            }else if (user && user.user_type == 'attorney'){
                if(user.restricted_steps > 12)
                {
                    window.location.href = '{{ route("attorney_dashboard") }}';
                }
            }else{
                window.location.href = '{{route("register_view",["type=customer"])}}';
            }
        }

        function deleteCookie(name) {
            document.cookie = name + "=; Max-Age=-99999999; path=/";
        }

    </script>

    <script>
        // for loader
        function showLoader() {
            document.getElementById('loader-overlay').style.display = 'flex';
        }

        // Function to hide the loader
        function hideLoader() {
            document.getElementById('loader-overlay').style.display = 'none';
        }
    </script>


    @stack('js')
