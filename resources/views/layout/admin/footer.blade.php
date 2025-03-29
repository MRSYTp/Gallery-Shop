</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="/admin/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="/admin/plugins/chart.js/Chart.min.js"></script>
<script src="/admin/dist/js/demo.js"></script>
@if(Route::currentRouteName() === 'admin.index')
<script>
    $(function () {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode      = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    var salesChart  = new Chart($salesChart, {
        type   : 'bar',
        data   : {
        labels  : {!! json_encode($salesData['labels']) !!},
        datasets: [
            {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           :  {!! json_encode($salesData['currentYear']) !!}
            },
            {
            backgroundColor: '#ced4da',
            borderColor    : '#ced4da',
            data           : {!! json_encode($salesData['previousYear']) !!}
            }
        ]
        },
        options: {
        maintainAspectRatio: false,
        tooltips           : {
            mode     : mode,
            intersect: intersect
        },
        hover              : {
            mode     : mode,
            intersect: intersect
        },
        legend             : {
            display: false
        },
        scales             : {
            yAxes: [{
            // display: false,
            gridLines: {
                display      : true,
                lineWidth    : '4px',
                color        : 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                }
                return '$' + value
                }
            }, ticksStyle)
            }],
            xAxes: [{
            display  : true,
            gridLines: {
                display: false
            },
            ticks    : ticksStyle
            }]
        }
        }
    })

    })
</script>
@endif
<script src="/admin/plugins/ckeditor/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

</script>

<script>
    $(document).ready(function() {
        $('.order-details').click(function() {
            var orderId = $(this).data('order-id');
            console.log('درخواست برای order_id:', orderId);

            $.ajax({
                url: "{{ route('admin.orders.orderDetails') }}",
                type: 'POST',
                data: {
                    order_id: orderId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log('پاسخ دریافت شد:', response);

                    var tbody = $('#order_items_table tbody');
                    tbody.empty();

                    if (response.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">هیچ آیتمی یافت نشد!</td></tr>');
                    } else {
                        $.each(response, function(index, item) {
                            var row = `
                                        <tr>
                                            <td>
                                                <img src="/storage/${item.thumbnail_url}" class="product_img">
                                                ${item.title}
                                            </td>
                                            <td>${item.category}</td>
                                            <td><a href="${item.demo_url}" class="btn btn-default btn-icons" title="لینک دمو"><i class="fa fa-link"></i></a></td>
                                            <td><a href="${item.source_url}" class="btn btn-default btn-icons" title="لینک دانلود"><i class="fa fa-link"></i></a></td>
                                            <td>${item.amount.toLocaleString()} تومان</td>
                                        </tr>
                                    `;
                            tbody.append(row);
                        });
                    }

                    $('#order_items').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('خطا:', error);
                }
            });
        });

        
    });
</script>

</body>
</html>