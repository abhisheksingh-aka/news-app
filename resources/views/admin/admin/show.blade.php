@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    {{--<h6 class="mb-4" >Basic Table</h6>--}}
                    {{--<div class="pull-left"><a href="#" class="btn custom_create_btn">Add Category</a></div>--}}
                    <div class="panel-heading pa-0">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Categories</h6>
                        </div>
                        <div style="float: left !important;"><a href="#" class="btn btn-primary">Back</a></div>
                        <div style="float: right !important;"><a href="{{ route('user_create') }}" class="btn btn-primary">Добавь</a></div>
                        <div class="clearfix"></div>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ $user['name'] }}</td>
                            </tr>

                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ $user['email'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Role</th>
                                <td>{{ $user->Role['name'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{{ $user['status'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Created By</th>
                                <td>{{ $user->User['name'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Created At</th>
                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endSection
@section('js_content')
@endSection
