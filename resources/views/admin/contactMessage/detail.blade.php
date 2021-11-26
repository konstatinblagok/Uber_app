@extends('layouts.admin.app')

@section('title')

    <title>Admin | Contact Messages</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Contact Message Details</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contact.message.all') }}">Contact Messages</a></li>
                <li class="breadcrumb-item active">Contact Message Details</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Message Details
                            </h3>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">

                                    <span class="detailKey">ID</span><p class="detailValue">{{ $contact->id }}</p>

                                </div>
                               
                                <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">

                                    <span class="detailKey">Name</span><p class="detailValue">{{ $contact->name }}</p>

                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">

                                    <span class="detailKey">Email</span><p class="detailValue">{{ $contact->email }}</p>

                                </div>

                                <div class="col-12">

                                    <span class="detailKey">Subject</span><p class="detailValue">{{ $contact->subject }}</p>

                                </div>

                                <div class="col-12">

                                    <span class="detailKey">Message</span><p class="detailValue">{{ $contact->message }}</p>

                                </div>

                            </div>
                        
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
