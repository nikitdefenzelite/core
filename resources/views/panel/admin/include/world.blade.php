<script>
    function getStates(countryId = 101) {
        $.ajax({
            url: '{{ route('world.get-states') }}',
            method: 'GET',
            data: {
                country_id: countryId
            },
            success: function(res) {
                $('#state').html(res).css('width', '100%').select2();
            }
        })
    }

    function getCities(stateId = 101) {
        $.ajax({
            url: '{{ route('world.get-cities') }}',
            method: 'GET',
            data: {
                state_id: stateId
            },
            success: function(res) {
                $('#city').html(res).css('width', '100%').select2();
            }
        })
    }
    $('#country').on('change', function(e) {
        getStates($(this).val());
    })

    $('#state').on('change', function(e) {
        getCities($(this).val());
    })

    getStates(101);


    function getStateAsync(countryId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route('world.get-states') }}',
                method: 'GET',
                data: {
                    country_id: countryId
                },
                success: function(data) {
                    $('#state').html(data);
                    $('.state').html(data);
                    resolve(data)
                },
                error: function(error) {
                    reject(error)
                },
            })
        })
    }

    function getCityAsync(stateId) {
        if (stateId != "") {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route('world.get-cities') }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(data) {
                        $('#city').html(data);
                        $('.city').html(data);
                        resolve(data)
                    },
                    error: function(error) {
                        reject(error)
                    },
                })
            })
        }
    }
</script>
