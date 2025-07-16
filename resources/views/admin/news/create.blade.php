@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4 common_block_cls">
                    <h6 class="mb-4">{{ $title }}</h6>
                    <form action="{{ route('news_store') }}" method="post" id="categoryForm">
                        @csrf
                        <div class="row mb-3 pos_relt">
                            <label for="source_id" class="col-sm-2 col-form-label">Source Id<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="source_id" class="form-control" id="source_id" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="source_name" class="col-sm-2 col-form-label">Source Name<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="source_name" class="form-control" id="source_name" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="author" class="col-sm-2 col-form-label">Author<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="author" class="form-control" id="author" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="title" class="col-sm-2 col-form-label">Title<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="title" class="form-control" id="title" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="description" class="col-sm-2 col-form-label">Description<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="content" class="col-sm-2 col-form-label">Content<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="url" class="col-sm-2 col-form-label">Url<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="url" class="form-control" id="url" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="url_image" class="col-sm-2 col-form-label">Url Image<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="url_image" class="form-control" id="url_image" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="published_at" class="col-sm-2 col-form-label">Publish Date<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" name="published_at" class="form-control" id="published_at" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3 pos_relt">
                            <label for="status" class="col-sm-2 col-form-label">Status<span style="color: #FF0000">*</span></label>
                            <div class="col-sm-4 cstm_acti">
                                <select class="form-select" name="status" id="status" >
                                    <option value="Enabled" selected>Enable</option>
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
