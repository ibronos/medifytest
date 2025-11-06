<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 0;
    var data_fetched = 0;

    $(document).ready(function() {

        var table = $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
            lengthMenu: [
                [5, 10, 15, -1], // Values for the dropdown
                [5, 10, 15, "All"] // Display text for the dropdown
            ]
        });

        getData();

    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_nama = $('#filter-nama').val()
        var filter_jenis = $('#filter-jenis').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("obat/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: 'nama=' + filter_nama,
            success: function(results) {
                var data = results.data

                console.log(data);

                $.each(data, function(index, item) {
                    array_temp = [];
                    var id = item.id;
                    var html = `<a href="{{url('obat/view/')}}/` + id + `" class="btn btn-primary">View</a>`

                    array_temp.push(item.id)
                    array_temp.push(item.nama)  
                    array_temp.push(item.jenis)
                    array_temp.push(html)

                    dataTableObj.row.add(array_temp).draw(true);
                });

                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
            
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }

                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>