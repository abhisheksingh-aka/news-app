@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class=" rounded h-100 p-4 common_block_cls">
                    <h6 class="mb-4">{{ $title }}</h6>
                    <form action="{{ route('admin_store') }}" method="post" id="userForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="full_name" class="col-sm-3 col-form-label">полное имя</label>
                                <input type="text" name="name" class="form-control" id="full_name" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="col-sm-3 col-form-label">Электронная почта</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-3 col-form-label">Телефон</label>
                                <input type="text" name="phone" class="form-control" id="phone" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="password" class="col-sm-3 col-form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="relation" class="col-sm-4 col-form-label">Корабль связи</label>
                                <select class="form-select" id="relation" aria-label="Floating label select example" name="relation">
                                    <option value="" selected>Выберите отношение</option>
                                    <option value="Single">Одиночный</option>
                                    <option value="Married">Женат</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="company" class="col-sm-3 col-form-label">Компания</label>
                                <input type="text" name="company" class="form-control" id="company">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="address" class="col-sm-3 col-form-label">Адрес</label>
                                <input type="text" name="address" class="form-control" id="address">
                            </div>
                            <div class="col-sm-4">
                                <label for="street" class="col-sm-3 col-form-label">Улица</label>
                                <input type="text" name="street" class="form-control" id="street">
                            </div>
                            <div class="col-sm-4">
                                <label for="zipcode" class="col-sm-4 col-form-label">Почтовый индекс</label>
                                <input type="text" name="zipcode" class="form-control" id="zipcode">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="country" class="col-form-label">Страна</label>
                                <select class="form-select" id="country" name="country" aria-label="Floating label select example">
                                    <option value="" selected>Выберите страну</option>
                                    @foreach($countryList as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="state" class="col-form-label">Государство</label>
                                <select class="form-select" id="state" name="state" aria-label="Floating label select example">
                                    <option value="" selected>Выберите состояние</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="city" class="col-form-label">Город</label>
                                <select class="form-select" id="city" name="city" aria-label="Floating label select example">
                                    <option value="" selected>Выберите город</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="dob" class="col-sm-4 col-form-label">дата рождения</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="2018-07-22" min="1960-01-01" max="@php date("Y-m-d") @endphp" />

                            </div>
                            <div class="col-sm-4">
                                <label for="city" class="col-sm-4 col-form-label">Роль</label>
                                <select class="form-select" id="role" aria-label="Floating label select example" name="role">
                                    <option selected>Выберите роль</option>
                                    @foreach($roleList as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="company" class="col-sm-3 col-form-label">Статус</label>
                                <div class="col-sm-12">
                                    <select class="form-select" id="status" name="status" aria-label="Floating label select example">
                                        <option value="Active" selected>Активный</option>
                                        <option value="Inactive">Неактивный</option>
                                        <option value="Disabled">Нетрудоспособный</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="gender" class="col-sm-3 col-form-label">Пол</label>
                                <select class="form-select" id="gender" name="gender" aria-label="Floating label select example">
                                    <option selected>Выберите пол</option>
                                    <option value="Male">Самец</option>
                                    <option value="Female">Женский</option>
                                </select>
                            </div>
                            <div class="row col-sm-6">
                                <label for="company" class="col-sm-10 col-form-label">Profile Image</label>
                                <input class="form-control" type="file" name="profile_image" accept="image/*">
                            </div>
                        </div>
                        <a href="{{ route('admin') }}" class="btn btn-secondary">Отменить</a>
                        @if(in_array('admin_save', Session('capability')))
                        <button type="submit" class="btn btn-primary">Создавать</button>
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
