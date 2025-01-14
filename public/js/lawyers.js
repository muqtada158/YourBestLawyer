jQuery(document).ready(function(){


    // Multi Step Form
    var currentStep = 1;

    // Show step function remains the same
    function showStep(stepNumber, previousStep) {
        $('.step').slideUp();
        $('#step-' + stepNumber).slideDown();
        $('#step-' + stepNumber + "-check").addClass('active');

        if(stepNumber === 1){
          $('.btn-prev').hide();
          $('.submit-buttons').addClass('justify-content-end');
          $('.submit-buttons').removeClass('justify-content-between');
        } else {
          $('.btn-prev').show();
          $('.submit-buttons').removeClass('justify-content-end');
          $('.submit-buttons').addClass('justify-content-between');
        }

        $(".step-check").removeClass('active');

        for (var i = stepNumber; i > 0; i--) {
          $('#step-' + i + "-check").addClass('active');
        }
    }

    // Call the function to display the initial step
    showStep(currentStep);

    // Add validation for specific fields
    function validateStep(stepNumber) {
        let isValid = true;

        // Clear any previous error messages
        $('.form-error').remove();

        if (stepNumber === 1) {
            // Validate username (only letters and spaces)
             // Validate username (only letters and spaces, required)
        let username = $('input[name="username"]').val();
        if (username === '') {
            $('input[name="username"]').after('<span class="form-error text-danger">Username is required</span>');
            isValid = false;
        } else if (!/^[a-zA-Z\s]+$/.test(username)) {
            $('input[name="username"]').after('<span class="form-error text-danger">Only letters allowed in the username</span>');
            isValid = false;
        }

        // Validate 'Solo Practitioner or Law Firm' (only letters and spaces, required)
        let practitioner = $('input[name="solo_practitioner_on_law_firm"]').val();
        if (practitioner === '') {
            $('input[name="solo_practitioner_on_law_firm"]').after('<span class="form-error text-danger">This field is required</span>');
            isValid = false;
        } else if (!/^[a-zA-Z\s]+$/.test(practitioner)) {
            $('input[name="solo_practitioner_on_law_firm"]').after('<span class="form-error text-danger">Only letters allowed for this field</span>');
            isValid = false;
        }

        // Validate 'Name of Law Firm' (only letters and spaces, required)
        let lawFirm = $('input[name="name_of_law_firm"]').val();
        if (lawFirm === '') {
            $('input[name="name_of_law_firm"]').after('<span class="form-error text-danger">Law firm name is required</span>');
            isValid = false;
        } else if (!/^[a-zA-Z\s]+$/.test(lawFirm)) {
            $('input[name="name_of_law_firm"]').after('<span class="form-error text-danger">Only letters allowed in the law firm name</span>');
            isValid = false;
        }

        // Validate 'Position' (only letters and spaces, required)
        let position = $('input[name="position"]').val();
        if (position === '') {
            $('input[name="position"]').after('<span class="form-error text-danger">Position is required</span>');
            isValid = false;
        } else if (!/^[a-zA-Z\s]+$/.test(position)) {
            $('input[name="position"]').after('<span class="form-error text-danger">Only letters allowed in the position</span>');
            isValid = false;
        }

        // Validate email (required and valid format)
        let email = $('input[name="email"]').val();
        if (email === '') {
            $('input[name="email"]').after('<span class="form-error text-danger">Email is required</span>');
            isValid = false;
        } else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
            $('input[name="email"]').after('<span class="form-error text-danger">Please enter a valid email</span>');
            isValid = false;
        }

            // Validate phone (only numbers, 10 digits)
            let phone = $('input[placeholder="Phone"]').val();
            if (phone === '') {
                $('input[placeholder="Phone"]').after('<span class="form-error text-danger">Phone number is required</span>');
                isValid = false;
            }
        }

        // Validation for other steps can be added here (step 2, step 3, etc.)
        // For example, check if video watched in step 2, etc.

        return isValid;
    }

    // Handle next button click
    $('#registration-form .btn-next').click(function (e) {
        e.preventDefault();  // Prevent default form submission

        if (validateStep(currentStep)) {
            if (currentStep < 3) {
                previousStep = currentStep;
                currentStep++;
                showStep(currentStep, previousStep);
            }
        }
    });

    // Handle previous button click
    $('#registration-form .btn-prev').click(function () {
        if (currentStep > 1) {
            previousStep = currentStep;
            currentStep--;
            showStep(currentStep, previousStep);
        }
    });



    const repeat = true;
    const noArrows = false;
    const noBullets = false;

    const container = document.querySelector('.slider-container');
    var slide = document.querySelectorAll('.slider-single');
    var slideTotal = slide.length - 1;
    var slideCurrent = -1;

    function initBullets() {
        if (noBullets) {
            return;
        }
        const bulletContainer = document.createElement('div');
        bulletContainer.classList.add('bullet-container')
        slide.forEach((elem, i) => {
            const bullet = document.createElement('div');
            bullet.classList.add('bullet')
            bullet.id = `bullet-index-${i}`
            bullet.addEventListener('click', () => {
                goToIndexSlide(i);
            })
            bulletContainer.appendChild(bullet);
            elem.classList.add('proactivede');
        })
        container.appendChild(bulletContainer);
    }

    function initArrows() {
        if (noArrows) {
            return;
        }
        const leftArrow = document.createElement('a')
        const iLeft = document.createElement('i');
        iLeft.classList.add('fa')
        iLeft.classList.add('fa-arrow-left')
        leftArrow.classList.add('slider-left')
        leftArrow.appendChild(iLeft)
        leftArrow.addEventListener('click', () => {
            slideLeft();
        })
        const rightArrow = document.createElement('a')
        const iRight = document.createElement('i');
        iRight.classList.add('fa')
        iRight.classList.add('fa-arrow-right')
        rightArrow.classList.add('slider-right')
        rightArrow.appendChild(iRight)
        rightArrow.addEventListener('click', () => {
            slideRight();
        })
        container.appendChild(leftArrow);
        container.appendChild(rightArrow);
    }

    function slideInitial() {
        initBullets();
        initArrows();
        setTimeout(function () {
            slideRight();
        }, 500);
    }

    function updateBullet() {
        if (!noBullets) {
            document.querySelector('.bullet-container').querySelectorAll('.bullet').forEach((elem, i) => {
                elem.classList.remove('active');
                if (i === slideCurrent) {
                    elem.classList.add('active');
                }
            })
        }
        checkRepeat();
    }

    function checkRepeat() {
        if (!repeat) {
            if (slideCurrent === slide.length - 1) {
                slide[0].classList.add('not-visible');
                slide[slide.length - 1].classList.remove('not-visible');
                if (!noArrows) {
                    document.querySelector('.slider-right').classList.add('not-visible')
                    document.querySelector('.slider-left').classList.remove('not-visible')
                }
            }
            else if (slideCurrent === 0) {
                slide[slide.length - 1].classList.add('not-visible');
                slide[0].classList.remove('not-visible');
                if (!noArrows) {
                    document.querySelector('.slider-left').classList.add('not-visible')
                    document.querySelector('.slider-right').classList.remove('not-visible')
                }
            } else {
                slide[slide.length - 1].classList.remove('not-visible');
                slide[0].classList.remove('not-visible');
                if (!noArrows) {
                    document.querySelector('.slider-left').classList.remove('not-visible')
                    document.querySelector('.slider-right').classList.remove('not-visible')
                }
            }
        }
    }

    function slideRight() {
        if (slideCurrent < slideTotal) {
            slideCurrent++;
        } else {
            slideCurrent = 0;
        }

        if (slideCurrent > 0) {
            var preactiveSlide = slide[slideCurrent - 1];
        } else {
            var preactiveSlide = slide[slideTotal];
        }
        var activeSlide = slide[slideCurrent];
        if (slideCurrent < slideTotal) {
            var proactiveSlide = slide[slideCurrent + 1];
        } else {
            var proactiveSlide = slide[0];

        }

        slide.forEach((elem) => {
            var thisSlide = elem;
            if (thisSlide.classList.contains('preactivede')) {
                thisSlide.classList.remove('preactivede');
                thisSlide.classList.remove('preactive');
                thisSlide.classList.remove('active');
                thisSlide.classList.remove('proactive');
                thisSlide.classList.add('proactivede');
            }
            if (thisSlide.classList.contains('preactive')) {
                thisSlide.classList.remove('preactive');
                thisSlide.classList.remove('active');
                thisSlide.classList.remove('proactive');
                thisSlide.classList.remove('proactivede');
                thisSlide.classList.add('preactivede');
            }
        });
        preactiveSlide.classList.remove('preactivede');
        preactiveSlide.classList.remove('active');
        preactiveSlide.classList.remove('proactive');
        preactiveSlide.classList.remove('proactivede');
        preactiveSlide.classList.add('preactive');

        activeSlide.classList.remove('preactivede');
        activeSlide.classList.remove('preactive');
        activeSlide.classList.remove('proactive');
        activeSlide.classList.remove('proactivede');
        activeSlide.classList.add('active');

        proactiveSlide.classList.remove('preactivede');
        proactiveSlide.classList.remove('preactive');
        proactiveSlide.classList.remove('active');
        proactiveSlide.classList.remove('proactivede');
        proactiveSlide.classList.add('proactive');

        updateBullet();
    }

    function slideLeft() {
        if (slideCurrent > 0) {
            slideCurrent--;
        } else {
            slideCurrent = slideTotal;
        }

        if (slideCurrent < slideTotal) {
            var proactiveSlide = slide[slideCurrent + 1];
        } else {
            var proactiveSlide = slide[0];
        }
        var activeSlide = slide[slideCurrent];
        if (slideCurrent > 0) {
            var preactiveSlide = slide[slideCurrent - 1];
        } else {
            var preactiveSlide = slide[slideTotal];
        }
        slide.forEach((elem) => {
            var thisSlide = elem;
            if (thisSlide.classList.contains('proactive')) {
                thisSlide.classList.remove('preactivede');
                thisSlide.classList.remove('preactive');
                thisSlide.classList.remove('active');
                thisSlide.classList.remove('proactive');
                thisSlide.classList.add('proactivede');
            }
            if (thisSlide.classList.contains('proactivede')) {
                thisSlide.classList.remove('preactive');
                thisSlide.classList.remove('active');
                thisSlide.classList.remove('proactive');
                thisSlide.classList.remove('proactivede');
                thisSlide.classList.add('preactivede');
            }
        });

        preactiveSlide.classList.remove('preactivede');
        preactiveSlide.classList.remove('active');
        preactiveSlide.classList.remove('proactive');
        preactiveSlide.classList.remove('proactivede');
        preactiveSlide.classList.add('preactive');

        activeSlide.classList.remove('preactivede');
        activeSlide.classList.remove('preactive');
        activeSlide.classList.remove('proactive');
        activeSlide.classList.remove('proactivede');
        activeSlide.classList.add('active');

        proactiveSlide.classList.remove('preactivede');
        proactiveSlide.classList.remove('preactive');
        proactiveSlide.classList.remove('active');
        proactiveSlide.classList.remove('proactivede');
        proactiveSlide.classList.add('proactive');

        updateBullet();
    }

    function goToIndexSlide(index) {
        const sliding = (slideCurrent > index) ? () => slideRight() : () => slideLeft();
        while (slideCurrent !== index) {
            sliding();
        }
    }

    slideInitial();


    const testimonial_text_swiper = new Swiper('.swiper.slider-videos', {
        slidesPerView:4,
        breakpoints: {
            500: {
              slidesPerView: 1,
              spaceBetween: 0
            },
            1280: {
              slidesPerView: 2,
              spaceBetween: 20
            },
            1440:{
                slidesPerView: 4,
                spaceBetween: 20
            }
        },
        loop: true,
        navigation: {
          nextEl: '.swiper.slider-videos .swiper-button-next',
          prevEl: '.swiper.slider-videos .swiper-button-prev',
        },
      });

});
