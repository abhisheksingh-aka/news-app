@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4 table_cm_cls">
                    @if(\Illuminate\Support\Facades\Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4>{{ Session::get('success') }}</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="panel-heading pa-0">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ $title }}</h6>
                        </div>
                            <div style="float: right !important;"><a href="{{ route('news_create') }}" class="btn btn-primary">Create</a></div>
                            <div><a href="{{ route('news_import') }}" class="btn btn-primary">Import</a></div>
                        <div class="clearfix"></div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Status</th>
                            <th scope="col">Published</th>
                            <th scope="col">Created</th>
                            <th scope="col" width="5%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newsList as $row)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ substr($row['title'],0,20) }}</td>
                            <td>{{ substr($row['content'],0,50) }}</td>
                            <td>
                                @if($row['status'] == 'Enabled')
                                    <span class="status-active">Enabled</span>

                                @else
                                    <span class="status-disable">Disabled</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row['published_at'])->format('d-m-Y')}}</td>
                            <td>{{ \Carbon\Carbon::parse($row['created_at'])->format('d-m-Y')}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ route('news_edit',$row['id']) }}"> Edit </a></li>
                                            @if($row['status'] == 'Enabled')
                                                <li class="border-bottom"><a class="dropdown-item" href="{{ route('news_delete',$row['id']) }}"> <span class="status-disable">Disable</span> </a></li>
                                            @else
                                                <li class="border-bottom"><a class="dropdown-item" href="{{ route('news_delete',$row  ['id']) }}"> <span class="status-active">Enable</span> </a></li>
                                            @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="">
                        {!! $newsList->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endSection
@section('js_content')
@endSection
