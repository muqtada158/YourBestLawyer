$(document).ready(function () {
    var currentStep = 1;
    var totalSteps = 5;

    $('.next-button').on('click', function () {
        if (validateStep(currentStep)) {
            hideStep(currentStep);
            currentStep++;
            showStep(currentStep);


            $('html, body').animate({
                scrollTop: $("#multi-step-form").offset().top
            }, 400);
        }
    });

    $('.prev-button').on('click', function () {
        hideStep(currentStep);
        currentStep--;
        showStep(currentStep);

        $('html, body').animate({
            scrollTop: $("#multi-step-form").offset().top
        }, 400);
    });

    $('#multi-step-form').on('submit', function (e) {
        e.preventDefault();
        // Final validation before submitting the form
        if (validateStep(currentStep)) {
            alert('Form submitted successfully!');
        }
    });

    function showStep(step) {
        $('#step-' + step).fadeIn();
    }

    function hideStep(step) {
        $('#step-' + step).hide();
    }

    function validateStep(step) {
        var isValid = true;
        // Simple validation, you can add more complex validation logic
        $('#step-' + step + ' input[required], #step' + step + ' textarea[required]').each(function () {
            if ($(this).val() === '') {
                isValid = false;
                alert('Please fill in all required fields.');
                return false; // Exit the loop if one field is empty
            }
        });
        return isValid;
    }
});
