<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planet Games</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        function validate_LoginForm() {

            var msisdn = document.getElementById('msisdn').value;
            msisdn = msisdn.replace(/^0+/,'');
            msisdn = msisdn.replace(/^\+/,'');
            msisdn = msisdn.replace(/^971/,'');


            if ((msisdn == null || msisdn == "")) {
                alert("Please enter mobile number");
                return false;
            }
            else if (!validatePhone(msisdn)) {
                alert("Please Enter digits only");
                return false;
            } else {
                window.location.href = "pin.html";
                return true;
            }

        }
        function validatePhone(txtPhone) {
            var filter = /^[0-9-+]+$/;
            return filter.test(txtPhone)
        }
    </script>

</head>
<body>
    <input type="text" class="hiddenInput" inputmode="numeric" maxlength="9">
    <div class="wrapper">
        <div class="container">
<!--        <div class="logo">-->
<!--            <img src="images/logo.svg" alt="logo">-->
<!--        </div>-->
        </div>
<!--    <div class="languages">-->
<!--        <div class="container">-->
<!--            <div class="multi-language">-->
<!--                <ul class="list">-->
<!--                    <div class="only-ar">-->
<!--                        <li class="language-option optionEn"><img src="images/triangle1.png">English</li>-->
<!--                    </div>-->
<!--                    <div class="only-en">-->
<!--                        <li class="language-option optionAr">العربية <img src="images/triangle1.png"></li>-->
<!--                    </div>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="top">
        <div class="container">
            <img class="main-img" src="images/main-image.png?v=1.0">
        </div>
    </div>
    <div class="phone-form">
        <div class="container">
    <div class="phone-title">

            <h3 class="only-en">Enter your Phone Number</h3>


    </div>



            <form method="post" id="subConfirm">
<!--                <span class="error"></span>-->
                <div class="MSISDNclass">
                    <div class="inputWrap" dir="ltr">
                        <img class="flag" src="images/flag%20.png">
                        <div class="region-code">+971</div>
                        <div class="inputBlock">
                            <input type="text" class="mainInput" placeholder="XXXXXXXXX" name="phone" id="msisdn" maxlength="18" inputmode="tel" required>
                            <div class="cursor"></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="lang" value="en">
                <button id="confirm" class="buttons" type="submit" name="confirm">
<!--                    <span>Subscribe or إشترك</span>-->
                    <span class="only-en">CONTINUE</span>
                    <span class="only-ar">إشترك</span>
                </button>
                <p class="error"></p>
            </form>



        </div>
    </div>
    <div class="footer">
<!--                <p class="descr" dir="ltr">Plunge into the exciting world of games with Planet Games!</p>-->
<!--        <button class="cancel" name="cancel" id="exitButton" onclick="window.open('https://games-universe.online/','_self')">-->
<!--        <button class="cancel" name="cancel" id="exitButton" onclick="window.open('https://www.google.com/','_self')">-->
<!--            <span class="only-en">EXIT</span>-->
<!--            <span class="only-ar">خروج</span>-->
<!--        </button>-->

            <div id="disclaimer" class="only-en">
                <p>
                    By Subscribing to this Service you have agreed to the following terms and conditions.Terms and Conditions:Free for 24 hours then, you will be charged AED 11/Week automatically.No commitment, you can cancel any time by sending C PLNG to 1111.For support, please contact: support@kncee.comFree trial applicable only for first time subscriber.Enjoy your Free trial for 24 hours.For complete T’s &C’s click <a href="https://aeke.planet-games.today/terms">here</a>
                </p>
            </div>
            <div id="disclaimer" class="only-ar">
                <p>من خلال النقر على زر الاشتراك أعلاه ، سوف توافق على الشروط والأحكام التالية
                    الشروط والأحكام
                    مجانًا لمدة 24 ساعة بعد ذلك ، سيتم تحصيل  11 درهمًا إماراتيًا / أسبوعًا تلقائيًا.
                    لا يوجد التزام ، يمكنك الإلغاء في أي وقت بإرسال C PLNG إلى 1111.
                    للحصول على الدعم ، يرجى الاتصال  support@kncee.com
                    الفترة التجريبية المجانية تنطبق فقط على المشتركين لأول مرة. استمتع بالفترة التجريبية المجانية لمدة 24 ساعة.
                    للحصول على الشروط والأحكام الكاملة ، انقر هنا</p>
            </div>
        </div>
    </div>

    <script>

        language();

        function language() {

            $('.only-en').show();
            $('.only-ar').hide();


            if (document.cookie == null) {
                $('.only-en').show();
                console.log('null');
            }


            $('.optionEn').click(function() {
                document.getElementsByTagName("html")[0].dir = "ltr";
                document.getElementsByTagName("html")[0].lang = "en";
                $('.only-en').show();
                $('.only-ar').hide();
                console.log('en');
                document.cookie = "lang=en";

            })

            $('.optionAr').click(function() {
                document.getElementsByTagName("html")[0].dir = "rtl";
                document.getElementsByTagName("html")[0].lang = "ar";
                $('.only-en').hide();
                $('.only-ar').show();
                console.log('ar');
                document.cookie = "lang=ar";
            })
        }


        // -----




        let ua = navigator.userAgent.toLowerCase();
        let isAndroid = ua.indexOf("android") > -1;

        function wrapperHeight() {
            if (isAndroid) {
                setTimeout(() => {
                    document.querySelector('.wrapper').style.height = document.querySelector('.wrapper').offsetHeight + 'px';
                }, 100);
            }
        }

        function scrollToInput() {
            let hiddenInput = document.querySelector('.hiddenInput');

            if (!isAndroid) {
                hiddenInput.onfocus = () => {
                    if (window.orientation === 90 || window.orientation === -90) {
                        window.scroll(0, document.querySelector('header').offsetHeight + 20);
                    }
                }
            }
        }

        function inputFocus() {
            let hiddenInput = document.querySelector('.hiddenInput');
            let input = document.querySelector('.mainInput');
            let cursor = document.querySelector('.cursor');

            let inputPlaceholder = input.getAttribute('placeholder');

            document.querySelector('.inputBlock').onclick = () => {
                hiddenInput.focus();
                input.setAttribute('placeholder', '');
                cursor.style.display = 'block';
            }

            hiddenInput.oninput = () => {
                input.value = hiddenInput.value;

                if (input.value === '') {
                    cursor.style.display = 'block';
                } else {
                    cursor.style.display = 'none';
                }
            }

            hiddenInput.onblur = () => {
                cursor.style.display = 'none';
                input.setAttribute('placeholder', inputPlaceholder);
            }
        }

        window.onload = () => {
            wrapperHeight()
            inputFocus();
            scrollToInput()
            // footerPosition();
        }

        window.onresize = () => {
            // footerPosition();
        }

        window.onorientationchange = () => {
            if (isAndroid) {
                location.reload();
            }
        }




    </script>
    <script>
        document.onsubmit = () => {
            document.querySelector('button[type=submit]').setAttribute('disabled', 'disabled');
        }

        let input = document.querySelector('.hiddenInput');
        input.oninput = () => {
            input.value = input.value.replace(/[^0-9]/, '');
            if (input.value.substr(0, 2) === '05') input.setAttribute('maxlength', '10');
            else if (input.value.substr(0, 3) === '971') input.setAttribute('maxlength', '12');
            else input.setAttribute('maxlength', '9');
        }
    </script>
    <script src="js/script.js"></script>
</body>
</html>