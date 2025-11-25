@extends('layouts.commonMaster')
@section('layoutContent')

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Orders /</span> Help-Support
        </h4>

        <!-- Order List Widget -->

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="all" >
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-2">{{isset($total_help_requests)?$total_help_requests:''}}</h3>
                                    <p class="mb-0">Total Help Request</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-calendar bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                       <!--  <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="pending" >-->
                       <!--     <div-->
                       <!--         class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">-->
                       <!--         <div>-->
                       <!--             <h3 class="mb-2" id="pending-count">{{isset($orders_pending)?$orders_pending:''}}</h3>-->
                       <!--             <p class="mb-0">Pending</p>-->
                       <!--         </div>-->
                       <!--         <div class="avatar me-lg-4">-->
                       <!--             <span class="avatar-initial rounded bg-label-secondary">-->
                       <!--                 <i class="bx bx-error-alt bx-sm"></i>-->
                       <!--             </span>-->
                       <!--         </div>-->
                       <!--     </div>-->
                       <!--     <hr class="d-none d-sm-block d-lg-none">-->
                       <!-- </div>-->
                       <!--<div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="accepted"  >-->
                       <!--     <div-->
                       <!--         class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">-->
                       <!--         <div>-->
                       <!--             <h3 class="mb-2" id="accepted-count" >{{isset($orders_accepted)?$orders_accepted:''}}</h3>-->
                       <!--             <p class="mb-0">Accepted</p>-->
                       <!--         </div>-->
                       <!--         <div class="avatar me-sm-4">-->
                       <!--             <span class="avatar-initial rounded bg-label-secondary">-->
                       <!--                 <i class="bx bx-check-double bx-sm"></i>-->
                       <!--             </span>-->
                       <!--         </div>-->
                       <!--     </div>-->
                       <!-- </div>-->
                       <!-- <div class="col-sm-6 col-lg-3 customInput"  type="button" data-type="rejected">-->
                       <!--     <div class="d-flex justify-content-between align-items-start">-->
                       <!--         <div>-->
                       <!--              <h3 class="mb-2" id="rejected-count" >{{isset($admin_rejected)?$admin_rejected:''}}</h3>-->
                       <!--             <p class="mb-0">Rejected</p>-->
                       <!--         </div>-->
                       <!--         <div class="avatar">-->
                       <!--             <span class="avatar-initial rounded bg-label-secondary">-->
                       <!--                 <i class="bx bx-x bx-sm"></i>-->
                       <!--             </span>-->
                       <!--         </div>-->
                       <!--     </div>-->
                       <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Order List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-order table border-top">
                    <thead>
                      
                        <tr>
                            <th>Sl No</th>
                            <th>Order Id</th>
                            <th>Message</th>
                            <th class="text-nowrap">Message Time</th>
                           
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- / Content -->
    <!-- <script src="{{asset('assets/js/app-ecommerce-order-list.js')}}"></script> -->
    <script>


$(document).ready(function() {

        
     var getType = null;
    
     $(document).on('click','.customInput',function(){
        
        getType=$(this).data('type');
        if(getType=='rejected'){
            $('#custom-heading').text('Rejected Orders');
        }else if(getType=='pending'){
             $('#custom-heading').text('Pending Orders');
        }else if(getType=='accepted'){
            $('#custom-heading').text('Accepted Orders');
        }else{
             $('#custom-heading').text('Total Orders');
        }
        $('.datatables-order').DataTable().ajax.reload();
    });
        
       var table = $('.datatables-order').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "{{route('get.orders.help')}}",
                "type": "GET",
                "data": function(d) {
                     d.type = getType;
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "order_id" },
                { "data": "help_support" },
                { "data": "created_at" },
                
           ],
            dom: 'lBfrtip',
        buttons: [
             'excel', 'print'
        ]
             
        });
    });
    

// function Shipping_details(id){
    
//       Swal.fire({
//         title: "Enter reject reason",
//         html: `
//             <input type="text" id="tracking_id" class="form-control" placeholder="Enter Tracking Id" />
//           <textarea type="text" id="tracking_link" class="form-control mt-3 " placeholder="Enter Tracking Link "></textarea>
//         `,
//         focusConfirm: false,
//         showCancelButton: true,
//         preConfirm: () => {
//           const tracking_id = Swal.getPopup().querySelector('#tracking_id').value;
//           const tracking_link = Swal.getPopup().querySelector('#tracking_link').value;
        
//           if (!tracking_id) {
//             Swal.showValidationMessage(`Please enter tracking id`);
//           }
//           if (!tracking_link) {
//             Swal.showValidationMessage(`Please enter tracking link`);
//           }
//           return { tracking_id: tracking_id, tracking_link:tracking_link };
//         }
//       }).then((result) => {
//         if (result.isConfirmed) {
//           const tracking_id = result.value.tracking_id;
//           const tracking_link = result.value.tracking_link;

//           $.ajax({
//             url: "{{'shipping-order-details'}}",
//             method: "POST",
//             data: { id: id, _token:'{{csrf_token()}}',  tracking_id: tracking_id, tracking_link: tracking_link },
//             success: function(response) {
              
//               var $acceptedCount = $('#accepted-count');
//               var currentValue = parseInt($acceptedCount.text()) || 0;
//               if($acceptedCount>0)
//               $acceptedCount.text(currentValue + 1);
              
//               var $pendingCount = $('#pending-count');
//               var currentValue = parseInt($pendingCount.text()) || 0;
//               if($pendingCount>0)
//               $pendingCount.text(currentValue - 1);
              
//               Swal.fire({
//                 title: "Success!",
//                 text: "You're changes saved successfully.",
//                 icon: "success"
//               });
//               $('.datatables-order').DataTable().ajax.reload();
//             },
//             error: function(xhr, status, error) {
//               Swal.fire({
//                 title: "Error!",
//                 text: "Failed to cancel the order.",
//                 icon: "error"
//               });
//             }
//           });
//         }
//       });
     
    
// }    
    

</script>
    @endsection
