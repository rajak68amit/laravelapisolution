@extends('layouts.appone')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userDataList as $key =>$userDataLists)

                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$userDataLists->name}}</td>
                        <td>{{$userDataLists->address}}</td>
                        <td>{{$userDataLists->gender}}</td>
                        <td>{{ucfirst($userDataLists->status)}}</td>
                    </tr>
                    @empty
                    <tr>
                        <th scope="row">Data Not Available</th>

                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
