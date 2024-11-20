@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Hired Job Transaction</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>

                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4">
                        <div class="container"> 
                            <div class="row m-0"> 
                                <div class="col"> 
                                    <div class="row"> 
                                        <div class="col-12 px-0 mb-4"> 
                                            <div class="box-right"> 
                                                <div class="d-flex pb-2"> 
                                                    <p class="fw-bold h7">
                                                        <span class="text-muted">
                                                            Transaction ID: 
                                                        </span>
                                                    </p> 
                                                </div> 

                                                <a href="">Job Posting ID</a>                                       
                                            </div> 
                                        </div> 

                                        <div class="col-12 mb-4"> 
                                            <div class="row box-right"> 
                                                <div class="col-md-8 ps-0 "> 
                                                    <p class="ps-3 textmuted fw-bold h6 mb-0 pb-3">EXPECTED SALARY</p> 
                                                    <p class="h1 fw-bold d-flex"> 
                                                        <span class=" fas fa-dollar-sign textmuted pe-1 h6 align-text-top mt-1"></span>
                                                        84,254 
                                                        <span class="textmuted">.58</span> 
                                                    </p> 
                                                </div> 
                                            </div> 
                                        </div> 

                                        <div class="col-12 px-0 mb-4"> 
                                            <div class="box-right"> 
                                                <div class="d-flex pb-2"> 
                                                    <p class="fw-bold h7">
                                                        <span class="">
                                                            Interview and Assessment 
                                                        </span>
                                                        Link
                                                    </p> 
                                                </div> 

                                                <div id="col">
                                                    <input type="text" name="" value="ZOOM" id="myInput" class="p-blue bg btn btn-primary h8" readonly>
                                                    <button class="btn btn-primary flex text-center justify-center" id="clipboard" onclick="myFunction()">Copy Link</button>
                                                </div>                                                
                                            </div> 
                                        </div> 

                                        <div class="col-12 px-0 rounded" style="background: wheat"> 
                                            <div class="box-right"> 
                                                <div class="d-flex mb-2"> 
                                                    <p class="fw-bold">
                                                        Job Status
                                                    </p> 
                                                </div> 
                                                {{-- <div class="d-flex mb-2"> 
                                                        <p class="h7">
                                                            #AL2545
                                                        </p> 
                                                        <p class="ms-auto bg btn btn-primary p-blue h8">
                                                            <span class="far fa-clone pe-2"></span>
                                                            COPY PAYMENT LINK 
                                                        </p> 
                                                </div>  --}}
                                                <div class="row"> 
                                                    <div class="progress-track">
                                                        <ul id="progressbar">
                                                            <li class="step0 active " style="color:black" id="step1">Initial Interview</li>
                                                            <li class="step0 active text-center" style="color: black" id="step2">Assessment</li>
                                                            <li class="step0 active text-right text-end" style="color: black" id="step3"><span id="three">Final Interview</span></li>
                                                            <li class="step0 text-right text-end" style="color: black" id="step4">Hired</li>
                                                        </ul>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                                {{-- <div class="col-md-5 col-12 ps-md-5 p-0 "> 
                                    <div class="box-left"> 
                                        <p class="textmuted h8">
                                            Invoice
                                        </p> 
                                        <p class="fw-bold h7">
                                            Alex Parkinson
                                        </p> 
                                        <p class="textmuted h8">
                                            3897 Hickroy St, salt Lake city
                                        </p> 
                                        <p class="textmuted h8 mb-2">
                                            Utah, United States 84104
                                        </p> 
                                        <div class="h8"> 
                                            <div class="row m-0 border mb-3"> 
                                                <div class="col-6 h8 pe-0 ps-2"> 
                                                    <p class="textmuted py-2">
                                                        Items
                                                    </p> 
                                                    <span class="d-block py-2 border-bottom">
                                                        Legal Advising
                                                    </span> 
                                                    <span class="d-block py-2">
                                                        Expert Consulting
                                                    </span> 
                                                </div> 
                                                <div class="col-2 text-center p-0"> 
                                                    <p class="textmuted p-2">
                                                        Qty
                                                    </p> 
                                                    <span class="d-block p-2 border-bottom">
                                                        2
                                                    </span> 
                                                    <span class="d-block p-2">
                                                        1
                                                    </span> 
                                                </div> 
                                                <div class="col-2 p-0 text-center h8 border-end"> 
                                                    <p class="textmuted p-2">
                                                        Price
                                                    </p> 
                                                    <span class="d-block border-bottom py-2">
                                                        <span class="fas fa-dollar-sign"></span>
                                                        500
                                                    </span> 
                                                    <span class="d-block py-2 ">
                                                        <span class="fas fa-dollar-sign"></span>
                                                        400</span> 
                                                    </div> 
                                                    <div class="col-2 p-0 text-center"> 
                                                        <p class="textmuted p-2">
                                                            Total
                                                        </p> 
                                                        <span class="d-block py-2 border-bottom">
                                                            <span class="fas fa-dollar-sign"></span>
                                                            1000
                                                        </span> 
                                                        <span class="d-block py-2">
                                                            <span class="fas fa-dollar-sign"></span>
                                                            400
                                                        </span> 
                                                    </div> 
                                                </div> 
                                                <div class="d-flex h7 mb-2"> 
                                                    <p class="">
                                                        Total Amount
                                                    </p> 
                                                    <p class="ms-auto">
                                                        <span class="fas fa-dollar-sign"></span>
                                                        1400
                                                    </p> 
                                                </div> 
                                                <div class="h8 mb-5"> 
                                                    <p class="textmuted">
                                                        Lorem ipsum dolor sit amet elit. 
                                                        Adipisci ea harum sed quaerat tenetur 
                                                    </p> 
                                                </div> 
                                            </div> 
                                            <div class=""> 
                                                <p class="h7 fw-bold mb-1">
                                                    Pay this Invoice
                                                </p> 
                                                <p class="textmuted h8 mb-2">
                                                    Make payment for this invoice by filling in the details
                                                </p> 
                                                <div class="form"> 
                                                    <div class="row"> 
                                                        <div class="col-12"> 
                                                            <div class="card border-0"> 
                                                                <input class="form-control ps-5" type="text" placeholder="Card number"> 
                                                                <span class="far fa-credit-card"></span> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-6"> 
                                                            <input class="form-control my-3" type="text" placeholder="MM/YY"> 
                                                        </div> 
                                                        <div class="col-6"> 
                                                            <input class="form-control my-3" type="text" placeholder="cvv"> 
                                                        </div> 
                                                        <p class="p-blue h8 fw-bold mb-3">
                                                            MORE PAYMENT METHODS
                                                        </p> 
                                                    </div> 
                                                    <div class="btn btn-primary d-block h8">
                                                        PAY <span class="fas fa-dollar-sign ms-2"></span>
                                                        1400<span class="ms-3 fas fa-arrow-right"></span>
                                                    </div> 
                                                </div> 
                                            </div> 
                                        </div> 
                                    </div> 
                                </div>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("myInput");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection