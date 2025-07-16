<script>
    $(document).off('change', "#country").on('change', "#country", function (e) {
        var country_id = $(this).val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: "{{ route('get_state') }}",
            type:"GET",
            data: {"country_id": country_id},
            success: function (result) {
                if(result){
                    var $selectDropdown = $("#state").empty().html('');
                    $selectDropdown.append($("<option></option>").attr("value", '').text('Select State')
                    );
                    $.each(result["state"], function (key, value) {
                        var id = value.id;
                        var name =  value.state_name;
                        $selectDropdown.append(
                            $("<option></option>")
                                .attr("value", id)
                                .text(name)
                        );
                    });
                    var $selectDropdownCity = $("#city").empty().html('');
                    $selectDropdownCity.append($("<option></option>").attr("value", '').text('Select City'));
                }
            }
        });
    });

    $(document).off('change', "#state").on('change', "#state", function (e) {
        var country_id = $("#country").val();
        var state_id = $(this).val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: "{{ route('get_city') }}",
            type:"GET",
            data: {"country_id": country_id, "state_id": state_id},
            success: function (result) {
                if(result){
                    var $selectDropdown = $("#city").empty().html('');
                    $selectDropdown.append($("<option></option>").attr("value", '').text('Select City')
                    );
                    $.each(result["city"], function (key, value) {
                        var id = value.id;
                        var name =  value.city_name;
                        $selectDropdown.append(
                            $("<option></option>")
                                .attr("value", id)
                                .text(name)
                        );
                    });
                }
            }
        });
    });
</script>