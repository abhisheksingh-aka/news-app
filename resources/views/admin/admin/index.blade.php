@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="rounded h-100 p-4 table_cm_cls" >
                    {{--<h6 class="mb-4" >Basic Table</h6>--}}
                    {{--<div class="pull-left"><a href="#" class="btn custom_create_btn">Add Category</a></div>--}}
                    <div class="panel-heading pa-0">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Admin List</h6>
                        </div>
                            {{--<div style="float: left !important;"><a href="#" class="btn btn-primary">Back</a></div>--}}
                        @if(in_array('admin_add', Session('capability')))
                            <div style="float: right !important;"><a href="{{ route('admin_create') }}" class="btn btn-primary">Добавь</a></div>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">полное имя</th>
                            <th scope="col">Адрес электронной почты</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col", width="5%">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userList as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><a href ="{{ route('admin_show',$user['id']) }}" >{{ $user['name'] }}</a></td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                @if($user['status'] == 'Active')
                                    <span class="status-active">Активный</span>
                                @elseif($user['status'] == 'Inactive')
                                    <span class="status-inactive">Неактивный</span>
                                @else
                                    <span class="status-disable">Нетрудоспособный</span>
                                @endif
                            </td>
                            <td>{{ $user->Role['name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y')}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Действие</button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @if(in_array('admin_reset_password', Session('capability')))
                                            <li><a class="dropdown-item reset_password" href="#" data-id="{{ $user['id'] }}" data-email="{{ $user['email'] }}">сброс пароля</a></li>
                                        @endif
                                        @if(in_array('admin_edit', Session('capability')))
                                            <li><a class="dropdown-item" href="{{ route('admin_edit',$user['id']) }}">  Редактировать </a></li>
                                        @endif
                                        @if(in_array('admin_delete', Session('capability')))
                                            @if($user['status'] == 'Active')
                                                <li><a class="dropdown-item" href="{{ route('admin_delete',$user['id']) }}"> <span class="status-disable">Нетрудоспособный</span> </a></li>
                                            @else
                                                <li><a class="dropdown-item" href="{{ route('admin_delete',$user['id']) }}"> <span class="status-active">Активный</span> </a></li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $userList->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--modal-->
    @if(Session('clientUser')['id'] == '1')
    @include('admin.common.modal.reset_password_modal')
    @endif
<!--modal-->
    <!-- Table End -->
@endSection
@section('js_content')
<script>
    $(document).off('click', '.reset_password').on('click', '.reset_password', function (e) {
        var id = $(this).attr('data-id');
        var email = $(this).attr('data-email');
        $('#email').val(email);
        $('#add_education_popup').modal("show");
    });
</script>
@endSection
