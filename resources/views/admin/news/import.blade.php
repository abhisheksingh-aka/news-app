@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4 common_block_cls">
                    <h6 class="mb-4">{{ $title }}</h6>
                    <form action="{{ route('news_import_success') }}" method="post" id="categoryForm">
                        @csrf
                        <div class="row mb-3 pos_relt">
                            <label for="import_from" class="col-sm-2 col-form-label">Status<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-4 cstm_acti">
                                <select class="form-select" name="import_from" id="import_from" >
                                    <option value="" selected>Select</option>
                                    <option value="news_api" >News API</option>
                                    <option value="Disabled">Disable</option>
                                </select>
                            </div>
                        </div>
                        <a href="{{ route('news') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endSection
@section('js_content')
    <script>
        $(document).ready(function () {
            $('#is_sub_category').change(function () {
                if ($(this).is(':checked')) {
                    $('#parent_id').removeAttr('disabled');
                } else {
                    $('#parent_id').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endSection
