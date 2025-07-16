@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="common_block_cls rounded h-100 p-4">

                    <h6 class="mb-4">{{ $title }}</h6>
                    <div class="col">
                        <img class="me-lg-2" src="{{ \Config::get('constants.server_host_url') }}profile/{{ $user->image }}" alt="" style="width: 50px;">
                    </div>
                    <form action="{{ route('admin_update') }}" method="post" id="userForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="full_name" class="col-sm-3 col-form-label">полное имя</label>
                                <input type="text" name="name" class="form-control" id="full_name" value="{{ $user->name }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="col-sm-3 col-form-label">Электронная почта</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-3 col-form-label">Телефон</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="password" class="col-sm-3 col-form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="relation" class="col-sm-4 col-form-label">Корабль связи</label>
                                <select class="form-select" id="relation" aria-label="Floating label select example" name="relation">
                                    <option>Выберите отношение</option>
                                    <option value="Single" @if($user->relation=='Single') selected @endif>Одиночный</option>
                                    <option value="Married" @if($user->relation=='Married') selected @endif>Женат</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="company" class="col-sm-3 col-form-label">Компания</label>
                                <input type="text" name="company" class="form-control" id="company" value="{{ $user->company }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="address" class="col-sm-3 col-form-label">Адрес</label>
                                <input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="street" class="col-sm-3 col-form-label">Улица</label>
                                <input type="text" name="street" class="form-control" id="street" value="{{ $user->address_street }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="zipcode" class="col-sm-4 col-form-label">Почтовый индекс</label>
                                <input type="text" name="zipcode" class="form-control" id="zipcode" value="{{ $user->address_zipcode }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="country" class="col-sm-3 col-form-label">Страна</label>
                                <select class="form-select" id="country" name="country" aria-label="Floating label select example">
                                    <option value="">Выберите страну</option>
                                    @foreach($countryList as $country)
                                        <option value="{{ $country->id }}" @if($user->address_country==$country->id) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="state" class="col-sm-3 col-form-label">Государство</label>
                                <select class="form-select" id="state" name="state" aria-label="Floating label select example">
                                    <option value="">Выберите состояние</option>
                                    @foreach($stateList as $state)
                                        <option value="{{ $state->id }}" @if($user->address_state==$state->id) selected @endif>{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="city" class="col-sm-3 col-form-label">Город</label>
                                <select class="form-select" id="city" name="city" aria-label="Floating label select example">
                                    <option value="">Выберите город</option>
                                    @foreach($cityList as $city)
                                        <option value="{{ $city->id }}" @if($user->address_city==$city->id) selected @endif>{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="dob" class="col-sm-4 col-form-label">дата рождения</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ $user->dob }}" min="1960-01-01" max="@php date("Y-m-d") @endphp" />
                            </div>
                            <div class="col-sm-4">
                                <label for="city" class="col-sm-4 col-form-label">Роль</label>
                                <select class="form-select" id="role" aria-label="Floating label select example" name="role">
                                    <option>Выберите роль</option>
                                    @foreach($roleList as $role)
                                        <option value="{{ $role->id }}" @if($user->role_id==$role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="company" class="col-sm-3 col-form-label">Статус</label>
                                <select class="form-select" id="status" name="status" aria-label="Floating label select example">
                                    <option value="Active" @if($user->status=='Active') selected @endif>Активный</option>
                                    <option value="Inactive" @if($user->status=='Inactive') selected @endif>Неактивный</option>
                                    <option value="Disabled" @if($user->status=='Disabled') selected @endif>Нетрудоспособный</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="gender" class="col-sm-3 col-form-label">Пол</label>
                                <select class="form-select" id="gender" name="gender" aria-label="Floating label select example">
                                    <option selected>Выберите пол</option>
                                    <option value="Male" @if($user->gender=='Male') selected @endif>Самец</option>
                                    <option value="Female" @if($user->gender=='Female') selected @endif>Женский</option>
                                </select>
                            </div>
                            <div class="row col-sm-6">
                                <label for="profile_image" class="col-sm-10 col-form-label">Profile Image</label>
                                <input class="form-control" type="file" name="profile_image" id="profile_image" accept="image/*">
                            </div>
                        </div>
                        <input type="hidden" value="{{ $user['id'] }}" name="id">
                        <a href="{{ route('admin') }}" class="btn btn-secondary">Отменить</a>
                        @if(in_array('admin_update', Session('capability')))
                        <button type="submit" class="btn btn-primary">Обновление</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endSection
@section('js_content')
    @include('admin.admin.userjs')
@endSection
