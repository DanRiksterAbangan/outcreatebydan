<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TechHive - Job Portal Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	
    <!-- Template Stylesheet -->
    <link rel="stylesheet" ="{{ asset('assets/css/style2.css') }}">
</head>
<body data-instant-intensity="mousedown">
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0" style="height: 80px;">
    <!-- Branding -->
	<a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center text-center py-0 px-3 px-lg-5">
		<h1 class="m-0 text-primary fw-semibold" style="font-size: 1.5rem;">
			<i class="fas fa-briefcase me-1" style="font-size: 1.2rem;"></i>TechHive
		</h1>
	</a>
	

    <!-- Toggler for Mobile -->
    <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" 
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <!-- Navigation Links -->
            <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active fw-bold text-primary' : '' }}">
                <i class="fas fa-home me-2"></i>Home
            </a>
            <a href="{{ route('jobs') }}" class="nav-item nav-link {{ request()->routeIs('jobs') ? 'active fw-bold text-primary' : '' }}">
                <i class="fas fa-briefcase me-2"></i>Jobs
            </a>
            <a href="{{ route('about') }}" class="nav-item nav-link">
                <i class="fas fa-info-circle me-2"></i>About
            </a>
            <a href="contact.html" class="nav-item nav-link">
                <i class="fas fa-envelope me-2"></i>Contact
            </a>
        </div>
    
        <!-- Authentication Dropdown with Margin-Right -->
        <div class="dropdown ms-lg-3" style="margin-right: 50px;">
            <button class="btn btn-secondary dropdown-toggle position-relative" 
                    type="button" id="authDropdown" 
                    data-bs-toggle="dropdown" aria-expanded="false"
                    style="border-radius: 20px;">
                <i class="fas fa-user me-2"></i>{{ Auth::check() ? Auth::user()->firstName : 'Account' }}
        
                <!-- Hardcoded Notification Bell with count (set to 3 unread notifications for example) -->
                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 12px;">
                    8
                </span>
            </button>
        
            <ul class="dropdown-menu shadow border-0 rounded" aria-labelledby="authDropdown">
                @if (!Auth::check())
                    <!-- Guest Links -->
                    <li>
                        <a class="dropdown-item" href="{{ route('account.login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('account.registration') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </li>
                @else
                    @if (Auth::user()->role == 'admin')
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role == 'user' || Auth::user()->role == 'admin')
                        <li>
                            <a class="dropdown-item" href="{{ route('account.createJob') }}">
                                <i class="fas fa-briefcase me-2"></i>Post a Job
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role == 'freelancer')
                        <li>
                            <a class="dropdown-item" href="{{ route('account.show', ['id' => Auth::user()->id]) }}">
                                <i class="fas fa-user-circle me-2"></i>My Account
                            </a>
                        </li>
                    @endif

                    <!-- Notifications Link (Hardcoded 3 unread notifications) -->
                    <li>
                        <a class="dropdown-item {{ 3 > 0 ? 'bg-light' : '' }}" href="#">
                            <i class="fas fa-bell me-2"></i> Notifications
                            <span class="badge bg-danger text-white rounded-circle position-absolute" style="font-size: 12px; top: 5px; right: 5px;">
                                3
                            </span>
                        </a>
                    </li>

                    <!-- Messages Link (Hardcoded 5 unread messages) -->
                    <li>
                        <a class="dropdown-item {{ 5 > 0 ? 'bg-light' : '' }}" href="#">
                            <i class="fas fa-envelope me-2"></i> Messages
                            <span class="badge bg-danger text-white rounded-circle position-absolute" style="font-size: 12px; top: 5px; right: 5px;">
                                5
                            </span>
                        </a>
                    </li>
            
                    <li class="dropdown-divider"></li>
            
                    <!-- My Account Link -->
                    <li>
                        <a class="dropdown-item" href="{{ route('account.show', ['id' => Auth::user()->id]) }}">
                            <i class="fas fa-user me-2"></i>My Account
                        </a>
                    </li>
                    <!-- Logout Link -->
                    <li>
                        <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        
    </div>
</nav>

<!-- Navbar End -->
@yield('main')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profilePicForm" name="profilePicForm" action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
				<p class="text-danger" id="image-error"></p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Company Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-4">Company</h5>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-info-circle me-2"></i>About Us</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-phone-alt me-2"></i>Contact Us</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-cogs me-2"></i>Our Services</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-shield-alt me-2"></i>Privacy Policy</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-file-contract me-2"></i>Terms & Conditions</a>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-4">Quick Links</h5>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-briefcase me-2"></i>Jobs</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-comments me-2"></i>Career Advice</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-blog me-2"></i>Blog</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-question-circle me-2"></i>FAQs</a>
                <a class="btn btn-link text-white-50" href=""><i class="fas fa-users me-2"></i>Community</a>
            </div>

            <!-- Contact Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-4">Contact</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social me-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social me-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social me-2" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-4">Newsletter</h5>
                <p>Stay updated with our latest news and job postings. Subscribe now!</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                        <i class="fas fa-paper-plane"></i> SignUp
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved. 
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href=""><i class="fas fa-home me-2"></i>Home</a>
                        <a href=""><i class="fas fa-cookie-bite me-2"></i>Cookies</a>
                        <a href=""><i class="fas fa-question-circle me-2"></i>Help</a>
                        <a href=""><i class="fas fa-info-circle me-2"></i>FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

</div>

<!-- JQuery (Use a single version) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (Ensure it matches the CSS version) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Additional Libraries -->
<script src="{{ asset('js/wow/wow.min.js') }}"></script>
<script src="{{ asset('js/easing/easing.min.js') }}"></script>
<script src="{{ asset('js/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>

<!-- Trumbowyg (Text Editor) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" 
        integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Custom and Template Scripts -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>



<script>
	$('.textarea').trumbowyg();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$("#profilePicForm").submit(function(e){
		e.preventDefault();

		var formData = new FormData(this);

		$.ajax({
			url: '{{ route("account.updateProfilePic") }}',
			type: 'post',
			data: formData,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function(response) {
				if(response.status == false) {
					var errors = response.errors;
					if (errors.image) {
						$("#image-error").html(errors.image)
					}
				} else {
					window.location.href = '{{ url()->current() }}'
				}
			}
		});
	});
</script>
@yield('customJs')
</body>
</html>