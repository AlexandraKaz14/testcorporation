<script>
    document.addEventListener('DOMContentLoaded', function () {

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function (i) {
                    $(this).html(i+1);
                });
            };

        $("{{$selector}} tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex,
        }).disableSelection();

        $("{{$selector}} tbody").sortable({
            distance: 5,
            delay: 100,
            opacity: 0.6,
            cursor: 'move',
            cancel: '.fixedresult',
            items: 'tr:not(.fixedresult)',
            update: function() {

                var fd = new FormData();
                fd.append('_token', "{{ csrf_token() }}")
                $("{{$selector}} tbody tr:not(.fixedresult)").each(function (index){
                    let id = $(this).data().id
                    fd.append( 'values[]', `${id},${index+1}` );
                });

                $.ajax({
                    url: '{{$updateSequenceUrl}}',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){
                    }
                });

            }
        });

    });
</script>
