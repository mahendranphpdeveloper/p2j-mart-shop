@extends('layouts.commonMaster')
@section('layoutContent')
<style>
    @media print {
    .no-print {
        display: none;
    }
}
</style>
<!-- Content wrapper -->
<div class="content-wrapper">

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

<div class="row invoice-preview">
                    <!-- Invoice -->
                    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                        <div class="card invoice-preview-card">
                            <div class="card-body">
                                <div
                                    class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                                    <div class="mb-xl-0 mb-4">
                                        <div class="d-flex svg-illustration mb-3 gap-2">

                                        <div class="app-brand demo">

                                                    <span class="app-brand-logo demo">
                                                        <img src="{{asset('assets/img/logo.png')}}" style="width:36px;">
                                                    </span>
                                                    <span class="app-brand-text menu-text fw-bold ms-2">New Trends</span>

                                          </div>

                                        </div>
                                        <p class="mb-1">New Trends,</p>
                                        <p class="mb-1">The New Trends Fashions, Chennai, 600045</p>
                                        <p class="mb-0">+1 (123) 456 7891, antiquejewels@gmail.com</p>
                                    </div>
                                    <div>
                                        <h4></h4>
                                        <div class="mb-2">
                                            <span class="me-1">Date Issues:</span>
                                            <span class="fw-medium">{{date('d-m-Y')}}</span>
                                        </div>
                                        <div>
                                            <span class="me-1">Date Ordered:</span>
                                            <span class="fw-medium">{{date('d-m-Y',strtotime($invoice[0]->created_at))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                <div class="row p-sm-3 p-0">
                                    <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                        <h6 class="pb-2">Invoice From:</h6>
                                        <p class="mb-1">New Trends,</p>
                                        <p class="mb-1">The New Trends Fashions</p>
                                        <p class="mb-1">Chennai</p>
                                        <p class="mb-1">600045</p>
                                        <p class="mb-0">antiquejewels@gmail.com</p>
                                    </div>
                                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                        <h6 class="pb-2">Bill To:</h6>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="pe-3">Name:</td>
                                                    <td>{{$invoice[0]->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-3">Address:</td>
                                                    <td>{{$invoice[0]->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-3">Mobile No:</td>
                                                    <td>{{$invoice[0]->mobile_no}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table border-top m-0">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap">{{$invoice[0]->pro_name}}</td>
                                            <td class="text-nowrap">{{$invoice[0]->description}}</td>
                                            <td>₹{{$invoice[0]->price}}</td>
                                            <td>{{$invoice[0]->qty}}</td>
                                            <td>₹{{$invoice[0]->price*$invoice[0]->qty }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="align-top px-4 py-5">
                                                <p class="mb-2">
                                                    <span class="me-1 fw-medium">Salesperson:</span>
                                                    <span>New Trends</span>
                                                </p>
                                                <span>Thanks for your Order</span>
                                            </td>
                                            <td class="text-end px-4 py-5">
                                                <p class="mb-2">Subtotal:</p>
                                                <p class="mb-2">Discount:</p>
                                                <p class="mb-2">Tax:</p>
                                                <p class="mb-0">Total:</p>
                                            </td>
                                            <td class="px-4 py-5">
                                                <p class="fw-medium mb-2">₹{{$invoice[0]->price*$invoice[0]->qty}}</p>
                                                <p class="fw-medium mb-2">₹00.00</p>
                                                <p class="fw-medium mb-2">₹00.00</p>
                                                <p class="fw-medium mb-0">₹{{$invoice[0]->price*$invoice[0]->qty}}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-body d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="fw-medium">Note:</span>
                                        <span>It was a pleasure working with you and your team. We hope you will keep us in mind
                                            for future freelance
                                            projects. Thank You!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3  no-print">

      <div>
          <button id="downloadPDFButton"class="btn btn-label-success d-grid w-100 mb-3" class="btn btn-primary">Download</button>
      </div>
      <div>
          <button onclick="printPage()" id="printButton"class="btn btn-label-info d-grid w-100 mb-3" class="btn btn-secondary">Print</button>
      </div>
      <div>
      <a href="{{route('orders.index')}}" class="btn btn-label-info d-grid w-100 mb-3" class="btn btn-secondary">Back to Orders</a>
      </div>

                    </div>
                    <!-- /Invoice -->

                </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


<script>

function printPage() {
      window.print();
}

document.getElementById('downloadPDFButton').addEventListener('click', function() {

    var divToCapture = document.querySelector('.card.invoice-preview-card');
    html2canvas(divToCapture, {
        backgroundColor: 'white'
    }).then(function(canvas) {

        var imgData = canvas.toDataURL('image/png');
        var imgWidth = 180;
        var pageHeight = imgWidth * canvas.height / canvas.width;

        var pdf = new jsPDF('p', 'mm', 'a4');
        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, pageHeight);
        pdf.save('Invoice.pdf');
    });
});
</script>
    <!-- / Content -->

    @endsection
