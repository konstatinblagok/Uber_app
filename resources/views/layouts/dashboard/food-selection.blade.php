@extends('dashboard')
@section('dashboard-content')
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Update Profile</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container">

            <div class="row">
                <div class="col-md-offset-2 col-sm-8">
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                    @endforeach
                            </div>
                            @endif

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('user.update') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div id="profile-container" class="row">
                                        <image id="profileImage" class="col-md-offset-5" src="{{asset($user->picture_url)}}" />
                                    </div>
                                    <input id="imageUpload" type="file" name="picture"
                                           placeholder="Photo">

                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">First name</label>
                                    <div class="col-md-10">
                                        <input id="fst_name" placeholder="First Name" type="text"
                                               class="form-control @error('fst_name') is-invalid @enderror"
                                               name="fst_name" value="{{ $user->fst_name }}"
                                               required autocomplete="fst_name" autofocus>

                                    </div>
                                        @error('fst_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Last name</label>
                                    <div class="col-md-10">
                                        <input id="lst_name" placeholder="First Name" type="text"
                                               class="form-control @error('lst_name') is-invalid @enderror"
                                               name="lst_name" value="{{ $user->lst_name }}"
                                               required autocomplete="lst_name" autofocus>

                                    </div>
                                    @error('lst_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-email">Email</label>
                                    <div class="col-md-10">
                                        <p class="form-control-static">{{$user->email}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Contact #</label>
                                    <div class="col-md-10">
                                        <input type="number" name="phone" class="form-control" value="{{$user->phone}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address</label>
                                    <div class="col-md-10">
                                        <textarea name="address" class="form-control">{{$user->address}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-6">
                                        <button type="submit"
                                               class="form-control btn btn-dark waves-effect waves-light m-t-10">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
