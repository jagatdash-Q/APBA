<script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/validation.js') }}"></script>
<script src="{{ asset('assets/frontend/js/validate_jquery.js') }}"></script>
<script src="{{ asset('assets/frontend/js/apba_script.js') }}"></script>
<script src="{{ asset('assets/frontend/owl_carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/frontend/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/sweetalert/sweetalert-dev.js') }}"></script>
<script src="{{ asset('assets/dashboard/sweetalert/sweetalert.min.js') }}"></script>
<div class="footer_canvas">
    <canvas id="footer_canvas" class="particles"></canvas>
</div>
<script src="{{ asset('assets/frontend/js/particles_common.js') }}"></script>
<script>
    const searchPage = () => {
        var search_text = $("#search_text").val();
        if (search_text == '') {
            return false;
        }
        $('#search_page').submit();
    }
</script>
<footer>
    <!-- Modal -->
    <div class="modal fade" id="captchaModal" tabindex="-1" role="dialog" aria-labelledby="captchaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('frontend.subscriber.email') }}" method="POST">
                    @csrf
                    <div class="modal-body" id="append_captcha">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="page_container">
        <div class="row footer_div">
            <div class="col-sm-4 pr-5 mob_hide">
                <p class="footer_heading">Secretariat, Asia-Pacific Biosafety Association
                </p>
                <p class="footer_desc">60 Paya Lebar Road, #07-54, Singapore 409051</p>
                <a class="footer_links" href="mailto:secreteriat@a-pba.org">secreteriat@a-pba.org</a>
            </div>
            <div class="col-sm-3 pl-5 mb-4">
                <p class="footer_heading">Sitemap</p>
                <a class="footer_links" href="{{ url('') }}">Home</a>
                <a class="footer_links" href="{{ route('frontend.about') }}">About A-PBA</a>
                <a class="footer_links" href="{{ route('frontend.our.team') }}">Our Team</a>
                <a class="footer_links" href="{{ route('frontend.resources') }}">Resources</a>
                <a class="footer_links" href="{{ route('frontend.news.events') }}">News & Events</a>
                <a class="footer_links" href="{{ route('frontend.membership') }}">Membership</a>
                <a class="footer_links" href="{{ route('frontend.contact') }}">Contact</a>
            </div>

            <div class="col-sm-5 pl-5">
                <p class="footer_heading">Subscribe for A-PBA Newsletter</p>
                <div class="newletter_form">
                    <input class="newletter_input" placeholder="Your email address" name="temp_subscriber_email"
                        id="temp_subscriber_email" type="email">
                    <button class="newletter_btn">
                        {{-- <img src="{{ asset('assets/frontend/images/right_arrow_gray.svg') }}" alt="..."> --}}
                        <span class="arrow_hover_link subscribe" onclick="_appendModal()">Subscribe</span>
                        <span class="arrow_hover_link subscribe_arrow"></span>
                    </button>
                    <span style="color: red;padding-left: 20px;" id="subscribe_error_msg"></span>
                </div>
                {{-- <p class="footer_heading my-4">Follow Us</p> --}}
                {{-- <a href="javascript:void(0)" style="padding: 10px 16px;" class="social_icons fa fa-facebook"></a>
                    <a href="javascript:void(0)" class="social_icons fa fa-instagram"></a>
                    <a href="javascript:void(0)" class="social_icons fa fa-linkedin"></a>
                    <a href="javascript:void(0)" class="social_icons fa fa-youtube-play"></a> --}}
                {{-- <a href="javascript:void(0)" target="_blank" class="social_icons_svg">
                        <img src="{{ asset('assets/frontend/images/facebook_blue.svg') }}" alt="...">
                    </a>
                    <a href="javascript:void(0)" target="_blank" class="social_icons_svg">
                        <img src="{{ asset('assets/frontend/images/instagram_blue.svg') }}" alt="...">
                    </a>
                    <a href="javascript:void(0)" target="_blank" class="social_icons_svg">
                        <img src="{{ asset('assets/frontend/images/linkedin_blue.svg') }}" alt="...">
                    </a>
                    <a href="javascript:void(0)" target="_blank" class="social_icons_svg">
                        <img src="{{ asset('assets/frontend/images/youtube_blue.svg') }}" alt="...">
                    </a> --}}
            </div>
        </div>
        <hr style="border-top: 1px solid #B5B5B5; margin:0rem;">
        <span class="footer_copyright">Copyright &copy; 2023 Asia Pacific Biosafety
            Association.
            All
            rights reserved.</span>
    </div>
</footer>


<span id="move-to-top">
    <img src="{{ asset('assets/frontend/images/up_arrow.png') }}" alt="Contact Icon">
</span>

</div>


<style>
    .error_block {
        position: fixed;
        top: 120px;
        left: 0;
        width: 100%;
        margin: 0 auto;
        z-index: 999;
    }

    .top_adjust {
        top: 70px !important;
    }

    .top_adjust {}

    @media only screen and (max-width: 768px) {
        .error_block {
            top: 64px;
        }

    }
</style>

<script>
    $(document).ready(function() {
        if ((screen.width > 768)) {
            $(window).scroll(function() {
                if ($(window).scrollTop() >= 100) {
                    $('.error_block').addClass('top_adjust');
                } else {
                    $('.error_block').removeClass('top_adjust');
                }
            });
        }

        if ((screen.width < 576)) {

        }
    });
    $('#reload').click(function() {
        $.ajax({
            type: 'GET',
            url: "{{ route('captcha.reload') }}",
            success: function(data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

    function _appendModal() {
        $('#append_captcha').html('');
        $('#subscribe_error_msg').html('');
        var validmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var temp_subscriber_email = document.getElementById('temp_subscriber_email').value;
        if (temp_subscriber_email == '') {
            $('#subscribe_error_msg').html('This field is required.');
            return false;
        } else if (!temp_subscriber_email.match(validmail)) {
            $('#subscribe_error_msg').html('Please enter a valid mail id.');
            return false;
        } else {
            $('#subscribe_error_msg').html('');
        }

        var FieldAppendHTML = ``;
        FieldAppendHTML = `<div class="row">
                <div class="col-sm-12 mt-4 mb-4">
                    <div class="footer_captcha">
                        <span>{!! captcha_img() !!}</span>
                    </div>
                </div>
                <div class="col-sm-12"> 
                    <input type="hidden" name="subscriber_email" id="subscriber_email" value='${temp_subscriber_email}'>
                    <input id="footer_captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha"
                        required>
                </div>
            </div>`;

        $('#append_captcha').append(FieldAppendHTML);
        $('#captchaModal').modal('show');
    }
</script>
</body>

</html>
